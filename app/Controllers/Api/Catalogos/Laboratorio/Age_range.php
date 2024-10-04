<?php 

/* Desarrollador: Airam Vargas
Fecha de creacion: 07 - 09 - 2023
Fecha de Ultima Actualizacion:
Perfil: Administrador
Descripcion: Catálogo de rangos de edades */

namespace App\Controllers\Api\Catalogos\Laboratorio;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');

class Age_range extends ResourceController {
    use ResponseTrait;
    var $db;
    var $model;

    public function __construct() {
        //Assign global variables
        $this->db = db_connect();
        $this->model = new \App\Models\Catalogos\Laboratorio\Age_range();
        helper('messages');
    }

    public function index(){
        $data["data"] = $this->model->showRanges();
        return $this->respond($data);
    }

    //insert data into data base
    public function create() {
        $request = \Config\Services::request();
        $maximo = $this->model->getMax()[0];
        $min = $request->getPost('min');
        $max = $request->getPost('max');

        $data = [
            'min' => $request->getPost('min'),
            'max' => $request->getPost('max'),
            'description' => $request->getPost('description')
        ];
        $id = $this->model->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);
        
        /*if($min + 1 > $maximo['maximo']){
           
        } else {
            $response = [
                "status" => 400,
                "msg" => "NO SE PUEDE AGREGAR EL RANGO DE EDAD, 
                EL VALOR MINIMO DEBE SER MAYOR A ".$maximo['maximo']
            ];
            return $this->respond($response);
        }*/
    }

    public function readRange() {
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $data = $this->model->readRange($id);
        return $this->respond($data);
    }

    public function update_() {
        //update way to pay
        $request = \Config\Services::request();
        $id = $request->getPost("id");

        $data = [
            'min' => $request->getPost('min'),
            'max' => $request->getPost('max'),
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

    public function getContainers(){
        $data = $this->model->showContainers();
        return $this->respond($data);
    }
}