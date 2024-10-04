<?php 

namespace App\Controllers\Api\HCV\Pacientes\Historia_clinica;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');
use App\Models\Models_hcv\Model_psicologicos as model;

class Psicologicos extends ResourceController {
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct(){
        //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }

    //Obtener datos psicologicos
    public function read(){    
        //data from the datatable
        $id_paciente = $_POST['id_paciente'];
        $data = $this->model->readPsicologicos($id_paciente);
        return $this->respond($data);        
    }

    //create datos psicologicos
    public function create() {
        $session = session();
        $user_id = $session->get('unique'); 
        $request = \Config\Services::request();

        $data = [
            'ha_tenido_intervenciones'=> $request->getPost('intervenciones'),
            'ha_tenido_tratamiento_previo' => $request->getPost('tratamiento'), 
            'actualmente_continua_tratamiento' => $request->getPost('continuacion'),
            'desc_tratamiento' => $request->getPost('textarea'),
            'considera_atencion_psicologia' => $request->getPost('necesidad'),
            'user_id' => $request->getPost('id_user_pacient')
        ];
        //retun id
        $id = $this->model->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje); 
    }
}