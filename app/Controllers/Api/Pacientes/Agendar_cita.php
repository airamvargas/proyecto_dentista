<?php

namespace App\Controllers\Api\Pacientes;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('sendmail');

use App\Models\models_paciente\citas as model;

class Agendar_cita extends ResourceController
{
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct()
    { //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }

    public function add_cita(){
        $request = \Config\Services::request();
        $date = str_replace('/', '-', $request->getPost('fecha'));
        $datetime = date('Y-m-d H:i:s', strtotime($date));
        
        $data = [
            'id_paciente' => $request->getPost('id_paciente'),
            'fecha' => $datetime,
            'observaciones' => $request->getPost('comentarios'),
        ];

        $this->model->insert($data);

        $affected_rows = $this->db->affectedRows();
        if($affected_rows){
            $mensaje = [
              'status' => 200,
              'msg' => "CITA AGREGADA CON EXITO"
            ];
            return $this->respond($mensaje);
        }else{
            $mensaje = [
                'status' => 400,
                'msg' => "Hubo un error al guardar los datos. Intenta de nuevo",    
            ]; 
            return $this->respond($mensaje);         
        }
    }

    public function get_fechas(){
        $data = $this->model->get_citas();
        return $this->respond($data, 200);
    }

    public function get_citas(){
        $data['data'] = $this->model->get_citas();
        return $this->respond($data, 200);
    }
}
