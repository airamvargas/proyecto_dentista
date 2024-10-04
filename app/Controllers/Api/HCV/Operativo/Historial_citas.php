<?php 

namespace App\Controllers\Api\HCV\Operativo;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Agendas\Appointment_schedule as model;
use App\Models\HCV\Operativo\Ficha_Identificacion as operativos;

class Historial_citas extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct() { //Assign global variables
        $this->model = new model();
        $this->operativos = new operativos();
        $this->db = db_connect();
        helper('messages');
    }

    //FUNCION PARA DATATABLE CITAS ANTERIORES
    public function show($id = null){
        $session = session();
        $user_id = $session->get('unique');
        $id_paciente = $_POST['id_paciente'];
        $disciplina = $this->operativos->select('disciplina_id')->where('user_id', $user_id)->find();
        //var_dump($disciplina);
        $data['data'] = $this->model->readHistorial($id_paciente, $disciplina[0]['disciplina_id']);
       
        return $this->respond($data); 
    }
    
}