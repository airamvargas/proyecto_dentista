<?php 
namespace App\Controllers\Api\Catalogos;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Catalogos\Convenios as model;

class CondicionesIndividual extends ResourceController {
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct(){
        //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }      

    // Condiciones de convenio individuales
    public function read() {        
        //$model = model('App\Models\Catalogos\Convenios');
        $model_condiciones = model('App\Models\Catalogos\CondicionesConvenios');
        
        //$nombre = $_POST['nombre'];        
        //$id = $model->select('id')->where('name',$nombre)->first();
        $id = $_POST['id'];
        $data["data"] = $model_condiciones->condicionIndividual($id);        
        return $this->respond($data);
    } 
    
}