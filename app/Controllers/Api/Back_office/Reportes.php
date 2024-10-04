<?php
/*Desarrollador: Airam V. Vargas López
Fecha de creacion: 13 de noviembre de 2023
Fecha de Ultima Actualizacion: 30 de enero de 2024 - Airam Vargas
Perfil: Back Office
Descripcion: Api de los reportes a realizar*/

namespace App\Controllers\Api\Back_office;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');

class Reportes extends ResourceController
{
    use ResponseTrait;
    var $db;

    public function __construct()
    { //Assign global variables
        $this->db = db_connect();
        helper('messages');
    }

    //FUNCION PARA DATATABLE DE REPORTE X ORDEN DE SERVICIO
    public function readVentas()
    {
        $model_pagos = model('App\Models\Model_cotizacion\Model_pagos');
        $request = \Config\Services::request();
        $pager = \Config\Services::pager();
        $draw = $request->getVar('draw'); //dibuja contador 
        $length = $request->getVar('length'); //numero de registros que la tablla puede mostrar 
        $start = $request->getVar('start'); //Primer registro de paginacion
        $search =  $request->getVar('search')['value']; //valor de busqueda global
        $search2 =  $request->getVar('columns')[0]['search']['value']; //valor de la busqueda para aplicar a esa columna especifica
        $fechamin =  $request->getVar('minDate');
        $fechamax = $request->getVar('maxDate');

        if (!empty($fechamin) and !empty($fechamax)) {
            $fechamin = date("Y-m-d", strtotime($fechamin));
            $fechamax = date("Y-m-d", strtotime($fechamax));
            $rango = " having fecha between '" . $fechamin . "' and '" . $fechamax . "'";
        } else {
            $rango = "";
        }

        $map_table = [
            0 => "id_cotizacion",
            1 => "fecha",
            2 => "unidad",
            3 => 'convenio',
            4 => 'company',
            5 => 'paciente',
            6 => 'forma_pago',
            7 => 'tipo_pago',
            8 => 'monto_pago',
            9 => 'monto_pagado',
            10 => 'num_caja'
        ];

        $query_result =  "SELECT * FROM (
            SELECT cotization.id AS id_cotizacion, cotization.c_date AS fecha,
            (SELECT cat_business_unit.name FROM cat_business_unit WHERE cat_business_unit.id = cotization.id_business_unit) AS unidad,
            (SELECT cat_conventions.name FROM cat_conventions WHERE cat_conventions.id = cotization.id_conventions) AS convenio,
            (SELECT cat_company_client.name FROM cat_company_client JOIN cat_conventions ON cat_company_client.id = cat_conventions.id_cat_company_client WHERE cat_conventions.id = cotization.id_conventions) AS company,
            (SELECT CONCAT(hcv_identity.NAME,' ', F_LAST_NAME,' ', S_LAST_NAME) FROM hcv_identity WHERE hcv_identity.ID_USER = id_user_client) AS paciente,
            way_to_pay.name AS forma_pago, payment_type.name AS tipo_pago, amount AS monto_pago,
            (SELECT SUM(monto) FROM crm_abonos_x_pagos WHERE crm_abonos_x_pagos.id_payment = payments.id AND crm_abonos_x_pagos.deleted_at IS NULL) AS monto_pagado,
            id_cash_box AS num_caja
            FROM payments
            JOIN cotization ON payments.id_cotization = cotization.id
            JOIN way_to_pay ON way_to_pay.id = payments.id_way_to_pay
            JOIN payment_type ON payment_type.id = payments.id_payment_type
            WHERE show_cotization = 1 AND payments.deleted_at IS NULL
        ) AS subquery
        WHERE 1=1";

        $condicion = "";

        $column0 =  $request->getVar('columns')[0]['search']['value'];
        $column1 =  $request->getVar('columns')[1]['search']['value'];
        $column2 =  $request->getVar('columns')[2]['search']['value'];
        $column3 =  $request->getVar('columns')[3]['search']['value'];
        $column4 =  $request->getVar('columns')[4]['search']['value'];
        $column5 =  $request->getVar('columns')[5]['search']['value'];
        $column6 =  $request->getVar('columns')[6]['search']['value'];
        $column7 =  $request->getVar('columns')[7]['search']['value'];
        $column8 =  $request->getVar('columns')[8]['search']['value'];
        $column9 =  $request->getVar('columns')[9]['search']['value'];
        $column10 =  $request->getVar('columns')[10]['search']['value'];

