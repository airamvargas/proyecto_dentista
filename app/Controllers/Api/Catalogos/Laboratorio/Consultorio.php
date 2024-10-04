<?php 

namespace App\Controllers\Api\Catalogos\Laboratorio;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Catalogos\Laboratorio\Consulting_room as model;
helper('Acceso');

class Consultorio extends ResourceController 
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

    public function index(){
        $data["data"] = $this->model->getConsultingroom();
        return $this->respond($data);

    }
    
    //Traemos las unidades de negocio
    public function showUnitBussines(){
        $model = model('App\Models\Catalogos\BusinessUnit');
        $data = $model->getBusinessUnits();
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

    public function readConsultorio(){
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $data = $this->model->getConsulting($id);
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

    public function readRooms(){
        $id_unit = $_POST['id'];
        $data = $this->model->readRooms($id_unit);
        return $this->respond($data);
    }

}