<?php 

namespace App\Controllers\Api;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Catalogos\Waytopay as model;

class Waytopay extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct()
    {
        //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }
    
    public function read()
    {    //data from the datatable
        $data["data"] = $this->model->redWayToPay();
        return $this->respond($data);
    }

    public function create()
    {
        //insert data into data base
        foreach ($_POST as $name => $val)
        {
            $data[$name] = $val;
        }
        //retun id
        $id = $this->model->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje); 
    }

    public function readwaytopay()
    {
        //we get data from a single record
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $data = $this->model->getWayToPay($id);
        return $this->respond($data);
    }

    public function update_()
    {
        //update way to pay
        $request = \Config\Services::request();
        $id = $request->getVar("id");

        foreach ($_POST as $name => $val)
        {
            if($name !="id"){
                $data[$name] = $val;
            }
            
        }

        $this->model->update($id, $data);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje; 

        
    }

    public function delete_()
    {
        //delete way to pay
        $request = \Config\Services::request();
        $id = $request->getVar("id_delete");
        $this->model->delete($id);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje;
    }   
}