<?php 

namespace App\Controllers\Api\HCV\Pacientes\Historia_clinica;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');
use App\Models\Models_hcv\Model_heredofamiliares as model;

class Heredofamiliares extends ResourceController {
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct(){
        //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }

    public function read(){    
        //data from the datatable
        $id_paciente = $_POST['id_paciente'];
        $data["data"] = $this->model->getEnfermedades($id_paciente);
        return $this->respond($data);     
    }

    //create listado de enfermedades
    public function create() {
        $request = \Config\Services::request();
        $rama = $request->getPost('rama');
        $parentesco = $request->getPost('parentesco');
        $enfermedad = $request->getPost('enfermedad');
        $user =  $request->getPost('user_id');

        $enfermedades = $this->model->where('rama',$rama)->where('parentesco',$parentesco)->where('id_enfermedad',$enfermedad)->where('user_id',$user)->find();

        if(!empty($enfermedades)){
            $data = [
                "status" => 400,
                "msg" => "EL REGISTRO DE LA ENFERMEDAD YA EXISTE"
            ];
            return $this->respond($data); 
        }

        $data = [
            'rama'=> $request->getPost('rama'),
            'parentesco' => $request->getPost('parentesco'), 
            'id_enfermedad' => $request->getPost('enfermedad'),
            'user_id' => $request->getPost('user_id')
        ];
        
        $id = $this->model->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);   
    }

    //delete 
    public function delete_(){        
        $request = \Config\Services::request();
        $id = $request->getPost("id_delete");
        $this->model->delete($id);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje;
    }   
   
}