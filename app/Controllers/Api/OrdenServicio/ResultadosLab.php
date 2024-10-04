<?php 

/* Desarrollador: Airam Vargas
Fecha de creacion: 25 - 08 - 2023
Fecha de Ultima Actualizacion: 28 - 08 - 2023 Airam Vargas
Perfil: Recepcionista
Descripcion: Se manejara una tabla de las citas que hayan sido canceladas/rechazadas por los médicos
para que puedan ser reasignadas en otro horario */

namespace App\Controllers\Api\OrdenServicio;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Model_cotizacion\Cotizacion as model;
use App\Models\Administrador\Identity_employed as identity; 


class ResultadosLab extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct() {
        //Assign global variables
        $this->db = db_connect();
        $this->model = new model();
        $this->identity = new identity();
        helper('messages');
    }
    
    //FUNCION PARA DATATABLE
    public function showTable(){ 
        $session = session();
        $user_id = $session->get('unique');
        $unidad = $this->identity->select('id_cat_business_unit')->where('id_user', $user_id)->find()[0]['id_cat_business_unit'];
        $orden_servicio = $_POST['orden_servicio'];
        $fecha = $_POST['fecha'];
        $nombre = $_POST['nombre'];
        $data['data'] =  $this->model->showResultadosLab($unidad, $orden_servicio, $fecha, $nombre);
        return $this->respond($data);
    }

    //Busqueda de resultados por orden de servicio
    public function busquedaOrden(){
        $request = \Config\Services::request();
        $orden_servicio = $request->getPost('orden_servicio');
        $fecha = "";
        $nombre = "";
        $this->showTable($orden_servicio, $fecha, $nombre);
    } 

    //Busqueda de resultados por nombre y fecha
    public function busquedaNombre(){
        $request = \Config\Services::request();
        $orden_servicio = "";
        $fecha = $request->getPost('fecha');
        $nombre = $request->getPost('nombre');
        $this->showTable($orden_servicio, $fecha, $nombre);
    } 
}