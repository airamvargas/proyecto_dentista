<?php

namespace App\Controllers\Api\HCV\Pacientes;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');
use App\Models\Models_hcv\Model_identity as model;

class Ficha_paciente extends ResourceController {
  use ResponseTrait;
  var $model;
  var $db;

  public function __construct() { //Assign global variables
    $this->model = new model();
    $this->db = db_connect();
    helper('messages');
  }

  //datatable citas paciente
  public function readAppointmentPatient(){
    $session = session();
    $user_id = $session->get('unique');
    $model = model('App\Models\Agendas\Appointment_schedule');
    $data['data'] = $model->readAppointmentPacient($user_id);
    return $this->respond($data);
  }

  //Datos del paciente para editar
  public function readPacient(){
    $session = session();
    $user_id = $session->get('unique');

    $data = $this->model->readPatient($user_id);

    return $this->respond($data);
  }

  public function get_religion(){
    $json = $this->request->getJSON();
    $religion = $json->search;
    $model = model('App\Models\Model_operativos\Model_religion');
    $data = $model->readReligion($religion);
    return $this->respond($data, 200);
  }

  //Update pacient
  public function update_() {
    $session = session();
    $user_id = $session->get('unique');
    $model_user = model('App\Models\Administrador\Usuarios');
    $request = \Config\Services::request();

    $file = $this->request->getFile('file_paciente');  
    $id = $request->getPost('id_pacient');

    //Actualizacion de datos generales de usuario
    $data = [
      'user_name' => $request->getPost('name') . " " . $request->getPost('f_last_name') . " " .$request->getPost('s_last_name')
    ];

    $model_user->update($request->getPost('id_user'), $data);
  
    //Actualizacion de la foto de perfil del operativo    
    if (!$file->isValid()) {
      $name_img = $this->model->select('PATH')->where('ID', $id)->find();
      $name_image = $name_img[0]['PATH'];
      $imagen = false;
    } else {
      // image validation
      $validated = $this->validate([
        'file_paciente' => [
          'uploaded[file_paciente]',
          'mime_in[file_paciente,image/jpg,image/jpeg,image/png]',
          'max_size[file_paciente,4096]',
          'is_image[file_paciente]'
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
      $path = "uploads/paciente/fotos/";
      $file->move($path, $file->getRandomName());
      $name_image = $file->getName();
    } 

    $data_identity = [
      'PATH' =>  $name_image,
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

    $this->model->update($id, $data_identity);
    $affected_rows = $this->db->affectedRows();
    $mensaje = messages($update = 1, $affected_rows);
    return $this->respond($mensaje);  
  }

  // single user
  public function getIdentity($id = 60){
    $model = model('App\Models\Models_hcv\Model_identity');
    $data = $model->where('id', $id)->first();
    if($data){
      return $this->respond($data);
    }else{
      return $this->failNotFound('No employee found');
    }
}
}