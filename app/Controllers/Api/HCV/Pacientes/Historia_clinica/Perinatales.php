<?php 

namespace App\Controllers\Api\HCV\Pacientes\Historia_clinica;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');
use App\Models\Models_hcv\Model_perinatales as model;

class Perinatales extends ResourceController {
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
        $id_paciente = $_POST['id_paciente'];
        $data = $this->model->read($id_paciente);
        return $this->respond($data);        
    }

    //create empresas
    public function create() {
        $request = \Config\Services::request();

        $data = [
            'no_embarazo_del_nino' => $request->getPost('Embarazo'),
            'complicaciones_en_embarazo' => $request->getPost('Complicaciones'), 
            'desc_complicaciones' => $request->getPost('des_complicaciones'),
            'tipo_nacimiento' => $request->getPost('nacimiento'),
            'edad_de_la_madre_al_nacimiento' => $request->getPost('edad_madre'),
            'presento_alguna_complicacion_al_nacimiento' => $request->getPost('complicacion'),
            'desc_complicacion_al_nacimiento' => $request->getPost('des_complicacion'),
            'semanas_gestacion_al_nacer' => $request->getPost('semanas'),
            'alimentacion_al_nacer' => $request->getPost('alimentacion_bebe'),
            'desc_otra_alimentacion' => $request->getPost('des_alimentacion'),
            'calificacion_de_apgar' => $request->getPost('apgar'),
            'calificacion_de_silverman' => $request->getPost('silverman'),
            'amerito_reanimacion' => $request->getPost('reanimacion'),
            'amerito_incubadora' => $request->getPost('estancia'),
            'user_id' => $request->getPost('id_user_patient')
        ];

        //retun id
        $id = $this->model->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);
    }
}