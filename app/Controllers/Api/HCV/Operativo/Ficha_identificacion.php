<?php 

namespace App\Controllers\Api\HCV\Operativo;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');

use App\Models\HCV\Operativo\Ficha_Identificacion as model;
use App\Models\Administrador\Usuarios as usuarios;

class Ficha_identificacion extends ResourceController {
    
    use ResponseTrait;
    var $model;
    var $db;
    var $usuarios;

    public function __construct(){ //Assign global variables
        $this->model = new model();
        $this->usuarios = new usuarios();
        $this->db = db_connect();
        helper('messages');
    }

    // Se obtienen los datos del operativo para poner en la Ficha
    public function getOperativo(){
        $session = session();
        $user_id = $session->get('unique');
        $id = $this->model->select('ID')->where('user_id', $user_id)->find();
        
        $data = $this->model->get_medico($id[0]['ID']);
        return $this->respond($data);
    }

    //Update datos de la ficha del operativo
    public function update_(){
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        //Actualizacion del INE subido por el operativo
        $ine = $this->request->getFile('file_ine');
        if (!$ine->isValid()) {
            $name_ine = $request->getPost('name_ine');
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

        if ($imagen_ine) {
            $path = "uploads/medico/ine/";
            $ine->move($path, $ine->getRandomName());
            $name_ine = $ine->getName();
        } 

        //Actualizacion de datos generales de usuario
        $data = [
            'user_name' => $_POST['upd_NAME'] . " " . $_POST["upd_F_LAST_NAME"] . " " .$_POST["upd_S_LAST_NAME"],
            //'id' => $_POST['id_user']
        ];

        $this->usuarios->update($_POST['iduser'], $data);
        $model_user = model('App\Models\Administrador\Usuarios');

        $id_identity = $_POST['ididenty'];

        $file = $this->request->getFile('image');  

        //Actualizacion de la foto de perfil del operativo    
        if (!$file->isValid()) {
            $name_image = $_POST['name_foto'];
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

        if($imagen) {
            $path_user_photo = "uploads/medico/fotos/";
            $file->move($path_user_photo, $file->getRandomName());
            $name_image = $file->getName();
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
            'especialidad_id' => $request->getPost('upd_especialidad_id'),
            'NUMBER_PROFESSIONAL_CERTIFICATE' => $request->getPost('upd_fcedula'),
            'NUMBER_SPECIALTY_CERTIFICATE' => $request->getPost('upd_cedulaespe'),
            'FILE_USER' => $name_image,
            'FILE_INE' => $name_ine
        ];  

       
        $this->model->update($id_identity, $data_operativo);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $this->respond($mensaje);  
        
    }

    //busqueda del mapa por servicio //
    public function data_mapa(){
        $json = $this->request->getJSON();
        $direct = $json->STREET;
        $address = urlencode($direct); 

        $googleMapUrl = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyCwD3Bk71LnFRTi329E7GRyqPQDTpDGXgk";
        $geocodeResponseData = file_get_contents($googleMapUrl);
        $responseData = json_decode($geocodeResponseData, true);

        if($responseData['status']=='OK') {
            $latitude = isset($responseData['results'][0]['geometry']['location']['lat']) ? $responseData['results'][0]['geometry']['location']['lat'] : "";
            $longitude = isset($responseData['results'][0]['geometry']['location']['lng']) ? $responseData['results'][0]['geometry']['location']['lng'] : "";
            $formattedAddress = isset($responseData['results'][0]['formatted_address']) ? $responseData['results'][0]['formatted_address'] : "";         
            if($latitude && $longitude && $formattedAddress) {   

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

    public function get_especialidad(){
        $json = $this->request->getJSON();
        $especialidad = $json->especialidad;
        $model = model('App\Models\Models_hcv\Model_academic');

        $data['data'] = $model->get_academic($especialidad); 

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

    // Tabla con las unidades de negocio que tiene cada operativo
    public function get_unidades(){
        $session = session();
        $user_id = $session->get('unique');

        $model_unidades = model('App\Models\HCV\Operativo\Unidad_negocio');
        $data["data"] = $model_unidades->get_unidades($user_id);
        return $this->respond($data);
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
        }else{
            $data_unidades = [
                'id_business_unit'=> $unidad,
                'id_user' => $id_usuario
            ];

            $id = $model_unidad->insert($data_unidades);
            $mensaje = messages($insert = 0, $id);
        }  
        return $this->respond($mensaje); 
    }

    // Eliminar unidades de negocio del operativo
    public function delete_unidad(){        
        $request = \Config\Services::request();
        $model_unidad = model('App\Models\HCV\Operativo\Unidad_negocio');
        $id = $request->getVar("id_delete");
        $model_unidad->delete($id);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje; 
    }   

    // Tabla con las areas que tiene cada operativo
    public function get_areas(){
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $model_areas = model('App\Models\HCV\Operativo\Tomador_areas');
        $data["data"] = $model_areas->get_areas($id);
        return $this->respond($data);
    }

}