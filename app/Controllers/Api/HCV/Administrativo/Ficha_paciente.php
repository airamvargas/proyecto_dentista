<?php

namespace App\Controllers\Api\HCV\Administrativo;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');

use App\Models\Models_hcv\Model_identity as model;

class Ficha_paciente extends ResourceController
{
  use ResponseTrait;
  var $model;
  var $db;

  public function __construct()
  { //Assign global variables
    $this->model = new model();
    $this->db = db_connect();
    helper('messages');
  }

  // create
  public function create()
  {
    $validation = \Config\Services::validation();
    $request = \Config\Services::request();

    // Validacion de foto de perfil del paciente
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
    if ($imagen) {
      $path =  '../public/uploads/paciente/fotos';
      $newfile = $file->getRandomName();
      $file->move(WRITEPATH . $path, $newfile);
      $file_name = $file->getName();
    }

    $session = session();
    $user_id = $session->get('unique');
    $grupo = $session->get('group');
    //Si registro esa info el admin webcorp o back office del sistema
   /*  if (($grupo == 1) || ($grupo == 2)) {
      $id_registro = $session->get('group');
    } else { //Registro la informacion el propio usuario
      $id_registro = $user_id;
    } */
    $id_registro=4;
    $user_model = model('App\Models\Administrador\Usuarios');
    //validar contraseña
    $password =  $_POST['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);
    $token = $this->generate_token();
    // Arreglo a guardar en la tabla users
    $data = [
      "user_name" => $_POST['name'] . " " . $_POST["f_last_name"] . " " . $_POST["s_last_name"],
      "id_group" => $id_registro,
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
      $data_paciente = [
        'ID_USER' =>  $id, 
        'PATH' =>  $file_name,
        'NAME' => $request->getPost('name'),
        'F_LAST_NAME' => $request->getPost('f_last_name'),
        'S_LAST_NAME' => $request->getPost('s_last_name'),
        'BIRTHDATE' => $request->getPost('birthdate'),
        'SEX' => $request->getPost('sex'),
        'ID_CAT_NATIONALITY' => $request->getPost('country'),
        'BIRTHPLACE' => $request->getPost('birthplace'),
        'CURP' => $request->getPost('curp'),
        'PHONE_NUMBER' => $request->getPost('phone_number'),
        'ID_ZIP_CODE' => $request->getPost('id_original'),
        'ID_CAT_MUNICIPALITY' => $request->getPost('municipality'),
        'ID_CAT_STATE_OF_RESIDENCE' => $request->getPost('state'),
        'ID_CAT_TOWN' => $request->getPost('town'),
        'street_other' => $request->getPost('STREET'),
        'LATITUD' => $request->getPost('latitud'),
        'LONGITUD' => $request->getPost('longitud'),
        'ID_CAT_ACADEMIC' => $request->getPost('id_academic'),
        'JOB' => $request->getPost('job'),
        'ID_CAT_MARITAL_STATUS' => $request->getPost('cat_marital_status'),
        'ID_CAT_GENDER_IDENTITY' => $request->getPost('cat_gender_identity'),
        'other_gender' => $request->getPost('other_gender'),
        'ID_CAT_RELIGION' => $request->getPost('id_religion'),
        'ANSWER_INDIGENOUS_COMUNITY' => $request->getPost('ANSWER_INDIGENOUS_COMUNITY'),
        'ANSWER_INDIGENOUS_LENGUAGE' => $request->getPost('ANSWER_INDIGENOUS_LENGUAGE'),
        'ID_CAT_INDIGENOUS_LENGUAGE' => $request->getPost('lenguage_id')
      ];
      // Save data_paciente
      $id_identity = $this->model->insert($data_paciente);
      $mensaje = messages($insert = 0, $id_identity);
      return $this->respond($mensaje);  
    }
  }

  // Se obtienen los datos del paciente para poner en la Ficha
  public function getPaciente($id=null){
    $request = \Config\Services::request();
    $model_paciente = model('App\Models\HCV\Paciente\Ficha_identificacion_paciente');
    $id = $request->getPost('id');
    $data = $model_paciente->get_paciente($id);
    return $this->respond($data);
  }  

  //Update datos de la ficha del paciente
  public function update_(){
    $validation = \Config\Services::validation();
    $request = \Config\Services::request();

    //Actualizacion de la foto de perfil del paciente
    $foto = $this->request->getFile('image'); //nueva imagen
    if(!$foto->isValid()) { //si no hay nueva imagen
      $name_foto = $_POST['name_foto']; //se queda imagen anterior
      $imagen_paciente = false;
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
        $imagen_paciente = true;
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
    $token = $this->generate_token(); 
   //Actualizacion del arreglo de los datos generales de usuario
    $data = [
      'user_name' => $_POST['name'] . " " . $_POST["f_last_name"] . " " .$_POST["s_last_name"], 
      //"id_group" => $_POST['upd_grupo_medico'],
      'password' => $password,
      'activation_token' => $token,
      'id' => $_POST['id_user'],
      'email' => $_POST['correo'],
    ];
    $model_user = model('App\Models\Administrador\Usuarios');

    $id_identity = $_POST['id_identity'];
    if($imagen_paciente) { //nueva imagen del operativo
      $ruta = "../public/uploads/paciente/fotos"; //carpeta donde se guardara
      $foto->move($ruta, $foto->getRandomName()); //sustitucion de imagen anterior
      $name_foto = $foto->getName();//nombre de la nueva imagen cargada
    } 

    if(isset($_POST['ANSWER_INDIGENOUS_COMUNITY'])){
      $marcada = $_POST['ANSWER_INDIGENOUS_COMUNITY'];
    }else{
      $marcada = '';
    }

    $data_paciente = [
      'PATH' =>  $name_foto,
      'NAME' => $request->getPost('name'),
      'F_LAST_NAME' => $request->getPost('f_last_name'),
      'S_LAST_NAME' => $request->getPost('s_last_name'),
      'BIRTHDATE' => $request->getPost('birthdate'),
      'SEX' => $request->getPost('sex'),
      'ID_CAT_NATIONALITY' => $request->getPost('country'),
      'BIRTHPLACE' => $request->getPost('birthplace'),
      'CURP' => $request->getPost('curp'),
      'PHONE_NUMBER' => $request->getPost('phone_number'),
      'ID_ZIP_CODE' => $request->getPost('upd_ID_CODE'),
      'ID_CAT_MUNICIPALITY' => $request->getPost('municipality'),
      'ID_CAT_STATE_OF_RESIDENCE' => $request->getPost('state'),
      'ID_CAT_TOWN' => $request->getPost('town'),
      'street_other' => $request->getPost('STREET'),
      'LATITUD' => $request->getPost('latitud'),
      'LONGITUD' => $request->getPost('longitud'),
      'ID_CAT_ACADEMIC' => $request->getPost('id_academic'),
      'JOB' => $request->getPost('job'),
      'ID_CAT_MARITAL_STATUS' => $request->getPost('cat_marital_status'),
      'ID_CAT_GENDER_IDENTITY' => $request->getPost('cat_gender_identity'),
      'other_gender' => $request->getPost('other_gender'),
      'ID_CAT_RELIGION' => $request->getPost('id_religion'),
      'ANSWER_INDIGENOUS_COMUNITY' => $marcada,
      'ANSWER_INDIGENOUS_LENGUAGE' => $request->getPost('ANSWER_INDIGENOUS_LENGUAGE'),
      'ID_CAT_INDIGENOUS_LENGUAGE' => $request->getPost('lenguage_id')
      //'ID_CAT_TUTOR' => $request->getPost('ID_CAT_TUTOR'), 
      //'ANSWER_OTHER_TUTOR' => $request->getPost('ANSWER_OTHER_TUTOR')
    ];
    $id_upd = $this->model->update($id_identity, $data_paciente);
    $affected_rows = $this->db->affectedRows();
    $mensaje = messages($update = 1, $affected_rows);
    return $this->respond($mensaje);  

    /*En caso de que se cambie de correo
    if ($model_user->update($_POST['id_user'], $data) === false) {
      $error = $model_user->errors();
       $mensaje = [
          "status" => 400,
          "msg" => $error['email']
      ]; 
      return $this->respond($mensaje);
    }*/
  }

  //Token a generar para el registro de usuario
  public function generate_token()
  {
    return bin2hex(random_bytes(24));
  }

  //Errores en caso de que no se cumplan las validaciones
  public function errors($error)
  {
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

  // Select con lugar de nacimiento a escoger
  public function get_estados()
  {
    $model = model('App\Models\Model_operativos\Model_estados');
    $data = $model->get_estados();
    return $this->respond($data, 200);
  }

  public function get_academic()
  {
    $json = $this->request->getJSON();
    $limit = $json->limit;
    $offset = $json->offset;
    $especialidad = $json->especialidad;
    $model = model('App\Models\Models_hcv\Model_academic');
    $data['data'] = $model->like('ACADEMIC_FORMATION', $especialidad)
      ->orderBy('ID', 'ACADEMIC_FORMATION')->findAll($limit, $offset);

    $response = [
      'status'   => 200,
      'error'    => null,
      'data'     => $data['data'],
      'messages' => [
        'success' => 'ok'
      ]
    ];
    return $this->respond($response);
  }


  public function get_religion()
  {
    $model = model('App\Models\Model_operativos\Model_religion');
    $data = $model->get_religion();
    return $this->respond($data, 200);
  }

  public function get_religiones()
  {
    $json = $this->request->getJSON();
    $limit = $json->limit;
    $offset = $json->offset;
    $search = $json->search;
    $model = model('App\Models\Model_operativos\Model_religion');
    $data['data'] = $model->like('RELIGION', $search)->orderBy('ID', 'RELIGION')->findAll($limit, $offset);
    $response = [
      'status'   => 200,
      'error'    => null,
      'data'     => $data['data'],
      'messages' => [
        'success' => 'ok'
      ]
    ];
    return $this->respond($response);
  }

  // Busqueda del mapa por servicio
  public function data_mapa()
  {
    $json = $this->request->getJSON();
    $direct = $json->STREET;
    $address = urlencode($direct);

    $googleMapUrl = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyCwD3Bk71LnFRTi329E7GRyqPQDTpDGXgk";
    $geocodeResponseData = file_get_contents($googleMapUrl);
    $responseData = json_decode($geocodeResponseData, true);

    if ($responseData['status'] == 'OK') {
      $latitude = isset($responseData['results'][0]['geometry']['location']['lat']) ? $responseData['results'][0]['geometry']['location']['lat'] : "";
      $longitude = isset($responseData['results'][0]['geometry']['location']['lng']) ? $responseData['results'][0]['geometry']['location']['lng'] : "";
      $formattedAddress = isset($responseData['results'][0]['formatted_address']) ? $responseData['results'][0]['formatted_address'] : "";
      if ($latitude && $longitude && $formattedAddress) {
        $data = [
          'latitude' => $latitude,
          'longitude' => $longitude,
          'formattedAddress' => $formattedAddress
        ];
        return $this->respond($data, 200);
      } else {
        return $this->respond(400);
      }
    } else {
      return $this->failNotFound('BUSQUEDA NO ENCONTRADO');
    }
  }
}
