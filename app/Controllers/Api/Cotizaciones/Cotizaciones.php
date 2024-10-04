<?php 

namespace App\Controllers\Api\Cotizaciones;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Model_cotizacion\Cotizacion as model;

class Cotizaciones extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct() { //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }

    //FUNCION PARA DATATABLE
    public function readCotizations(){ 
        $session = session();
        $id_group = $session->get('group');
        $user_id = $session->get('unique');

        if($id_group == 1){
            $data['data'] = $this->model->readCotizations();
            return $this->respond($data);
        } else {
            $data['data'] = $this->model->readCotizationsUsers($user_id);
            return $this->respond($data);
        }
         
    }
    
    //ELIMINAR COTIZACION
    public function delete_() {
        $request = \Config\Services::request();
        $id = $request->getVar("id_delete");
        $this->model->delete($id);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje;
    }

    public function get_pacientes(){
        $request = \Config\Services::request();
        $model = model('App\Models\models_paciente/Identity');

        $correo = $request->getPost('correo');
        $telefono = $request->getPost('telefono');

        if($correo == ""){
            $newCorreo = " ";
        } else {
            $newCorreo = $correo;
        }

        $data = $model->getPacientes($newCorreo, $telefono);
        return $this->respond($data);
    }

    public function readPaciente(){
        $request = \Config\Services::request();
        $model = model('App\Models\models_paciente/Identity');

        $id_user = $request->getPost('id_user');
        $data = $model->readPaciente($id_user);
        //var_dump($id_user);
        return $this->respond($data);
    }

    //CREA UNA NUEVA COTIZACION
    /*public function create(){
        $session = session();
        $user_id = $session->get('unique');
        $json = $this->request->getJSON();
        $id_paciente = $json->id_pacient;
        
        $data = [
            'id_user_vendor' => $user_id,
            'id_user_client' => $id_paciente,
        ];

        $id = $this->model->insert($data);

        if($id != null){
            $response = [
                "status" => 200,
                "id_cotizacion" => $id
            ];
            return $this->respond($response);
        }  else{
            $response = [
                "status" => 400,
                "msg" => "HUBO UN ERROR, INTENTE DE NUEVO"
            ];
            return $this->respond($response);
        }  
    } */
}