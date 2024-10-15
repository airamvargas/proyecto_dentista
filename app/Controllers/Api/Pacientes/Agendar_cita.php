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
        $datetime = date('H:i:s', strtotime($request->getPost('fecha')));
        
        $data = [
            'id_paciente' => $request->getPost('id_paciente'),
            'fecha' => $date,
            'hora' => $datetime,
            'observaciones' => $request->getPost('comentarios'),
        ];

        var_dump($data);
    }

    public function registro_paciente(){
        $request = \Config\Services::request();
        
        $data = [
            'nombre' => $request->getPost('nombre'),
            'sex' => $request->getPost('sex'),
            'f_nacimiento' => $request->getPost('f_nacimiento'),
            'lugar_nac' => $request->getPost('lugar_nac'),
            'tel_casa' => $request->getPost('tel_casa'),
            'tel_cel' => $request->getPost('tel_celular'),
            'direccion' => $request->getPost('direccion')

        ];
        //var_dump($data);
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

    public function readPacientes($busqueda){
        $data = $this->model->readPacientes($busqueda);
        return $this->respondCreated($data, 200);    
    }

    public function updatePaciente(){
        $id = $_POST['id'];
        $data = $this->model->readPaciente($id);
        return $this->respond($data);
    }

    public function actualizar(){
        $request = \Config\Services::request();

        $data = [
            'nombre' => $request->getPost('nombre'),
            'sex' => $request->getPost('sex'),
            'f_nacimiento' => $request->getPost('f_nacimiento'),
            'lugar_nac' => $request->getPost('lugar_nac'),
            'tel_casa' => $request->getPost('tel_casa'),
            'tel_cel' => $request->getPost('tel_celular'),
            'direccion' => $request->getPost('direccion')

        ];
        
        $id = $this->model->update($request->getPost('id_update'), $data);

        if($id){
            $mensaje = [
              'status' => 200,
              'msg' => "DATOS ACTUALIZADOS",
              'id' => $id
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

    public function eliminar(){
        $request = \Config\Services::request();
        $this->model->delete($request->getPost('id'));
        $affected_rows = $this->db->affectedRows();

        if($affected_rows){
            $mensaje = [
              'status' => 200,
              'msg' => "DATO ELIMINADO"
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
