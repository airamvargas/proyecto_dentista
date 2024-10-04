<?php

namespace App\Controllers\Api\Pacientes;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('sendmail');

use App\Models\models_paciente\Pacientes as model;

class Historia_clinica extends ResourceController
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
        
        $id = $this->model->insert($data);

        if($id){
            $mensaje = [
              'status' => 200,
              'msg' => "AGREGADO CON EXITO",
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
}
