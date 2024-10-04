<?php
/*Desarrollador: Giovanni Zavala
Fecha de creacion: 17 de junio de 2024
Fecha de Ultima Actualizacion: 17 de junio de 2024 
Perfil: Back Office
Descripcion: Reporte de pagos*/

namespace App\Controllers\Api\Back_office;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');

class Reportepagos extends ResourceController
{
    use ResponseTrait;
    var $db;

    public function __construct()
    { //Assign global variables
        $this->db = db_connect();
        helper('messages');
    }

    //FUNCION PARA DATATABLE DE REPORTE X ORDEN DE SERVICIO
    public function reportePagos()
    {
        $model_pagos = model('App\Models\Model_cotizacion\Model_pagos');
        $request = \Config\Services::request();
        $pager = \Config\Services::pager();
        $draw = $request->getVar('draw'); //dibuja contador 
        $length = $request->getVar('length'); //numero de registros que la tablla puede mostrar 
        $start = $request->getVar('start'); //Primer registro de paginacion
        $search =  $request->getVar('search')['value']; //valor de busqueda global
        $search2 =  $request->getVar('columns')[0]['search']['value']; //valor de la busqueda para aplicar a esa columna especifica


        $map_table = [
            0 => "P.id_cotization",
            1 => "P.id",
            2 => 'C.id',
            3 => 'wp.name',
            4 => 'pt.name',
            5 => 'amount',
            6 => "DATE_FORMAT(P.created_at ,'%d/%m/%Y')",
        ];

        $query_result =  "SELECT C.id as id_caja,P.id as id_pago,P.id_cotization,P.amount,pt.id, pt.name as tipo_pago, wp.name as forma_pago, 
        DATE_FORMAT(P.created_at ,'%d/%m/%Y') 
        AS Fecha FROM payments P LEFT JOIN cash_box C ON P.id_cash_box = C.id 
        LEFT JOIN payment_type pt ON pt.id = P.id_payment_type  
        LEFT JOIN way_to_pay wp ON wp.id = P.id_way_to_pay
        WHERE P.deleted_at = \"0000-00-00 00:00:00\"";

        $condicion = "";

        $column0 =  $request->getVar('columns')[0]['search']['value'];
        $column1 =  $request->getVar('columns')[1]['search']['value'];
        $column2 =  $request->getVar('columns')[2]['search']['value'];
        $column3 =  $request->getVar('columns')[3]['search']['value'];
        $column4 =  $request->getVar('columns')[4]['search']['value'];
        $column5 =  $request->getVar('columns')[5]['search']['value'];
        $column6 =  $request->getVar('columns')[6]['search']['value'];

        $columns = [$column0, $column1, $column2, $column3, $column4, $column5, $column6];

        //Buscador por columnas
        foreach ($map_table as $key => $val) {
            if (!empty($columns[$key])) {
                $condicion .= " AND " . $val . " LIKE '%" . $columns[$key] . "%'";
            }
        }


        //Buscador general 
        if (!empty($search)) {
            foreach ($map_table as $key => $val) {
                $condicion .= " OR " . $val . " LIKE '%" . $search . "%'";
            }
        }

        $sql_data = $query_result . $condicion;
        $sql_count = $model_pagos->reportPayments($sql_data);
        $sql_count = count($sql_count);
        $sql_data .=   " ORDER BY " . $map_table[$request->getVar('order')[0]['column']] . "
                       " . $request->getVar('order')[0]['dir'] . "" . " LIMIT " . $start . "," . $length . "";
        $data = $model_pagos->reportPayments($sql_data);

        $response = [
            "draw" => $draw,
            "recordsTotal" => $sql_count,
            "recordsFiltered" => $sql_count,
            "data" => $data,
            'sql' => $sql_data
        ];
        return $this->respondCreated($response);
    }
}
