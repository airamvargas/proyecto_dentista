<?php 

namespace App\Controllers\Api\Generales;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Administrador\Usuarios as model;

class Notificaciones extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct()
    {
        //Assign global variables
        $this->db = db_connect();
        helper('messages');
    }

    
    

    public function index()
     {
        $session = session();
        $user_id = $session->get('unique');
        $model_notificaciones = model('App\Models\Generales\Notificaciones');
        $data = $model_notificaciones->getNotificaciones($user_id);
        return $this->respond($data);
    }  
}