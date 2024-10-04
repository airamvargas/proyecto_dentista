<?php 

/* Desarrollador: Airam Vargas
Fecha de creacion:
Fecha de Ultima Actualizacion: 08 - 09 -2023 por Airam Vargas
Perfil: Administrador
Descripcion: Cátalogo de tipos de analitos */

namespace App\Controllers\Api\Catalogos;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Catalogos\Cat_exams as model;

class Exams extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;
    var $ranges_x_exam;

    public function __construct() { //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        $this->ranges_x_exam = new \App\Models\Catalogos\Laboratorio\Cat_ranges_exam();
        helper('messages');
    }
    
    //CREAR UN EXAMEN
    public function create() { 
        $request = \Config\Services::request();

        $data = [
            'name' => $request->getPost('name'),
            'description' => $request->getPost('description'),
            'id_crm_cat_methods' => $request->getPost('id_crm_cat_methods'),
            'id_crm_cat_measurement_units' => $request->getPost('id_crm_cat_measurement_units'),
            'reference_value' => $request->getPost('reference_value'),
            'result' => $request->getPost('result'),
            'id_agrupador' => $request->getPost('id_agrupador')
        ];

        $id = $this->model->insert($data);

        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje); 
    }

    //FUNCION PARA DATATABLE
    public function readExams(){
        $request = \Config\Services::request();
        $pager = \Config\Services::pager();
        $draw = $request->getVar('draw');//dibuja contador 
        $length = $request->getVar('length');//numero de registros que la tablla puede mostrar 
        $start = $request->getVar('start');//Primer registro de paginacion
        $search =  $request->getVar('search')['value'];//valor de busqueda global
        //$search2 =  $request->getVar('columns')[0]['search']['value'];//valor de la busqueda para aplicar a esa columna especifica

        $map_table =[
            0 => "id",
            1 => "name",
            2 => "metodo",
            3 => 'unidad',
            4 => 'referencia',
            5 => 'resultado',
            6 => 'agrupador'    
        ];
       
        $query_result =  "SELECT id, name, description, reference_value AS referencia, result AS resultado, (SELECT name FROM crm_cat_methods WHERE crm_cat_methods.id = id_crm_cat_methods AND 
        crm_cat_methods.deleted_at = '0000-00-00 00:00:00') AS metodo, (SELECT CONCAT(min, ' - ', max) FROM crm_cat_age_range WHERE crm_cat_age_range.id
        = id_crm_cat_age_range AND crm_cat_age_range.deleted_at = '0000-00-00 00:00:00') AS rango, (SELECT prefix FROM crm_cat_measurement_units WHERE 
        crm_cat_measurement_units.id = id_crm_cat_measurement_units AND crm_cat_measurement_units.deleted_at = '0000-00-00 00:00:00') AS unidad, (SELECT 
        name FROM crm_grouper WHERE id_agrupador = crm_grouper.id) AS agrupador FROM cat_exams WHERE cat_exams.deleted_at = '0000-00-00 00:00:00'";

        $condicion = "";

        $column0 =  $request->getVar('columns')[0]['search']['value'];
        $column1 =  $request->getVar('columns')[1]['search']['value'];
        $column2 =  $request->getVar('columns')[2]['search']['value'];
        $column3 =  $request->getVar('columns')[3]['search']['value'];
        $column4 =  $request->getVar('columns')[4]['search']['value'];
        $column5 =  $request->getVar('columns')[5]['search']['value'];
        $column6 =  $request->getVar('columns')[6]['search']['value'];


       //Buscador general 
        if(!empty($search)){
            foreach ($map_table as $key => $val){
                if($key == 0){
                   $condicion .= " HAVING ".$val." LIKE '%".$search."%'";
                } else {//OR name LIKE valor
                   $condicion .= " OR " .$val. " LIKE '%".$search."%'";
                }
           }
        } 

       $sql_data = $query_result.$condicion;
       $sql_count = $this->model->readExams($sql_data);
       $sql_count = count($sql_count);
       $sql_data .=   " ORDER BY " .$map_table[$request->getVar('order')[0]['column']]."
                       ".$request->getVar('order')[0]['dir']."" . " LIMIT ".$start. "," .$length.""; 
       $data = $this->model->readExams($sql_data);

       $response = [
           "draw" => $draw,
           "recordsTotal" => $sql_count ,
           "recordsFiltered" => $sql_count,
           "data" =>$data,
       ];   
       return $this->respond($response);
    }

    //OBTENER DATOS PARA ACTUALIZAR
    public function readExam(){ 
        $id = $_POST['id'];
        $data = $this->model->readExam($id);
        return $this->respond($data);
    }

    //EDITAR REGISTRO 
    public function update_(){ 
        $request = \Config\Services::request();

        $data = [
            'name' => $request->getPost('name'),
            'description' => $request->getPost('description'),
            'id_crm_cat_methods' => $request->getPost('id_crm_cat_methods'),
            'id_crm_cat_measurement_units' => $request->getPost('id_crm_cat_measurement_units'),
            'reference_value' => $request->getPost('reference_value'),
            'result' => $request->getPost('result'),
            'id_agrupador' => $request->getPost('id_agrupador')
        ];

        //var_dump($request->getPost('id'));

        $this->model->update($request->getPost('id'), $data);

        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje; 
    }

    //ELIMINAR REGISTRO
    public function delete_(){ 
        $request = \Config\Services::request();

        $this->model->delete($request->getPost('id'));

        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje;
    }

    //Obtener listado de géneros
    public function getGenders(){
        $model_gender = model('App\Models\Administrador\Cat_gender');
        $data = $model_gender->select('*')->findAll();
        return $this->respond($data);
    }

    public function showRanges(){
        $request = \Config\Services::request();
        $id_exam = $request->getPost('id_exam');
        $data['data'] = $this->ranges_x_exam->show($id_exam);
        return $this->respond($data);
    }

    public function createRange(){
        $request = \Config\Services::request();
        /*$data = [
            'id_exam' => $request->getPost('id_exam'),
            'id_gender' => $request->getPost('id_gender'),
            'id_age_range' => $request->getPost('id_age_range'),
            //'edad_minima' => $request->getPost('edad_minima'),
            //'edad_maxima' => $request->getPost('edad_maxima'),
            'operator'=> $request->getPost('operator'),
            'min' => $request->getPost('min'),
            'max' => $request->getPost('max'),
        ];

        $id = $this->ranges_x_exam->insert($data);
        if ($id) {
            $data = [
                "status" => 200,
                "msg" => "AGREGADO CON EXITO"
            ];
            return $this->respond($data);
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return  $this->respond($data);
        } */
        $val_minima = $this->ranges_x_exam->val_minima($request->getPost('edad_minima'), $request->getPost('id_gender'), $request->getPost('id_exam'));
        $val_maxima = $this->ranges_x_exam->val_maxima($request->getPost('edad_maxima'), $request->getPost('id_gender'), $request->getPost('id_exam'));
        //var_dump($val_maxima);

        if($val_minima[0]->val_min > 0 || $val_maxima[0]->val_max > 0){
            $data = [
                "status" => 400,
                "msg" => "LA EDAD MINIMA O LA EDAD MAXIMA YA SE 
                ENCUENTRAN DENTRO DE OTRO RANGO, VERIFICAR DATOS"
            ];
            return  $this->respond($data);
        } else {
            $data = [
                'id_exam' => $request->getPost('id_exam'),
                'id_gender' => $request->getPost('id_gender'),
                'id_age_range' => 0,
                'edad_minima' => $request->getPost('edad_minima'),
                'edad_maxima' => $request->getPost('edad_maxima'),
                'operator'=> $request->getPost('operator'),
                'min' => $request->getPost('min'),
                'max' => $request->getPost('max'),
            ];
    
            $id = $this->ranges_x_exam->insert($data);
            if ($id) {
                $data = [
                    "status" => 200,
                    "msg" => "AGREGADO CON EXITO"
                ];
                return $this->respond($data);
            } else {
                $data = [
                    "status" => 400,
                    "msg" => "ERROR EN EL SERVIDOR"
                ];
                return  $this->respond($data);
            } 
        }
    }

    public function getValues(){
        $uri = service('uri');
        $id = $uri->getSegment(5);
        $data = $this->ranges_x_exam->getValues($id);
        return  $this->respond($data);
    }

    public function updateRange(){
        $request = \Config\Services::request();

        /*$data = [
            'id_gender' => $request->getPost('id_gender'),
            'id_age_range' => $request->getPost('id_gender'),
            //'edad_minima' => $request->getPost('edad_minima'),
            //'edad_maxima' => $request->getPost('edad_maxima'),
            'operator'=> $request->getPost('operator'),
            'min' => $request->getPost('min'),
            'max' => $request->getPost('max'),
        ];
        $this->ranges_x_exam->update($request->getPost('id'), $data);

        $affected_rows = $this->db->affectedRows();
        if ($affected_rows) {
            $data = [
                "status" => 200,
                "msg" => "AGREGADO CON EXITO"
            ];
            return $this->respond($data);
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return  $this->respond($data);
        }*/

        if($request->getPost('edad_minima') == 0){
            $val_minima = 0;
        } else {
            $newMin = $this->ranges_x_exam->val_minima($request->getPost('edad_minima'), $request->getPost('id_gender'), $request->getPost('id_exam'));
            $val_minima = $newMin[0]->val_min;
        }
        //$val_minima = $this->ranges_x_exam->val_minima($request->getPost('edad_minima'), $request->getPost('id_gender'), $request->getPost('id_exam'));
        $val_maxima = $this->ranges_x_exam->val_maxima($request->getPost('edad_maxima'), $request->getPost('id_gender'), $request->getPost('id_exam'));
        //var_dump("val min ".$val_minima[0]->val_min." val max ".$val_maxima[0]->val_max);
        //var_dump($request->getPost('id_gender'));

        if($val_minima > 0 || $val_maxima[0]->val_max > 0){
            $data = [
                "status" => 400,
                "msg" => "LA EDAD MINIMA O LA EDAD MAXIMA YA SE 
                ENCUENTRAN DENTRO DE OTRO RANGO, VERIFICAR DATOS"
            ];
            return  $this->respond($data);
        } else {
            $data = [
                'id_gender' => $request->getPost('id_gender'),
                'id_age_range' => 0,
                'edad_minima' => $request->getPost('edad_minima'),
                'edad_maxima' => $request->getPost('edad_maxima'),
                'operator'=> $request->getPost('operator'),
                'min' => $request->getPost('min'),
                'max' => $request->getPost('max'),
            ];
            $this->ranges_x_exam->update($request->getPost('id'), $data);

            $affected_rows = $this->db->affectedRows();
            if ($affected_rows) {
                $data = [
                    "status" => 200,
                    "msg" => "AGREGADO CON EXITO"
                ];
                return $this->respond($data);
            } else {
                $data = [
                    "status" => 400,
                    "msg" => "ERROR EN EL SERVIDOR"
                ];
                return  $this->respond($data);
            }
        }
    }

    public function deleteRange(){
        $request = \Config\Services::request();
        $id = $request->getPost('id');

        $this->ranges_x_exam->delete($id);
        $affected_rows = $this->db->affectedRows();
        if ($affected_rows > 0) {
            $data = [
                "status" => 200,
                "msg" => "ELIMINADO CON EXITO"
            ];
            return $this->respond($data);
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return $this->respond($data);
        }
    }
}