<?php
/* 
Desarrollador: Jesus Esteban Sanchez Alcantara
Fecha Creacion: 11-septiembre-2023
Fecha de Ultima Actualizacion: 11-septiembre-2023
Perfil: Administracion
Descripcion: Catalogo de agrupadores para los analitos
*/ 

namespace App\Controllers\Api\Catalogos\Laboratorio;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Catalogos\Laboratorio\Agrupador as model;

helper('Acceso');

class Agrupador extends ResourceController
{
    use ResponseTrait;
    var $db;
    var $model;

    public function __construct()
    {
        //Assign global variables
        $this->db = db_connect();
        $this->model = new model();
        helper('messages');
    }

    //show data on table
    public function read(){
        $data["data"] = $this->model->readAgrupador();
        return $this->respond($data);
    }

    //create a new sample type
    public function create(){
        $request = \Config\Services::request();
        $data = [
            'name' => $request->getPost('nombre'),
            'description' => $request->getPost('descripcion')
        ];
        $id = $this->model->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);
    }

    // get element to modify
    public function getAgrupador(){
        $request = \Config\Services::request();
        $id_agrupador = $request->getPost('id');
        $data = $this->model->getAgrupador($id_agrupador);
        return $this->respond($data); 
    }

    //update element
    public function update_(){
        $request = \Config\Services::request();
        $id = $request->getVar("id");
        // array to edit
        $data = [
            'name' => $request->getPost('nombre'),
            'description' => $request->getPost('descripcion')
        ];
        $this->model->update($id, $data);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje;
    }

    // delete element 
    public function delete_(){
        $request = \Config\Services::request();
        $id_grouper = $request->getVar("id_delete");
        $this->model->delete($id_grouper);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje;
    }
}
