<?php

/* Desarrollador: Airam Vargas
Fecha de creacion:
Fecha de Ultima Actualizacion: 22 - 08 -2023 por Airam Vargas
Perfil: Administrador
Descripcion: Se agrego tipo de muestra, contenedor y volumen en las datos del estudio */

namespace App\Controllers\Api\Catalogos;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');

use App\Models\Catalogos\Cat_studies as model;

class Estudios extends ResourceController
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

    //CREAR UNA CATEGORIA DE ESTUDIO
    public function create()
    {
        $request = \Config\Services::request();
        $model_insumo = model('App\Models\Catalogos\Insumos');

        if ($request->getPost('costo_proceso') != "") {
            $costo_proceso = $request->getPost('costo_proceso');
        } else {
            $costo_proceso = "";
        }

        $data = [
            'id_category_lab' => $request->getPost('id_category'),
            'preparation' => $request->getPost('description'),
            'id_container' => $request->getPost('id_container'),
            'id_muestra' => $request->getPost('id_type_sample'),
            'sample_volume' => $request->getPost('volumen'),
            'n_labels' => $request->getPost('n_labels'),
            'dias_entrega' => $request->getPost('dias_entrega'),
            'dias_proceso' => $request->getPost('dias_proceso'),
            'tiempo_entrega' => $request->getPost('tiempo_entrega'),
            'costo_proceso' => $costo_proceso
        ];

        $id_product = $this->model->insert($data);

        $data_insumo = [
            'name' => $request->getPost('name'),
            'name_table' => 'cat_studies',
            'id_product' => $id_product,
            'id_category' => $request->getPost('categoria'),
            'cita' => $request->getPost('cita'),
            'duration' => $request->getPost('duracion')
        ];

        $id = $model_insumo->insert($data_insumo);

        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);
    }

    //FUNCION PARA DATATABLE
    public function readStudies()
    {
        $request = \Config\Services::request();
        $pager = \Config\Services::pager();
        $draw = $request->getVar('draw'); //dibuja contador 
        $length = $request->getVar('length'); //numero de registros que la tablla puede mostrar 
        $start = $request->getVar('start'); //Primer registro de paginacion
        $search =  $request->getVar('search')['value']; //valor de busqueda global
        $search2 =  $request->getVar('columns')[0]['search']['value']; //valor de la busqueda para aplicar a esa columna especifica

        $map_table = [
            0 => "insumos.name",
            1 => "category_lab.name",
            2 => "insumos.duration",
            3 => 'sample_types.name',
            4 => 'containers.name',
            5 => 'cat_studies.sample_volume',
            6 => 'cat_studies.preparation',
            7 => 'cat_studies.tiempo_entrega',
            8 => 'cat_studies.dias_proceso',
            9 => 'cat_studies.tiempo_entrega'
        ];

        $query_result =  " SELECT 
    insumos.id AS id, 
    cat_studies.id AS id_product, 
    cat_studies.preparation, 
    sample_types.name AS muestra, 
    containers.name AS contenedor, 
    cat_studies.sample_volume AS volumen, 
    cat_studies.n_labels, 
    insumos.name AS study, 
    category_lab.name AS category, 
    insumos.cita AS cita, 
    insumos.duration AS duration, 
    cat_studies.dias_entrega, 
    cat_studies.dias_proceso, 
    cat_studies.tiempo_entrega, 
    cat_studies.costo_proceso 
FROM 
    cat_studies 
JOIN 
    insumos ON cat_studies.id = insumos.id_product AND insumos.name_table LIKE '%cat_studies%'
JOIN 
    sample_types ON cat_studies.id_muestra = sample_types.id
JOIN 
    containers ON cat_studies.id_container = containers.id
JOIN 
    category_lab ON cat_studies.id_category_lab = category_lab.id
WHERE 
    cat_studies.deleted_at = '0000-00-00 00:00:00'";

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

        $columns = [$column0, $column1, $column2, $column3, $column4, $column5, $column6, $column7, $column8, $column9];

        //Buscador por columnas
        foreach ($map_table as $key => $val) {
            if (!empty($columns[$key])) {
                $condicion .= " AND " . $val . " LIKE '%" . $columns[$key] . "%'";
            }
        }


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
        $sql_count = $this->model->readStudies($sql_data);
        $sql_count = count($sql_count);
        $sql_data .=  " ORDER BY " . $map_table[$request->getVar('order')[0]['column']] . "
            " . $request->getVar('order')[0]['dir'] . "" . " LIMIT " . $start . "," . $length . "";
        $data = $this->model->readStudies($sql_data);

        $response = [
            "draw" => $draw,
            "recordsTotal" => $sql_count,
            "recordsFiltered" => $sql_count,
            "data" => $data,
            "sql_data" => $sql_data
        ];

        return $this->respondCreated($response);
    }

    //OBTENER DATOS PARA ACTUALIZAR
    public function readStudy()
    {
        $id = $_POST['id'];
        $data = $this->model->readStudy($id);
        return $this->respond($data);
    }

    //EDITAR REGISTRO 
    public function update_()
    {
        $request = \Config\Services::request();
        $model_insumo = model('App\Models\Catalogos\Insumos');

        $id_product = $request->getPost('id');
        $id_insumo = $request->getPost('id_insumo');

        if ($request->getPost('costo_proceso') != "") {
            $costo_proceso = $request->getPost('costo_proceso');
        } else {
            $costo_proceso = "";
        }

        $data_insumo = [
            'name' => $request->getPost('name'),
            'id_category' => $request->getPost('categoria'),
            'cita' => $request->getPost('cita'),
            'duration' => $request->getPost('duracion')
        ];

        $id = $model_insumo->update($id_insumo, $data_insumo);

        $data = [
            'id_category_lab' => $request->getPost('id_category'),
            'preparation' => $request->getPost('description'),
            'id_container' => $request->getPost('id_container'),
            'id_muestra' => $request->getPost('id_type_sample'),
            'sample_volume' => $request->getPost('volumen'),
            'n_labels' => $request->getPost('n_labels'),
            'dias_entrega' => $request->getPost('dias_entrega'),
            'dias_proceso' => $request->getPost('dias_proceso'),
            'tiempo_entrega' => $request->getPost('tiempo_entrega'),
            'costo_proceso' => $costo_proceso
        ];

        $this->model->update($id_product, $data);

        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje;
    }

    //ELIMINAR REGISTRO
    public function delete_()
    {
        $request = \Config\Services::request();
        $model_insumo = model('App\Models\Catalogos\Insumos');

        $model_insumo->delete($request->getPost('id_insumo'));
        $this->model->delete($request->getPost('id'));

        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje;
    }

    //MOSTRAR EXAMENES X ESTUDIO
    public function show($id = NULL)
    {
        $model = model('App\Models\Catalogos\Exams_x_study');
        $id = $_POST['id_study'];
        $data['data'] = $model->show($id);
        return $this->respond($data);
    }

    //INSERTAR EXAMEN
    public function insert_exam()
    {
        $model = model('App\Models\Catalogos\Exams_x_study');
        $request = \Config\Services::request();

        $id_study = $request->getPost('id_study');
        $id_exam = $request->getPost('id_exam');

        $repetido = $model->repetidos($id_study, $id_exam);

        if ($repetido[0]->repetido == 0) {
            $data = [
                'id_study' => $request->getPost('id_study'),
                'id_exam' => $request->getPost('id_exam')
            ];

            $id = $model->insert($data);
            $mensaje = messages($insert = 0, $id);
        } else {
            $mensaje = [
                'status' => 400,
                'msg' => "EL EXAMEN YA ESTA ASIGNADO A ESTE ESTUDIO"
            ];
        }


        return $this->respond($mensaje);
    }

    //ELIMINAR EXAMEN
    public function delete_exam()
    {
        $model = model('App\Models\Catalogos\Exams_x_study');
        $request = \Config\Services::request();
        $id = $request->getVar("id_delete");
        $model->delete($id);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje;
    }
}
