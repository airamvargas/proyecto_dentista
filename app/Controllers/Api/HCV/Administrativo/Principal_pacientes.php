<?php

namespace App\Controllers\Api\HCV\Administrativo;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');

use App\Models\HCV\Paciente\Ficha_identificacion_paciente as model;

class Principal_pacientes extends ResourceController
{
  use ResponseTrait;
  var $model;
  var $db;

  public function __construct()
  { //Assign global variables
    $this->model = new model();
    $this->db = db_connect();
    helper('messages');
  }

  public function read()
  {
    $request = \Config\Services::request();
    $model_pacientes = model('App\Models\HCV\Paciente\Ficha_identificacion_paciente');

    // Server side
    $pager = \Config\Services::pager();
    $draw = $request->getVar('draw'); //dibuja contador 
    $length = $request->getVar('length'); //numero de registros que la tabla puede mostrar 
    $start = $request->getVar('start'); //Primer registro de paginacion
    $search =  $request->getVar('search')['value']; //valor de busqueda global  

    $map_table = [
      0 => "foto",
      1 => "nombre",
      2 => "correo",
      3 => 'numero',
    ];

    // Consulta para traer todos los pacientes registrados en base
    $query_result = 'select hcv_identity.ID as id,concat(hcv_identity.NAME, " " ,hcv_identity.F_LAST_NAME, " " ,hcv_identity.S_LAST_NAME)as nombre, hcv_identity.PATH as foto, hcv_identity.PHONE_NUMBER as numero,
    hcv_identity.BIRTHDATE, hcv_identity.SEX, groups.name as nombre_grupo, users.email as correo FROM hcv_identity JOIN users on users.id = hcv_identity.ID_USER 
    JOIN groups ON groups.id = users.id_group WHERE hcv_identity.deleted_at IS NULL';

    $condicion = "";

    $column0 =  $request->getVar('columns')[0]['search']['value'];
    $column1 =  $request->getVar('columns')[1]['search']['value'];
    $column2 =  $request->getVar('columns')[2]['search']['value'];
    $column3 =  $request->getVar('columns')[3]['search']['value'];

    //Buscador general 
    if (!empty($search)) {
      foreach ($map_table as $key => $val) {
        if ($key == 0) {
          $condicion .= " HAVING " . $val . " LIKE '%" . $search . "%'";
        } else { //OR name LIKE valor  
          $condicion .= " OR " . $val . " LIKE '%" . $search . "%'";
        }
      }
    }

    $sql_data = $query_result . $condicion;
    $sql_count = $model_pacientes->get_pacientes($sql_data);
    $sql_count = count($sql_count);
    $sql_data .=   " ORDER BY " . $map_table[$request->getVar('order')[0]['column']] . "
                     " . $request->getVar('order')[0]['dir'] . "" . " LIMIT " . $start . "," . $length . "";
    $data = $model_pacientes->get_pacientes($sql_data);

    $response = [
      "draw" => $draw,
      "recordsTotal" => $sql_count,
      "recordsFiltered" => $sql_count,
      "data" => $data,
    ];
    return $this->respondCreated($response);
  }

  //delete paciente
  public function delete_()
  {
    $request = \Config\Services::request();
    $id = $request->getVar("id_delete");
    $this->model->delete($id);
    //retun affected rows into database
    $affected_rows = $this->db->affectedRows();
    $mensaje = messages($detele = 2, $affected_rows);
    return $mensaje;
  }
}
