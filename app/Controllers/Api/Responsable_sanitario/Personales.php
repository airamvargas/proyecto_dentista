<?php

/*
Desarrollador: Giovanni Zavala
Fecha Creacion: 17-10-2023
Fecha de Ultima Actualizacion: 17-10-2023
Perfil: Responsable sanitario
Descripcion: Resultados de estudios
*/

namespace App\Controllers\Api\Responsable_sanitario;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');

use DateTime;

class Personales extends ResourceController
{
    use ResponseTrait;
    var $db;
    //model citas
    var $model;
    //modelo cotizacion por poducto
    var $model_c_p;
    var $model_results;
    var $model_paciente;
    var $model_analitos;
    var $rangos_edad;
    var $rangos_crm;
    var $insumos;


    public function __construct()
    {
        //variables globales 
        $this->db = db_connect();
        $this->model  = new \App\Models\HCV\Operativo\Ficha_Identificacion();
        $this->usuarios = new \App\Models\Administrador\Usuarios();
        helper('messages');
    }

    public function index() {
        //datos de la tabla de muestras
        $session = session();
        $user_id = $session->get('unique');
        $data = $this->model->geUser($user_id);
        return $this->respond($data);
    }

    public function updateResp(){
        $session = session();
        $user_id = $session->get('unique');
        $request = \Config\Services::request();
        $id_identity = $request->getPost('id');
        $id_user = $request->getPost('id_user');

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
            'user_name' => $_POST['NAME'] . " " . $_POST["F_LAST_NAME"] . " " .$_POST["S_LAST_NAME"]
        ];

        $this->usuarios->update($id_user, $data);
        $model_user = model('App\Models\Administrador\Usuarios');

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

        //Actualizacion de la firma del responsable
        $firma_up = $this->request->getFile('file_firma');
        if (!$firma_up->isValid()) {
            $firma = $_POST['name_firma'];
            $firma_val = false;
        } else {
            // image validation
            $validacion_firma = $this->validate([
                'file_firma' => [
                    'uploaded[file_firma]',
                    'mime_in[image,image/jpg,image/jpeg,image/png]',
                    'max_size[file_firma,4096]',
                    'is_image[file_firma]' 
                ],
            ]);

            if (!$validacion_firma) {
                $mensaje = $this->errors($error = 600);
                return $this->respond($mensaje);
            } else {
                $firma_val = true;
            } 
        } 

        if ($firma_val) {
            $path_user_firma = "uploads/medico/firma/";
            $newName = $firma_up->getRandomName();
            $firma_up->move($path_user_firma, $newName);
            $firma = $newName;
        }
        //var_dump($newName);

        //var_dump($firma);

    
        $data_operativo = [
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
            'especialidad_id' => $request->getPost('especialidad_id'),
            'NUMBER_PROFESSIONAL_CERTIFICATE' => $request->getPost('fcedula'),
            'NUMBER_SPECIALTY_CERTIFICATE' => $request->getPost('cedulaespe'),
            'FILE_USER' => $name_image,
            'FILE_INE' => $name_ine,
            'signature' => $firma
        ]; 

       
        $this->model->update($id_identity, $data_operativo);
        $affected_rows = $this->db->affectedRows();
        if ($affected_rows > 0) {
            $response = [
                "status" => 200,
                "msg" => "GUARDADO CON EXITO"
            ];
        } else {
            $response = [
                "status" => 400,
                "msg" => "ERROR AL GUARDAR"
            ];
        }
        return $this->respond($response);
    }
}
