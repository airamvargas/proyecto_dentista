<?php

namespace App\Controllers\Api\Pacientes;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('sendmail');

use App\Models\models_paciente\citas as model;
use App\Models\models_paciente\Tratamientos_x_cita as trata_x_cita; 
use App\Models\models_paciente\Pacientes as pacientes; 

class Consulta extends ResourceController
{
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct()
    { //Assign global variables
        $this->model = new model();
        $this->trata_x_cita = new trata_x_cita();
        $this->pacientes = new pacientes();
        $this->db = db_connect();
        helper('messages');
    }

    public function getNombre($id_cita){
        $data = $this->model->getNombre($id_cita);
        return $this->respond($data);
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

        $this->trata_x_cita->insert($data);

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

    //OBTENER LOS TRATAMIENTOS REALIZADOS EN UNA CITA
    public function trata_x_cita(){
        $id_cita = $_POST['id_cita'];
        $data['data'] = $this->trata_x_cita->trata_x_cita($id_cita);
        return $this->respond($data);
    }

    //OBTENER EL PRECIO TOTAL 
    public function getTotal($id_cita) {;
        $data = $this->trata_x_cita->get_total($id_cita);
        return $this->respond($data);
    }

    public function getNombreHist($id_paciente){
        $data = $this->pacientes->getNombre($id_paciente);
        return $this->respond($data);
    }

}