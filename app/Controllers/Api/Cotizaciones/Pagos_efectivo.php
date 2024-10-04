<?php

namespace App\Controllers\Api\Cotizaciones;

require_once __DIR__ . '../../../vendor/autoload.php';

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');
helper('sendmail');

use App\Models\Model_cotization_product\cotization_product as model;

class Pagos_efectivo extends ResourceController
{
    use ResponseTrait;
    var $model;
    var $db;
    var $pagos;

    //funcion del constructor para variables globales
    public function __construct()
    { //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        $this->pagos = new \App\Models\Model_cotizacion\Model_pagos();
        helper('messages');
    }

    public function getPayments(){
        $id_box = $_POST['id'];
        $data['data'] = $this->pagos->getPayments($id_box);
        return $this->respond($data);
    }
}