<?php 

namespace App\Controllers\Api\HCV\Pacientes\Historia_clinica;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');
use App\Models\Models_hcv\Model_androgenicos as model;
use App\Models\Models_hcv\Model_ets as enfermedades;

class Androgenicos extends ResourceController {
    use ResponseTrait;
    var $model;
    var $db;
    var $enfermedades;

    public function __construct(){
        //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        $this->enfermedades = new enfermedades();
        helper('messages');
    }

    public function read(){  
        $id_paciente = $_POST['id_paciente'];
        $data = $this->model->readAndrogenicos($id_paciente);
        return $this->respond($data);     
    }

    //create empresas
    public function create() {
        $request = \Config\Services::request();

        $data = [
            'inicio_de_vida_sexual' => $request->getPost('inicio_vida_sexual'),
            'numero_parejas_sexuales' => $request->getPost('num_parejas'),
            'user_id' => $request->getPost('id_user_patient')
        ];

        $id = $this->model->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje); 
    }

    //delete ets
    public function deleteEts(){
        $request = \Config\Services::request();
        $id = $request->getPost('id_delete');
        $this->enfermedades->delete($id);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje;
    }
}