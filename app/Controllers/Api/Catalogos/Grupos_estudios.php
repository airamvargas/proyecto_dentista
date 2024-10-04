<?php 

namespace App\Controllers\Api\Catalogos;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Catalogos\Category_lab as model;

class Grupos_estudios extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct() { //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }
    
    //CREAR UNA CATEGORIA DE ESTUDIO
    public function create(){ 
        $request = \Config\Services::request();

        $data = [
            'name' => $request->getPost('name'),
            'description' => $request->getPost('description')
        ];

        $id = $this->model->insert($data);

        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);
    }

    //FUNCION PARA DATATABLE
    public function readCategory(){
        $data['data'] = $this->model->readCategory();
        return $this->respond($data);
    }

    //OBTENER DATOS PARA ACTUALIZAR
    public function readExam(){ 
        $id = $_POST['id'];
        $data = $this->model->readExam($id);
        return $this->respond($data);
    }

    //EDITAR REGISTRO 
    public function update_(){ 
        $request = \Config\Services::request();

        $data = [
            'name' => $request->getPost('name'),
            'description' => $request->getPost('description')
        ];

        $this->model->update($request->getPost('id'), $data);

        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje; 
    }

    //ELIMINAR REGISTRO
    public function delete_(){ 
        $request = \Config\Services::request();

        $this->model->delete($request->getPost('id'));

        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje;
    }

    //OBTENER DATOS PARA UN SELECT
    public function get_groups(){
        $data = $this->model->readGroups();
        return $this->respond($data);
    }
}