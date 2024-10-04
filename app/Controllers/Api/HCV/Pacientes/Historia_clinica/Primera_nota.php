<?php 

namespace App\Controllers\Api\HCV\Pacientes\Historia_clinica;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');
use App\Models\Models_hcv\Model_psicologicos as model;

class Primera_nota extends ResourceController {
    use ResponseTrait;
    var $model;
    var $db;
    var $psicologia;
    var $nutricion;
    var $general;
    var $odontologia;

    public function __construct(){
        //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
        $this->psicologia = new \App\Models\HCV\Operativo\Nota_medica\Nota_psicologia();
        $this->nutricion = new \App\Models\HCV\Paciente\registro_medico\Nutricion();
        $this->general = new \App\Models\Citas\Nota_general();
        $this->odontologia = new \App\Models\HCV\Operativo\Nota_medica\Nota_odontologia();
    }

    //Obtener datos psicologicos
    public function index($id_paciente = null){    
        $session = session();
        if($session->get('group') == 8){
            $medico_id = $session->get('unique');
            $model_medico = model('App\Models\HCV\Operativo\Ficha_Identificacion');
            $diciplina = $model_medico->select('disciplina_id')->where('user_id',$medico_id)->find()[0]['disciplina_id'];

           switch ($diciplina) {
                //general
                case 1:
                   $data = $this->general->firstNote($id_paciente);
                   return $this->respond($data);   
                    break;
                //psicologia    
                case 2:
                    $data = $this->psicologia->fisrtNote($id_paciente);
                    return $this->respond($data);  
                    break;
                //nutricion    
                case 3:
                    $data = $this->nutricion->firstNote($id_paciente);
                    return $this->respond($data);   
                    break;
                    //odontologia
                // case 4:
                //      $data = $this->odontologia->select('nota')->where('id_patient',$id_paciente)->first();
                //     return $this->respond($data);   
                //     break; 
                    //especialidad
                case 5:
                    $data = $this->general->firstNote($id_paciente);
                    return $this->respond($data);   
                    break;
            }
        }
       
    }
}













