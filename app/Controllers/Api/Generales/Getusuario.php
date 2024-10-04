<?php

namespace App\Controllers\Api\Generales;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');

use App\Models\Administrador\Usuarios as model;

class Getusuario extends ResourceController
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



    //obtenemos imagen de usuario
    public function index()
    {
        $session = session();
        $grupo = $session->get('group');

        switch (true) {
            case ($grupo == 7 || $grupo == 8 || $grupo == 9):
                $model_medico = model('App\Models\HCV\Operativo\Ficha_Identificacion');
                $id_user = $session->get('unique');
                $data = $model_medico->getImage($id_user);
                return $this->respond($data);
                break;

            case ($grupo != 4  || $grupo != 7 || $grupo != 8 || $grupo != 9):
                $identity = model('App\Models\Administrador\Identity_employed');
                $id_user = $session->get('unique');
                $data = $identity->getImage($id_user);
                return $this->respond($data);
                break;

            case ($grupo == 4):
                $paciente = model('App\Models\Models_hcv\Model_identity');
                $id_user = $session->get('unique');
                $data = $paciente->getImage($id_user);
                return $this->respond($data);
                break;
        }


        /*   $request = \Config\Services::request();
        $model = model('App\Models\Administrador\Usuarios');
        $data = $model->find($user_id);
        return $this->respond($data);  */
    }
}