        $columns = [$column0, $column1, $column2, $column3, $column4, $column5, $column6, $column7, $column8, $column9, $column10];

        //Buscador por columnas
        foreach ($map_table as $key => $val) {
            if (!empty($columns[$key])) {
                $query_result .= " AND " . $val . " LIKE '%" . $columns[$key] . "%'";
            }
        }


        //Buscador general 
        if (!empty($search)) {
            foreach ($map_table as $key => $val) {
                if ($key == 0) {
                    $condicion .= " HAVING " . $val . " LIKE '%" . $search . "%'";
                } else { //OR name LIKE valor
                    /* if($map_table[$key] ==='fecha_alta' || 'fecha_actualizacion'){
                       $fecha = $request->getVar('columns')[$key]['search']['value'];
                       if(preg_match("/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/", $fecha)) {
                           $date = str_replace('/', '-', $fecha);
                           $fecha2 = date("Y-m-d", strtotime($date));
                           $condicion .= " OR " .$val. " LIKE '%".$fecha2."%'";
                          
                        }else{
                           $condicion .= " OR " .$val. " LIKE '%".$fecha."%'";
                        }
                   }else{
                       $condicion .= " OR " .$val. " LIKE '%".$request->getVar('columns')[$key]['search']['value']."%'";

                   } */
                    $condicion .= " OR " . $val . " LIKE '%" . $search . "%'";
                }
            }
        }

        $sql_data = $query_result . $condicion . $rango;
        $sql_count = $model_pagos->reporteVentas($sql_data);
        $sql_count = count($sql_count);
        $sql_data .=   " ORDER BY " . $map_table[$request->getVar('order')[0]['column']] . "
                       " . $request->getVar('order')[0]['dir'] . "" . " LIMIT " . $start . "," . $length . "";
        $data = $model_pagos->reporteVentas($sql_data);

        $response = [
            "draw" => $draw,
            "recordsTotal" => $sql_count,
            "recordsFiltered" => $sql_count,
            "data" => $data,
            'sql' => $sql_data
        ];

