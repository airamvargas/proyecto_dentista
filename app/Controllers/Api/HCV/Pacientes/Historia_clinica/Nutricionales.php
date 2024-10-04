<?php 

namespace App\Controllers\Api\HCV\Pacientes\Historia_clinica;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');
use App\Models\Models_hcv\Model_nutricionales as model;
use App\Models\Models_hcv\Model_alimentos as alimentos;

class Nutricionales extends ResourceController {
    use ResponseTrait;
    var $model;
    var $alimentos;
    var $db;

    public function __construct(){
        //Assign global variables
        $this->model = new model();
        $this->alimentos = new alimentos();
        $this->db = db_connect();
        helper('messages');
    }

    //Datos nutricionales del paciente
    public function read(){   
        $id_paciente = $_POST['id_paciente'];
        $data = $this->model->read($id_paciente);
        return $this->respond($data);     
    }

    //create datos nutricionales
    public function create() {
        $session = session();
        $user_id = $session->get('unique');
        $request = \Config\Services::request();

        if($request->getPost('otros') == ""){
            $bebida = $request->getPost('bebida');
        } else {
            $bebida = $request->getPost('otros');
        }
       
        $data = [
            'tipo_comida'=> $request->getPost('tipo_alimentacion'),
            'num_comidas_dia' => $request->getPost('Tiempos'), 
            'comida_en_casa' => $request->getPost('Alimentacion'),
            'consumo_alcohol' => $request->getPost('Alcohol'),
            'num_copas' => $request->getPost('Copas'),
            'suplemento' => $request->getPost('Suplemento'),
            's_descripcion' => $request->getPost('tipo_suplemento'),
            'tipo_de_bebida' => $bebida,
            'user_id' => $request->getPost('id_user_patient'),
        ];

        $id = $this->model->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);
    }

    //Datatable alimentos
    public function readAliments(){   
        $id_paciente = $_POST['id_paciente'];
        $data['data'] = $this->alimentos->readAliments($id_paciente);
        return $this->respond($data);        
    }

    public function createAliment(){
        $request = \Config\Services::request();
        $session = session();
        $user_id = $session->get('unique');
        $alimento = $request->getPost('alimento');
        $user =  $request->getPost('user_id');
        $validate = $this->alimentos->where('alimento',$alimento)->where('user_id',$user)->find();

        //validacion que el registro no exista en base
        if(!empty($validate)){
            $data = [
                "status" => 400,
                "msg" => "EL REGISTRO DEL ALIMENTO YA EXISTE"
            ];
            return $this->respond($data); 

        }

        $data = [
            'alimento' => $request->getPost('alimento'),
            'cantidad' => $request->getPost('cantidad'),
            'user_id' => $request->getPost('user_id'),
        ];

        $id = $this->alimentos->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);  
    }

    
    //delete aliment
    public function deleteAliment(){
        $request = \Config\Services::request();
        $id = $request->getPost('id_delete');
        $this->alimentos->delete($id);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje;
    }
}