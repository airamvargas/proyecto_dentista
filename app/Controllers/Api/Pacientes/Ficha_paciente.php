<?php

namespace App\Controllers\Api\Pacientes;
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

    // create
    public function create() {
      $session = session();
      $user_id = $session->get('unique');
      $model_users = model('App\Models\Model_user/Table_user');
      $request = \Config\Services::request();

      $total = count($this->model->total($user_id));
      $path = 'uploads/profile';      
      $path_absolute = "writable/uploads/profile/";
      $file = $this->request->getFile('file_paciente');

      if($total > 0){
        $id_datos = $this->model->get_id($user_id);

        if (!$file->isValid()) {
          $file_user = $id_datos->PATH;
        } else {
          $filename = $path_absolute . $id_datos->PATH;
          unlink($filename);
          $newName = $file->getRandomName();
          $file->move(WRITEPATH . $path, $newName);
          $file_user = $file->getName();
        }

        $data = [
          //'ID_USER' =>  $request->getPost('ID_USER'), 
          //'id_cat_business_unit' =>  $request->getPost('ID_USER'), 
          'PATH' =>  $file_user, 
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
          //'ID_CAT_TUTOR' => $request->getPost('ID_CAT_TUTOR'), 
          //'ANSWER_OTHER_TUTOR' => $request->getPost('ANSWER_OTHER_TUTOR')
        ];
        $id = $this->model->insert($data);
        if($id){
          $mensaje = [
            'status' => 200,
            'msg' => "AGREGADO CON EXITO"   
          ];
          return json_encode($mensaje);
        }else{
          $mensaje = [
            'status' => 400,
            'msg' => "Hubo un error al guardar los datos. Intenta de nuevo"    
          ];          
        }   
      }else{//total
        if (!$file->isValid()) {
          $file_user = "";
        } else {
          $newName = $file->getRandomName();
          $file->move(WRITEPATH . $path, $newName);
          $file_user = $file->getName();
        }

        $data = [
          //'ID_USER' =>  $request->getPost('ID_USER'), 
          //'id_cat_business_unit' =>  $request->getPost('ID_USER'), 
          'PATH' =>  $file_user, 
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
          //'ID_CAT_TUTOR' => $request->getPost('ID_CAT_TUTOR'), 
          //'ANSWER_OTHER_TUTOR' => $request->getPost('ANSWER_OTHER_TUTOR')
        ]; 
        $id = $this->model->insert($data);
        if($id){
          $mensaje = [
            'status' => 200,
            'msg' => "AGREGADO CON EXITO"   
          ];
          return json_encode($mensaje);
        }else{
          $mensaje = [
            'status' => 400,
            'msg' => "Hubo un error al guardar los datos. Intenta de nuevo"    
          ];          
        }  
      }     
    }

    // single user
    public function getIdentity($id = null){
      $model = model('App\Models\Models_hcv\Model_identity');
      $data = $model->where('id', $id)->first();
      if($data){
        return $this->respond($data);
      }else{
        return $this->failNotFound('No employee found');
      }
    }

    

}