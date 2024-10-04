<?php 

/* Desarrollador: Airam V. Vargas Lopez
Fecha de creacion: 15 de noviembre de 2023
Fecha de Ultima Actualizacion: 
Perfil: Recepcionista
Descripcion: Resuoltados de estudios para pacientes */

namespace App\Controllers\Api\Resultados;

use App\Controllers\Api\HCV\Administrativo\Citas;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use DateTime;
helper('Acceso');

class Resultados_paciente extends ResourceController {
    use ResponseTrait;
    var $model;
    var $db;
    var $identity;
    var $citas;

    public function __construct() {
        //Assign global variables
        $this->db = db_connect();
        $this->citas = new \App\Models\Model_cotizacion\Model_citas();
        helper('messages');
    }
    
    //FUNCION PARA DATATABLE
    public function show($id = NULL) { 
        $id_cotizacion = $_POST['id_cotizacion'];
        $data['data'] = $this->citas->showResultados($id_cotizacion);
        return $this->respond($data); 
    }
}