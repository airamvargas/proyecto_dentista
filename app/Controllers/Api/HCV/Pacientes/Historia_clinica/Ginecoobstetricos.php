<?php 

namespace App\Controllers\Api\HCV\Pacientes\Historia_clinica;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');
use App\Models\Models_hcv\Model_ginecoobstetrico as model;
use App\Models\Models_hcv\Model_ets as enfermedades;

class Ginecoobstetricos extends ResourceController {
    use ResponseTrait;
    var $model;
    var $enfermedades;
    var $db;

    public function __construct(){
        //Assign global variables
        $this->model = new model();
        $this->enfermedades = new enfermedades();
        $this->db = db_connect();
        helper('messages');
    }

    //Datatable ets
    public function readGine(){   
        $id_paciente = $_POST['id_paciente'];
        $data = $this->model->readGine($id_paciente);
        return $this->respond($data);        
    }

    //insert datos ginecoobstetricos
    public function create(){
        $request = \Config\Services::request();

        $data = [
            'menarca' => $request->getPost('Menarca'),
            'inicio_de_vida_sexual' => $request->getPost('inicio_sexual'),
            'tipo_de_ciclo' => $request->getPost('ciclo'),
            'numero_de_embarazos' => $request->getPost('num_embarazos'),
            'numero_de_partos' => $request->getPost('Partos'),
            'numero_de_cesareas' => $request->getPost('cesareas'),
            'numeros_de_abortos' => $request->getPost('num_abortos'),
            'ha_dado_lactancia' => $request->getPost('Lactancia'),
            'edad_inicio_menopausia' => $request->getPost('Menopausia'),
            'numeros_parejas_sexuales' => $request->getPost('num_parejas'),
            'user_id' => $request->getPost('id_user_patient')
        ];

        $id = $this->model->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje); 
    }

    //Datatable ets
    public function readEts(){   
        $id_paciente = $_POST['id_paciente'];
        $data["data"] = $this->enfermedades->readEts($id_paciente);
        return $this->respond($data);        
    }

    //insert ets
    public function createEts(){
        $request = \Config\Services::request();
        $enfermedad = $request->getPost('enfermedad');
        $user = $request->getPost('user_id');
        $validate = $this->enfermedades->where('enfermedad',$enfermedad)->where('user_id',$user)->find();

        if(!empty($validate)){
            $data = [
                "status" => 400,
                "msg" => "EL REGISTRO YA EXISTE"
            ];
            return $this->respond($data); 

        }

        $data = [
            'enfermedad' => $enfermedad,
            'user_id' => $user
        ];

        $id = $this->enfermedades->insert($data);
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