        return $this->respondCreated($response);
        //$data['data'] = $model_pagos->reporteVentas();
        // return $this->respond($data); 
    }

    //FUNCION PARA DATATABLE DE REPORTE X PRODUCTOS
    public function reporteProductos()
    {
        $model_cotizacion = model('App\Models\Model_cotizacion\Cotizacion');
        $request = \Config\Services::request();
        $pager = \Config\Services::pager();
        $draw = $request->getVar('draw'); //dibuja contador 
        $length = $request->getVar('length'); //numero de registros que la tablla puede mostrar 
        $start = $request->getVar('start'); //Primer registro de paginacion
        $search =  $request->getVar('search')['value']; //valor de busqueda global
        $search2 =  $request->getVar('columns')[0]['search']['value']; //valor de la busqueda para aplicar a esa columna especifica
        $fechamin =  $request->getVar('minDate');
        $fechamax = $request->getVar('maxDate');

        if (!empty($fechamin) and !empty($fechamax)) {
            $fechamin = date("Y-m-d", strtotime($fechamin));
            $fechamax = date("Y-m-d", strtotime($fechamax));
            $rango = " AND fecha between '".$fechamin."' and '".$fechamax."'";
        }else{
            $rango = "";
        }

        $map_table = [
            0 => "id_cotizacion",
            1 => "fecha",
            2 => "unidad",
            3 => 'convenio',
            4 => 'paciente',
            5 => 'area_lab',
            6 => 'producto',
            7 => 'price'
        ];
       
        $query_result =  "SELECT * FROM (
            SELECT cotization.id AS id_cotizacion, cotization.c_date AS fecha, 
            (SELECT cat_business_unit.name FROM cat_business_unit WHERE cat_business_unit.id = cotization.id_business_unit) AS unidad, 
            (SELECT cat_conventions.name FROM cat_conventions WHERE cat_conventions.id = cotization.id_conventions) AS convenio, 
            (SELECT CONCAT(hcv_identity.NAME,' ', F_LAST_NAME,' ', S_LAST_NAME) FROM hcv_identity WHERE hcv_identity.ID_USER = id_user_client) AS paciente, 
            insumos.name_table, insumos.id_category, (SELECT name FROM category WHERE category.id = insumos.id_category) AS categoria, 
            (SELECT category_lab.name FROM cat_studies JOIN category_lab ON category_lab.id = cat_studies.id_category_lab WHERE insumos.id_product = cat_studies.id) AS area_lab, 
            insumos.name AS producto, price FROM cotization JOIN cotization_x_products ON cotization_x_products.id_cotization = cotization.id JOIN insumos ON insumos.id =
            cotization_x_products.id_cat_products WHERE show_cotization = 1 AND cotization_x_products.deleted_at IS NULL
        ) AS subquery WHERE 1=1";
        $condicion = "";

        $column0 =  $request->getVar('columns')[0]['search']['value'];
        $column1 =  $request->getVar('columns')[1]['search']['value'];
        $column2 =  $request->getVar('columns')[2]['search']['value'];
        $column3 =  $request->getVar('columns')[3]['search']['value'];
        $column4 =  $request->getVar('columns')[4]['search']['value'];
        $column5 =  $request->getVar('columns')[5]['search']['value'];
        $column6 =  $request->getVar('columns')[6]['search']['value'];
        $column7 =  $request->getVar('columns')[7]['search']['value'];

        $columns = [$column0, $column1, $column2, $column3, $column4, $column5, $column6,$column7];
      
        //Buscador por columnas
        foreach ($map_table as $key => $val) {
            if (!empty($columns[$key])) {
                $query_result .= " AND " . $val . " LIKE '%" . $columns[$key] . "%'";
            }
        }

        //Buscador general 
        if (!empty($search)) {
            foreach ($map_table as $key => $val) {
                if ($key == 0) {
                    $condicion .= " HAVING " . $val . " LIKE '%" . $search . "%'";
                } else { //OR name LIKE valor
                    /* if($map_table[$key] ==='fecha_alta' || 'fecha_actualizacion'){
                       $fecha = $request->getVar('columns')[$key]['search']['value'];
                       if(preg_match("/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/", $fecha)) {
                           $date = str_replace('/', '-', $fecha);
                           $fecha2 = date("Y-m-d", strtotime($date));
                           $condicion .= " OR " .$val. " LIKE '%".$fecha2."%'";
                          
                        }else{
                           $condicion .= " OR " .$val. " LIKE '%".$fecha."%'";
                        }
                   }else{
                       $condicion .= " OR " .$val. " LIKE '%".$request->getVar('columns')[$key]['search']['value']."%'";

                   } */
                    $condicion .= " OR " . $val . " LIKE '%" . $search . "%'";
                }
            }
        }

        $sql_data = $query_result . $condicion . $rango;
        $sql_count = $model_cotizacion->reporteProductos($sql_data);
        $sql_count = count($sql_count);
        $sql_data .=   " ORDER BY " . $map_table[$request->getVar('order')[0]['column']] . "
                        " . $request->getVar('order')[0]['dir'] . "" . " LIMIT " . $start . "," . $length . "";
        $data = $model_cotizacion->reporteProductos($sql_data);

        $response = [
            "draw" => $draw,
            "recordsTotal" => $sql_count,
            "recordsFiltered" => $sql_count,
            "data" => $data,
            'data_sql' => $sql_data
        ];

        return $this->respondCreated($response);
    }

    //FUNCION PARA DATATABLE DE REPORTE DE PACIENTES
    public function readPacientes()
    {
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $request = \Config\Services::request();
        $pager = \Config\Services::pager();
        $draw = $request->getVar('draw'); //dibuja contador 
        $length = $request->getVar('length'); //numero de registros que la tablla puede mostrar 
        $start = $request->getVar('start'); //Primer registro de paginacion
        $search =  $request->getVar('search')['value']; //valor de busqueda global
        $search2 =  $request->getVar('columns')[0]['search']['value']; //valor de la busqueda para aplicar a esa columna especifica

        $map_table = [
            0 => "paciente",
            1 => "email",
            2 => 'telefono',
            3 => 'total_muestras',
            4 => 'total_consultas',
            5 => 'id_user'
        ];

        $query_result =  "SELECT * FROM (
            SELECT DISTINCT users.id AS id_user, 
            users.user_name AS paciente, 
            users.email, 
            (SELECT PHONE_NUMBER FROM hcv_identity WHERE hcv_identity.ID_USER = users.id LIMIT 1) AS telefono, 
            (SELECT COUNT(*) FROM citas WHERE citas.id_user = users.id AND citas.status_lab IN ('102', '103', '104', '105', '107', '108', '109', '110')) AS total_muestras, 
            (SELECT COUNT(*) FROM citas WHERE citas.id_user = users.id AND citas.status_lab >= 200) AS total_consultas 
            FROM users 
            JOIN citas ON users.id = citas.id_user 
            WHERE 1=1
        ) AS subquery ";

        $condicion = "";

        $column0 =  $request->getVar('columns')[0]['search']['value'];
        $column1 =  $request->getVar('columns')[1]['search']['value'];
        $column2 =  $request->getVar('columns')[2]['search']['value'];
        $column3 =  $request->getVar('columns')[3]['search']['value'];
        $column4 =  $request->getVar('columns')[4]['search']['value'];
        $column5 =  $request->getVar('columns')[5]['search']['value'];

        $columns = [$column0, $column1, $column2, $column3, $column4,$column5];


        //Buscador por columnas
        $first = true;
        foreach ($map_table as $key => $val) {
            if (isset($columns[$key])) {
                if ($first) {
                    $query_result .= " WHERE " . $val . " LIKE '%" . $columns[$key] . "%'";
                    $first = false;
                } else {
                    $query_result .= " AND " . $val . " LIKE '%" . $columns[$key] . "%'";
                }
            }
        }
        

       

        //Buscador general 
        if (!empty($search)) {
            foreach ($map_table as $key => $val) {
                if ($key == 0) {
                    $condicion .= " HAVING " . $val . " LIKE '%" . $search . "%'";
                } else { //OR name LIKE valor
                    /* if($map_table[$key] ==='fecha_alta' || 'fecha_actualizacion'){
                       $fecha = $request->getVar('columns')[$key]['search']['value'];
                       if(preg_match("/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/", $fecha)) {
                           $date = str_replace('/', '-', $fecha);
                           $fecha2 = date("Y-m-d", strtotime($date));
                           $condicion .= " OR " .$val. " LIKE '%".$fecha2."%'";
                          
                        }else{
                           $condicion .= " OR " .$val. " LIKE '%".$fecha."%'";
                        }
                   }else{
                       $condicion .= " OR " .$val. " LIKE '%".$request->getVar('columns')[$key]['search']['value']."%'";

                   } */
                    $condicion .= " OR " . $val . " LIKE '%" . $search . "%'";
                }
            }
        }

        $sql_data = $query_result . $condicion;
        $sql_count = $model_citas->reportePacientes($sql_data);
        $sql_count = count($sql_count);
        $sql_data .=   " ORDER BY " . $map_table[$request->getVar('order')[0]['column']] . "
                        " . $request->getVar('order')[0]['dir'] . "" . " LIMIT " . $start . "," . $length . "";
        $data = $model_citas->reportePacientes($sql_data);

        $response = [
            "draw" => $draw,
            "recordsTotal" => $sql_count,
            "recordsFiltered" => $sql_count,
            "data" => $data,
            'sql_script' => $column3
        ];

        return $this->respondCreated($response);
    }

    public function productosPaciente()
    {
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $id_user = $_POST['id_usuario'];
        $data['data'] = $model_citas->productosPaciente($id_user);
        return $this->respond($data);
    }
}
