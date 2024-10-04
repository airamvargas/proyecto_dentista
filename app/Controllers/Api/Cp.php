<?php 

namespace App\Controllers\Api;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Administrador\Model_cp as model;

class Cp extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct() { //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }

    public function getCp(){ //FUNCION PARA DATATABLE
        $json = $this->request->getJSON();
        $limit = $json->limit;
        $offset = $json->offset;
        $search = $json->search;

        $data['data'] = $this->model->getCp($search, $limit, $offset);

        $response = [
            'status'   => 200,
            'error'    => null,
            'data'     => $data['data'],
            'messages' => [
                'success' => 'ok'
            ]
        ];
        return $this->respond($response);
    }

    public function create(){
        $model_cotization = model('App\Models\Model_cotizacion/Cotizacion');
        $session = session();
        $user_id = $session->get('unique');
        $json = $this->request->getJSON();
        $id_paciente = $json->id_pacient;

        $data_cotization = [
            'id_user_vendor' => $user_id,
            'id_user_client' => $id_paciente,
        ];

        $id_cotizacion = $model_cotization->insert($data_cotization);

        if($id_cotizacion != null){
            $response = [
                    "status" => 200,
                    "msg" => "PACIENTE AGREGADO",
                    "id_cotizacion" => $id_cotizacion
            ];
            return json_encode($response);
        }  else{
            $response = [
                    "status" => 400,
                    "msg" => "HUBO UN ERROR, INTENTE DE NUEVO"
            ];
            return json_encode($response);
        }  
    }

    
}