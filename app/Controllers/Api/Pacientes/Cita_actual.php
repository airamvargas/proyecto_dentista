<?php

namespace App\Controllers\Api\Pacientes;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('sendmail');

use App\Models\models_paciente\Tratamientos_x_cita as model;

class Cita_actual extends ResourceController
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

    public function add_tratamiento(){
        $request = \Config\Services::request();
        $precio = $request->getPost('precio') * $request->getPost('cantidad');
        $data = [
            'id_cita' => $request->getPost('id_cita'),
            'id_tratamiento' => $request->getPost('id_tratamiento'),
            'precio' => $precio,
            'cantidad' => $request->getPost('cantidad')
        ];

        $this->model->insert($data);

        $affected_rows = $this->db->affectedRows();
        if($affected_rows){
            $mensaje = [
              'status' => 200,
              'msg' => "AGREGADO CON EXITO"
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

}
