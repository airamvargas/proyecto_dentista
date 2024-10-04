<?php
namespace App\Controllers\Api\HCV\Administrativo;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');

use App\Models\HCV\Operativo\Ficha_Identificacion as model;

class Principal_medicos extends ResourceController {
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct() { //Assign global variables
      $this->model = new model();
      $this->db = db_connect();
      helper('messages');
    }

    public function read(){
        $data["data"] = $this->model->get_medicos();
        return $this->respond($data);  
    }

    //delete operativos
    public function delete_(){        
      $request = \Config\Services::request();
      $id = $request->getVar("id_delete");
      $this->model->delete($id);
      //retun affected rows into database
      $affected_rows = $this->db->affectedRows();
      $mensaje = messages($detele = 2, $affected_rows);
      return $mensaje;
  }   

    
}