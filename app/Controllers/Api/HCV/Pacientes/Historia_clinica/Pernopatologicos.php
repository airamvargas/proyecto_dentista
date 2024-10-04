<?php 

namespace App\Controllers\Api\HCV\Pacientes\Historia_clinica;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');
use App\Models\Models_hcv\NoPatologicos as model;

class Pernopatologicos extends ResourceController {
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct(){
        //Assign global variables
        $this->db = db_connect();
        $this->model = new model();
        helper('messages');
    }

    public function readNoPat($id_paciente){    
        $model = model('App\Models\Models_hcv\NoPatologicos');
        $data = $this->model->readNoPat($id_paciente);
        return $this->respond($data);   
    }

    //data from the datatable animals
    public function readAnimals(){    
        $model_animals = model('App\Models\Models_hcv\Model_animales');
        $id_paciente = $_POST['id_paciente'];
        $data['data'] = $model_animals->get_animales($id_paciente);
        
        return $this->respond($data);        
    }

    //data from the datatable animals
    public function readServices(){    
        $model_services = model('App\Models\Models_hcv\Model_servicios');
        $id_paciente = $_POST['id_paciente'];
        $data["data"] = $model_services->get_servicios($id_paciente);
        return $this->respond($data);        
    }

    //create no patologicos
    public function create() {
        $session = session();
        $user_id = $session->get('unique');
        $request = \Config\Services::request();

        $data = [
            'user_id' => $request->getPost('user_id'),
            'talla'=> $request->getPost('talla'),
            'peso' => $request->getPost('peso'), 
            'tatuajes' => $request->getPost('tatuajes'),
            'piercing' => $request->getPost('piercing'),
            'tuberculosis' => $request->getPost('tuberculosis'),
            'humo_lena' => $request->getPost('humo_lena'),
            'casa_propia' => $request->getPost('casa_propia')
        ];
        
        $id = $this->model->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);  
    }


    //insert animals
    public function createAnimal() {
        $model_animals = model('App\Models\Models_hcv\Model_animales');
        $request = \Config\Services::request();
        $user = $request->getPost('user_id');
        $name = $request->getPost('name');
        $animals = $model_animals->where('name',$name)->where('user_id',$user)->find();

        if(!empty($animals)){
            $data = [
                "status" => 400,
                "msg" => "EL REGISTRO DEL ANIMAL YA EXISTE"
            ];
            return $this->respond($data); 
        }


        $data = [
            'name'=> $request->getPost('name'),
            'user_id' =>  $request->getPost('user_id'),
        ];
        //retun id
        $id = $model_animals->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje); 
    }

    //delete animal
    public function deleteAnimal(){
        $request = \Config\Services::request();
        $model_animals = model('App\Models\Models_hcv\Model_animales');
        $id = $request->getPost('id_delete');
        $model_animals->delete($id);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje; 
    }

    //insert service
    public function createService() {
        $request = \Config\Services::request();
        $model_services = model('App\Models\Models_hcv\Model_servicios');
        $servicio = $request->getPost('servicio');
        $user =  $request->getPost('user_id');
        $services = $model_services->where('servicio',$servicio)->where('user_id',$user)->find();

        if(!empty($services)){
            $data = [
                "status" => 400,
                "msg" => "EL REGISTRO DEL SERVICIO YA EXISTE"
            ];
            return $this->respond($data); 
        }

         $data = [
            'servicio'=> $request->getPost('servicio'),
            'user_id' => $request->getPost('user_id')
        ];
        
        $id = $model_services->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);  
    }

    //delete service
    public function deleteService(){
        $request = \Config\Services::request();
        $model_services = model('App\Models\Models_hcv\Model_servicios');
        $id = $request->getPost('id_delete');
        $model_services->delete($id);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje; 
    }

}