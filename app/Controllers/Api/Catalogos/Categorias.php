<?php 

namespace App\Controllers\Api\Catalogos;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');

class Categorias extends ResourceController 
{
    use ResponseTrait;
    var $db;

    public function __construct()
    {
        //Assign global variables
        $this->db = db_connect();
        helper('messages');
    }
    
     //show data on tables
     public function read() {

         $model = model('App\Models\Catalogos\Categorias');
        $data["data"] = $model -> getCategorias(); 
        return $this->respond($data); 
    }

    //create a new element
    public function create(){
        $model = model('App\Models\Catalogos\Categorias');
        $request = \Config\Services::request();

        $data = [
            'name'=> $request->getPost('nombre'),
            'description' => $request->getPost('description')
        ];

        $id = $model->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);
    }

    // read element to modify
    public function readCategoria(){

        $model = model('App\Models\Catalogos\Categorias');
        $request = \Config\Services::request();
        $id_categoria = $request->getPost('id');
        $data = $model -> getCategoria($id_categoria);
        return $this->respond($data);

    }

    //update element
    public function update_(){
        $model = model('App\Models\Catalogos\Categorias');
        $request = \Config\Services::request();
        $id = $request ->getVar("id");

        $data = [
            'name'=> $request->getPost('nombre'),
            'description'=> $request->getPost('description') 
        ];

        $model ->update($id, $data);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje; 
    }


    // delete element 
    public function delete_(){
        $model = model('App\Models\Catalogos\Categorias');
        $request = \Config\Services::request();
        $id_category = $request ->getVar("id_delete");
        $model->delete($id_category);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje; 
     
    
    }
}