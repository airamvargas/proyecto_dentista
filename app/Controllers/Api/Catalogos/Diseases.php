<?php

namespace App\Controllers\Api\Catalogos;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Catalogos\Diseases as model;

class Diseases extends ResourceController
{
    use ResponseTrait;
    protected $model;
    protected $db;

    public function __construct()
    {
        //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }

    public function read()
    {    //data from the datatable
        $data["data"] = $this->model->redDiseases();
        return $this->respond($data);
    }

    public function create()
    {
        //validate id_c10 empty
        if ($_POST['id_c10'] != "") {
            $id_c10 = $_POST["id_c10"];
            $id_cat_illness_type = $_POST["id_cat_illness_type"];
            $array = $this->model->existdata($id_c10, $id_cat_illness_type);
            $count = count($array);
            //validate data not exist into the database
            if ($count > 0) {
                $mensaje = $this->errors($error = 401);
                return $this->respond($mensaje);
            } else {
                //insert data into data base
                foreach ($_POST as $name => $val) {
                    $data[$name] = $val;
                }
                //retun id
                $id = $this->model->insert($data);
                $mensaje = messages($insert = 0, $id);
                return $this->respond($mensaje);
            } 
        } else {
            $mensaje = $this->errors($error = 400);
            return $this->respond($mensaje);
        }
    }

    public function readDisease()
    {
        //we get data from a single record
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $data = $this->model->getDisease($id);
        return $this->respond($data);
    }

    public function update_()
    {
        //update diase
        $request = \Config\Services::request();
        if ($_POST['id_c10'] != "") {
            $id_c10 = $_POST["id_c10"];
            $id_cat_illness_type = $_POST["id_cat_illness_type"];
            $id = $request->getVar("id");
            $array = $this->model->existUpdate($id_c10, $id_cat_illness_type,$id);
            if ($array[0]['id'] > 0) {
                $mensaje = $this->errors($error = 401);
                return $this->respond($mensaje);
            } else {
                foreach ($_POST as $name => $val) {
                    if ($name != "id") {
                        $data[$name] = $val;
                    }
                }
                $this->model->update($id, $data);
                //retun affected rows into database
                $affected_rows = $this->db->affectedRows();
                $mensaje = messages($update = 1, $affected_rows);
                return $mensaje; 
            }

        }else {
            $mensaje = $this->errors($error = 400);
            return $this->respond($mensaje);
        }
  
    }

    public function delete_() {
        //delete way to pay
        $request = \Config\Services::request();
        $id = $request->getVar("id_delete");
        $this->model->delete($id);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje;
    }

    public function redIllnessType() {
        $model = model('App\Models\Catalogos\IllnessType');
        $data = $model->getIllnessTypes();
        return $this->respond($data);
    }

    public function getC10($busqueda) {
        $model = model('App\Models\Catalogos\C10');
        $data = $model->getENFERMEDAD($busqueda);
        return $this->respond($data, 200);
    }

    //Obtener listado de enfermedades heredofamiliares
    public function readEts(){
        $data = $this->model->readEts();
        return $this->respond($data);
    }

    //Obtener listado de enfermedades heredofamiliares
    public function readHeredofam(){
        $data = $this->model->readHeredofam();
        return $this->respond($data);
    }

    //Obtener listado de alergias
    public function readAlergias(){
        $data = $this->model->readAlergias();
        return $this->respond($data);
    }

    //Obtener listado de enfermedades infectocontagiosas
    public function readInfectocontagiosas(){
        $data = $this->model->readInfectocontagiosas();
        return $this->respond($data);
    }

    //Obtener listado de enfermedades de la infancia
    public function readEnfermedadesInfancia(){
        $data = $this->model->readEnfermedadesInfancia();
        return $this->respond($data);
    }

    public function errors($error){
        switch ($error):
            case 400:
                $mensaje = "NO SELECCIONO NINGUN ELEMENTO EN LA BUSQUEDA";
                break;
            case 401:
                $mensaje = "LOS DATOS YA EXITEN";
                break;
            case 2:
                $mensaje = "AGREGADO";
                break;
            default:
        endswitch;
        $data = [
            "status" => 400,
            "msg" => $mensaje
        ];
        return $data;
    }
}
