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

    public function read_cita(){
        $id_cita = $_POST['id_cita'];
        $data = $this->model->read_cita($id_cita);
        return $this->respond($data, 200);
    }
    public function get_horasdip(){
        $uri = service('uri');
        $fecha = $uri->getSegment(6);
        $id_cita = $uri->getSegment(5);
        $data = $this->model->horas_disp($fecha);

        $array2 = [];

        foreach ($data as $key) {
            array_push($array2, $key['horas']);
        }

        $array_horas = [
            "00:00:00","00:30:00",
            "01:00:00","01:30:00",
            "02:00:00","02:30:00",
            "03:00:00","03:30:00",
            "04:00:00","04:30:00",
            "05:00:00","05:30:00",
            "06:00:00","06:30:00",
            "07:00:00","07:30:00",
            "08:00:00","08:30:00",
            "09:00:00","09:30:00",
            "10:00:00","10:30:00",
            "11:00:00","11:30:00",
            "12:00:00","12:30:00",
            "13:00:00","13:30:00",
            "14:00:00","14:30:00",
            "15:00:00","15:30:00",
            "16:00:00","16:30:00",
            "17:00:00","17:30:00",
            "18:00:00","18:30:00",
            "19:00:00","19:30:00",
            "20:00:00","20:30:00",
            "21:00:00","21:30:00",
            "22:00:00","22:30:00",
            "23:00:00","23:30:00",
            
        ];

        $resultado = array_diff($array_horas, $array2);
        $data2 = [];
        foreach ($resultado as $key) {
            array_push($data2, $key);
        }
        return $this->respond($data2, 200);
    }

    public function reasignar(){
        $request = \Config\Services::request();
        $date = $request->getPost('fecha')." ". $request->getPost('horasdisp');
        $datetime = date('Y-m-d H:i:s', strtotime($date));
        
        $data = [
            'fecha' => $datetime,
            'observaciones' => $request->getPost('comentarios'),
        ];

        $this->model->update($request->getPost('id_reasignar'), $data);

        $affected_rows = $this->db->affectedRows();
        if($affected_rows){
            $mensaje = [
              'status' => 200,
              'msg' => "CITA MOFICADA CON EXITO"
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

    public function cancelar(){
        $request = \Config\Services::request();

        $data = [
            'status_cita' => 2
        ];

        $this->model->update($request->getPost('id'), $data);
        $this->model->delete($request->getPost('id'));

        $affected_rows = $this->db->affectedRows();
        if($affected_rows){
            $mensaje = [
              'status' => 200,
              'msg' => "CITA CANCELADA"
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
