<?php

namespace App\Controllers\Api\HCV\Administrativo;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');

use App\Models\HCV\Operativo\Ficha_Identificacion as model;
use App\Models\Administrador\Usuarios as usuarios;
use App\Models\Administrador\Groups as grupos;

class Ficha_operativo extends ResourceController {
  use ResponseTrait;
  var $model;
  var $db;
  var $usuarios;
  var $grupos;

  public function __construct(){ //Assign global variables
    $this->model = new model();
    $this->usuarios = new usuarios();
    $this->grupos = new grupos();
    $this->db = db_connect();
    helper('messages');
  }

  // Select con las opciones de grupo medico para el operativo
  public function getGroup(){
    $model_grupo = model('App\Models\groups_models\Crud_group_model');
    $data = $model_grupo->getGrupoMedico();
    return json_encode($data);
  }

  // Select con los datos de unidad de negocio para el operativo
  public function getBusinessUnit() {
    $model_unidad = model('App\Models\Catalogos\BusinessUnit');
    $data = $model_unidad->getBusinessUnits();
    return json_encode($data);
  }

  // create ficha de identificacion del operativo 
  public function create(){
    $validation = \Config\Services::validation();
    $request = \Config\Services::request();

    ($_POST['grupo_medico'] == 7) ? $id_catlab = $_POST['area_tomador']  : $id_catlab = 1;

    // Validacion de foto de perfil del operativo
    $file = $this->request->getFile('image');
    if (!$file->isValid()) {
      $file_name = "";
      $imagen = false;
    } else {
      // image validation
      $validated = $this->validate([
        'image' => [
          'uploaded[image]',
          'mime_in[image,image/jpg,image/jpeg,image/png]',
          'max_size[image,4096]',
          'is_image[image]'
        ],
      ]);
      if (!$validated) {
        $mensaje = $this->errors($error = 600);
        return $this->respond($mensaje);
      } else {
        $imagen = true;
      }
    } 
    //Renombramiento y ruta donde se guardara la foto de perfil 
    if($imagen) {
      $path =  '../public/uploads/medico/fotos';
      $newfile = $file->getRandomName();
      $file->move(WRITEPATH . $path, $newfile);
      $file_name = $file->getName(); 
    } 

    //Validacion de imagen del INE del operativo
    $ine = $this->request->getFile('file_ine');
    if (!$ine->isValid()) {
      $name_image = "";
      $imagen_ine = false;
    } else {
        // image validation
      $validacion_ine = $this->validate([
        'file_ine' => [
          'uploaded[file_ine]',
          //'mime_in[image,image/jpg,image/jpeg,image/png]',
          'max_size[file_ine,4096]',
          'is_image[file_ine]' 
        ],
      ]);
      if (!$validacion_ine) {
        $msg = $this->errors($error = 600);
        return $this->respond($msg);
      } else {
        $imagen_ine = true;
      } 
    }  
    //Renombramiento y ruta donde se guardara foto del INE
    if ($imagen_ine) {
      $ruta = "../public/uploads/medico/ine";
      $newname = $ine->getRandomName();
      $ine->move(WRITEPATH . $ruta, $newname);
      $name_image = $ine->getName();
    }

    $session = session();
    $user_id = $session->get('unique');
    $grupo = $session->get('group');
    //Si registro esa info el admin webcorp o back office del sistema
    if(($grupo == 1) || ($grupo == 2) ){
      $id_medico = $session->get('group');
    }else{ //Registro la informacion el propio usuario
      $id_medico = $user_id;
    } 
    //validar contraseña
    $password =  $_POST['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);
    $token = $this->generate_token(); 
    $user_model = model('App\Models\Administrador\Usuarios');
    // Arreglo a guardar en la tabla users
    $data = [
      "user_name" => $_POST['NAME'] . " " . $_POST["F_LAST_NAME"]," " .$_POST["S_LAST_NAME"],
      "id_group" => $_POST['grupo_medico'],
      "password" => $password,
      'activation_token' => $token,
      'email' => $_POST['correo'],
      'active' => 1,
    ];
    // Ver que no se repita el email en la base
    if ($user_model->insert($data) === false) {
      $error = $this->model->errors();
      $mensaje = [
        "status" => 400,
        "msg" => $error['email']
      ];
      return $this->respond($mensaje);
    } else {
      $id = $user_model->getInsertID();  
      //Arreglo del identity operativo
      $data_operativo = [
        'user_id' => $id, 
        'entry_time' => $request->getPost('hora_entrada'),
        'departure_time' => $request->getPost('hora_salida'),
        'NAME' => $request->getPost('NAME'),
        'F_LAST_NAME' => $request->getPost('F_LAST_NAME'),
        'S_LAST_NAME' => $request->getPost('S_LAST_NAME'),
        'BIRTHDATE' => $request->getPost('BIRTHDATE'),
        'PHONE_NUMBER' => $request->getPost('PHONE_NUMBER'),
        'DESC_PERSONAL' => $request->getPost('descrip'),
        'CAT_CP_ID' => $request->getPost('ID_CODE'),
        'delegacion' => $request->getPost('ID_CAT_MUNICIPALITY'),
        'estado' => $request->getPost('ID_CAT_STATE_OF_RESIDENCE'),
        'colonia' => $request->getPost('ID_CAT_TOWN'),
        'STREET_NUMBER' => $request->getPost('STREET'),
        'LATITUD' => $request->getPost('latitud'),
        'LONGITUD' => $request->getPost('longitud'),
        'disciplina_id' => $request->getPost('discip'),
        'especialidad_id' => $request->getPost('especialidad_id'),
        'NUMBER_PROFESSIONAL_CERTIFICATE' => $request->getPost('fcedula'),
        'NUMBER_SPECIALTY_CERTIFICATE' => $request->getPost('cedulaespe'),
        'FILE_USER' => $file_name,
        'FILE_INE' => $name_image,
        'id_category_lab' => $id_catlab
      ];
      // Save data_operativo
      $id_identity = $this->model->insert($data_operativo);

      //Arreglo para guardar mas de una unidad de negocio
      $model_unidades = model('App\Models\HCV\Operativo\Unidad_negocio');
      
      $long = count($_POST["unidad_negocio"]);
      for($i=0; $i<=$long-1; $i++){
        //$area = $request->getPost('unidad_negocio')[$i];
        $area = $request->getPost('unidad_negocio')[$i];
        $data_unidades = [
          'id_business_unit' => $area,
          'id_user' => $id
        ];
        $model_unidades->insert($data_unidades);
      }

      //Arreglo para guardar mas de un area del tomador de muestra
      $model_areas = model('App\Models\HCV\Operativo\Tomador_areas');

      $contArea = count($_POST["area_tomador"]);
      for($i=0; $i<=$contArea-1; $i++){
        $area = $request->getPost('area_tomador')[$i];
        $data_areas = [
          'id_category_lab' => $area,
          'id_user' => $id
        ];
        $model_areas->insert($data_areas);
      }

      $mensaje = messages($insert = 0, $id_identity);
      return $this->respond($mensaje); 
    }
}

  //Token a generar para el registro de usuario
  public function generate_token(){
    return bin2hex(random_bytes(24));
  }

  //Validacion del correo que no sea repetido
  public function validar_email($email){
    $model = model('App\Models\Administrador\Usuarios');
    $data = $model->select("email")->where("email", $email)->findAll();
    $total = count($data);
    return $total;
  }

  // Se obtienen los datos del operativo para poner en la Ficha
  public function getOperativo($id=null){
    $request = \Config\Services::request();
    $id = $request->getPost('id');
    $data = $this->model->get_medico($id);
    return $this->respond($data);
  }

  //Errores en caso de que no se cumplan las validaciones
  public function errors($error){
    switch ($error):
        case 600:
            $mensaje = "LA IMAGEN DEBE PESAR 4 MG Y DEBE SER JPG,JPEG,PNG";
            break;
    endswitch;

    $data = [
        "status" => 400,
        "msg" => $mensaje
    ];
    return $data;
  }

  // Tabla con las unidades de negocio que tiene cada operativo
  public function get_unidades(){
    $request = \Config\Services::request();
    $identity = model('App\Models\HCV\Operativo\Ficha_Identificacion');
    $id = $request->getPost('id');

    $id_user = $identity->unidades($id);
    $model_unidades = model('App\Models\HCV\Operativo\Unidad_negocio');
    $data["data"] = $model_unidades->get_unidades($id_user[0]['user_id']);
    return $this->respond($data);
  }

  // Tabla con las areas que tiene cada operativo
  public function get_areas(){
    $request = \Config\Services::request();
    $operativo_identity = model('App\Models\HCV\Operativo\Ficha_Identificacion');
    $id = $request->getPost('id');
    $id_user = $operativo_identity->unidades($id);

    $model_areas = model('App\Models\HCV\Operativo\Tomador_areas');
    $data["data"] = $model_areas->get_areas($id_user[0]['user_id']);
    return $this->respond($data);
  }

  // Eliminar unidades de negocio del operativo
  public function delete_unidad(){        
    $request = \Config\Services::request();
    $model_unidad = model('App\Models\HCV\Operativo\Unidad_negocio');
    $id = $request->getVar("id_delete");
    $model_unidad->delete($id);
    //retun affected rows into database
    $affected_rows = $this->db->affectedRows();
    $mensaje = messages($detele = 2, $affected_rows);
    return $mensaje; 
  }   

  // Eliminar area del tomador de muestra
  public function delete_area(){        
    $request = \Config\Services::request();
    $model_areas = model('App\Models\HCV\Operativo\Tomador_areas');
    $id = $request->getVar("delete_area");
    //var_dump($id);
    $model_areas->delete($id);
    //retun affected rows into database
    $affected_rows = $this->db->affectedRows();
    $mensaje = messages($detele = 2, $affected_rows);
    return $mensaje; 
  }

  //Update datos de la ficha del operativo
  public function update_(){
    $validation = \Config\Services::validation();
    $request = \Config\Services::request();

    ($_POST['grupo_medico'] ==  7) ? $id_catlab = $_POST['area_tomador']  : $id_catlab = 1;

    //Actualizacion de la foto de perfil del operativo
    $foto = $this->request->getFile('image'); //nueva imagen
    if(!$foto->isValid()) { //si no hay nueva imagen
        $name_foto = $_POST['name_foto']; //se queda imagen anterior
        $imagen_operativo = false;
    } else { //se cargo una imagen nueva
        // image validation
        $validated = $this->validate([
            'image' => [
                'uploaded[image]',
                'mime_in[image,image/jpg,image/jpeg,image/png]',
                'max_size[image,4096]',
                'is_image[image]'
            ],
        ]);
        if(!$validated) { //Si el formato de imagen no es valido
            $mensaje = $this->errors($error = 600);
            return $this->respond($mensaje);
        } else { //imagen valida que reemplaza a la anterior
            $imagen_operativo = true;
        }
    }         

    //Actualizacion del INE subido por el operativo
    $ine = $this->request->getFile('file_ine');
    if (!$ine->isValid()) {
        $name_ine = $_POST['name_ine'];
        $imagen_ine = false;
    } else {
        // image validation
        $validacion_ine = $this->validate([
            'file_ine' => [
                'uploaded[file_ine]',
                'mime_in[image,image/jpg,image/jpeg,image/png]',
                'max_size[file_ine,4096]',
                'is_image[file_ine]' 
            ],
        ]);
        if (!$validacion_ine) {
            $mensaje = $this->errors($error = 600);
            return $this->respond($mensaje);
        } else {
          $imagen_ine = true;
        } 
    } 
   
    // Validacion de nueva contraseña
    $password = $_POST['upd_password'];
    // Si el pasword no es vacio se inserta nuevo password
    if ($password != "") {
       // $password = $_POST['password'];
        $password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $password = $_POST['old_password'];
    }
   //Actualizacion del arreglo de los datos generales de usuario
     $data = [
        'user_name' => $_POST['upd_NAME'] . " " . $_POST["upd_F_LAST_NAME"] . " " .$_POST["upd_S_LAST_NAME"], 
        //"id_group" => $_POST['upd_grupo_medico'],
        'password' => $password,
        'id' => $_POST['id_user'],
        'email' => $_POST['email'],
    ];
    $model_user = model('App\Models\Administrador\Usuarios');
    //En caso de que se cambie de correo
    if ($model_user->update($_POST['id_user'], $data) === false) {
      $error = $model_user->errors();
       $mensaje = [
          "status" => 400,
          "msg" => $error['email']
      ]; 
      return $this->respond($mensaje);
    }else{ 
      $id_identity = $_POST['id_identity'];
      if($imagen_operativo) { //nueva imagen del operativo
        $ruta = "../public/uploads/medico/fotos/"; //carpeta donde se guardara
        $foto->move($ruta, $foto->getRandomName()); //sustitucion de imagen anterior
        $name_foto = $foto->getName();//nombre de la nueva imagen cargada
      } 

      if($imagen_ine) {
        $path = "../public/uploads/medico/ine/";
        $ine->move($path, $ine->getRandomName());
        $name_ine = $ine->getName();
      }
   
      $data_operativo = [
        'NAME' => $request->getPost('upd_NAME'),
        'F_LAST_NAME' => $request->getPost('upd_F_LAST_NAME'),
        'S_LAST_NAME' => $request->getPost('upd_S_LAST_NAME'),
        'BIRTHDATE' => $request->getPost('upd_BIRTHDATE'),
        'PHONE_NUMBER' => $request->getPost('upd_PHONE_NUMBER'),
        'DESC_PERSONAL' => $request->getPost('upd_descrip'),
        'CAT_CP_ID' => $request->getPost('upd_ID_CODE'),
        'delegacion' => $request->getPost('upd_ID_CAT_MUNICIPALITY'),
        'estado' => $request->getPost('upd_ID_CAT_STATE_OF_RESIDENCE'),
        'colonia' => $request->getPost('upd_ID_CAT_TOWN'),
        'STREET_NUMBER' => $request->getPost('upd_STREET'),
        'LATITUD' => $request->getPost('upd_latitud'),
        'LONGITUD' => $request->getPost('upd_longitud'),
        'disciplina_id' => $request->getPost('discip'),
        'entry_time' => $request->getPost('upd_hora_entrada'),
        'departure_time' => $request->getPost('upd_hora_salida'),
        'especialidad_id' => $request->getPost('upd_especialidad_id'),
        'NUMBER_PROFESSIONAL_CERTIFICATE' => $request->getPost('upd_fcedula'),
        'NUMBER_SPECIALTY_CERTIFICATE' => $request->getPost('upd_cedulaespe'),
        'FILE_USER' => $name_foto,
        'FILE_INE' => $name_ine,
        'id_category_lab' => $id_catlab 
      ];  
       $id_upd = $this->model->update($id_identity, $data_operativo);
      $affected_rows = $this->db->affectedRows();
      $mensaje = messages($update = 1, $affected_rows);
      return $this->respond($mensaje); 
    }
  }

  //Select en el que se obtienen las opciones de disciplina 
  public function getDisciplina(){
    $model_disciplina = model('App\Models\HCV\Operativo\Disciplina');
    $data = $model_disciplina->get_speciality();
    return json_encode($data);
  }
  
  //Select en el que se obtienen las opciones de laboratorio 
  public function getLaboratorio(){
    $model_laboratorio = model('App\Models\HCV\Operativo\Disciplina');
    $data = $model_laboratorio->get_laboratorio();
    return json_encode($data);
  }

  //Select en el que se obtienen las opciones de categoria de laboratorio
  public function getCatLab(){
    $model_CatLab = model('App\Models\Catalogos\Category_lab');
    $data = $model_CatLab->readArea();
    return json_encode($data);
  }

  // Insert de unidades de negocio del operativo en identity
  public function createUnidad(){
     $request = \Config\Services::request();
     $model_unidad = model('App\Models\HCV\Operativo\Unidad_negocio');
     $unidad = $request->getPost('unidad'); 
     $id_usuario = $_POST['id_user'];

     $verify = $model_unidad->unidadRepetida($id_usuario, $unidad);
          
     if(!empty($verify)){
      $respuesta = [
        "status" => 400,
        "msg" => "Unidad de negocio duplicada"
      ]; 
      return $this->respond($respuesta);
     }else{
      $data_unidades = [
        'id_business_unit'=> $unidad,
        'id_user' => $id_usuario
      ];
      //retun id
      $id = $model_unidad->insert($data_unidades);
      $mensaje = messages($insert = 0, $id);
      return $this->respond($mensaje);  
     }  
  }

  // Insert de areas de tomador de muestras
  public function createArea(){
    $request = \Config\Services::request();
    $model_area = model('App\Models\HCV\Operativo\Tomador_areas');
    $area = $request->getPost('area'); 
    $id_usuario = $_POST['id_user'];

    $verify = $model_area->areaRepetida($id_usuario, $area);
         
    if(!empty($verify)){
     $respuesta = [
       "status" => 400,
       "msg" => "Área duplicada"
     ]; 
     return $this->respond($respuesta);
    }else{
     $data_area = [
      'id_category_lab' => $area,
       'id_user' => $id_usuario
     ];
     //retun id
     $id = $model_area->insert($data_area);
     $mensaje = messages($insert = 0, $id);
     return $this->respond($mensaje);  
    }  
 }

}
