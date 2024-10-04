<?php 

/* Desarrollador: Airam Vargas
Fecha de creacion: 07 - 09 - 2023
Fecha de Ultima Actualizacion:
Perfil: Administrador
Descripcion: Catálogo de métodos que pueden utilizarse */

namespace App\Controllers\Api\Catalogos\Laboratorio;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');

class Metodos extends ResourceController {
    use ResponseTrait;
    var $db;
    var $model;

    public function __construct() {
        //Assign global variables
        $this->db = db_connect();
        $this->model = new \App\Models\Catalogos\Laboratorio\Cat_methods();
        helper('messages');
    }

    public function index(){
        $data["data"] = $this->model->showMethods();
        return $this->respond($data);
    }

    //insert data into data base
    public function create() {
        $request = \Config\Services::request();
        
        $data = [
            'name' => $request->getPost('name'),
            'description' => $request->getPost('description')
        ];

        //var_dump($request);
        //retun id
        $id = $this->model->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje); 
    }

    public function readMethod() {
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $data = $this->model->readMethod($id);
        return $this->respond($data);
    }

    public function update_() {
        //update way to pay
        $request = \Config\Services::request();
        $id = $request->getPost("id");

        $data = [
            'name' => $request->getPost('name'),
            'description' => $request->getPost('description')
        ];

        $this->model->update($id, $data);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje; 
    }

    // ELIMINAR UN CONTENEDOR
    public function delete_() {
        $request = \Config\Services::request();
        $id = $request->getPost("id");
        $this->model->delete($id);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje;
    }  

    public function getMethods(){
        $data = $this->model->getMethods();
        return $this->respond($data);
    }
}