<?php 
namespace App\Controllers\Api\Catalogos;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Catalogos\Convenios as model;

class ConveniosEmpresas extends ResourceController {
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct(){
        //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }      

    // Nombre de los convenios que tiene cada empresa
    public function read() {        
        $id = $_POST['id'];
        $data["data"] = $this->model->convenioEmpresa($id);
        return $this->respond($data);
    } 
    
}