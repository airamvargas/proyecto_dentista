<?php

namespace App\Controllers\Api\HCV\Pacientes;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');
use App\Models\HCV\Paciente\registro_medico\Nutricion as model;

class Registro_medico extends ResourceController {
  use ResponseTrait;
  var $model;
  var $db;

  public function __construct() { //Assign global variables
    $this->model = new model();
    $this->db = db_connect();
    helper('messages');
  }

  // Datatable datos clinicos de nutricion
  public function readNutricion(){
    $request = \Config\Services::request();
    $session = session();
    $user_id = $session->get('unique');
    $model = model('App\Models\HCV\Paciente\registro_medico\Nutricion');
    $data["data"] = $model->getDatosClinicos($user_id);
    return $this->respond($data);
  }

  // Datatable datos clinicos de psicologia
  public function readPsicologia(){
    $request = \Config\Services::request();
    $session = session();
    $user_id = $session->get('unique');
    $model = model('App\Models\HCV\Paciente\registro_medico\Psicologia');
    $data["data"] = $model->getDatosPsicologia($user_id);
    return $this->respond($data);
  }

  // Datatable datos clinicos de signos medicos
  public function readSignos(){
    $request = \Config\Services::request();
    $session = session();
    $user_id = $session->get('unique');
    $model = model('App\Models\HCV\Paciente\registro_medico\Signos');
    $data["data"] = $model->getDatosSignos($user_id);
    return $this->respond($data);
  }

  // Datatable datos clinicos de odontologia
  public function readOdontologia(){
    $request = \Config\Services::request();
    $session = session();
    $user_id = $session->get('unique');
    $model = model('App\Models\HCV\Operativo\Nota_medica\Nota_odontologia');
    $data["data"] = $model->getOdontologia($user_id);
    return $this->respond($data);
  }


}