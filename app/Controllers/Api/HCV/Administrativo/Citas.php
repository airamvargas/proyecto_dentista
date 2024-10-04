<?php
/* Desarrollador: Jesús Esteban Sánchez Alcántara
Fecha de creacion: 29-agosto-2023
Fecha de Ultima Actualizacion: 7-septiembre-2023  
Perfil: Administracion
Descripcion: Desde la parte administrativa se podrán visualizar todas las citas con su status en el que se encuentra cada cita para paciente y medico. La tabla se convirtio a server side*/

namespace App\Controllers\Api\HCV\Administrativo;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Agendas\Appointment_schedule as model;

class Citas extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;
    var $cotization_x_product;

    public function __construct() { //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        $this->cotization_x_product = new \App\Models\Model_cotization_product\cotization_product();
        helper('messages');
    }

    //FUNCION PARA DATATABLE CITAS PENDIENTES
    public function readAppointment(){
        $request = \Config\Services::request();
        $model_citas = model('App\Models\Agendas\Appointment_schedule');

        // Server side
      $pager = \Config\Services::pager();
        $draw = $request->getVar('draw');//dibuja contador 
        $length = $request->getVar('length');//numero de registros que la tabla puede mostrar 
        $start = $request->getVar('start');//Primer registro de paginacion
        $search =  $request->getVar('search')['value'];//valor de busqueda global      
        
        $map_table =[
            0 => "id_cita",
            1 => "id_cotizacion",
            2 => "fecha",
            3 => 'hora',
            4 => 'status_name',
            5 => 'paciente',
            6 => 'consultorio',       
            7 => 'tipo_consulta',       
            8 => 'doctor'      
        ];        
        
        // Consulta para traer todas las citas medicos-pacientes para el administrador
        $query_result = "SELECT appointment_schedule.id, fecha, hora, id_user_client AS id_paciente, id_cotizacion, id_doctor, id_cita, approved,
        (SELECT hcv_specialtytype.id FROM hcv_specialtytype JOIN hcv_identity_operativo ON hcv_specialtytype.id = hcv_identity_operativo.disciplina_id WHERE hcv_identity_operativo.user_id = id_doctor) as id_consulta,
        (SELECT hcv_specialtytype.name FROM hcv_specialtytype JOIN hcv_identity_operativo ON 
        hcv_specialtytype.id = hcv_identity_operativo.disciplina_id WHERE hcv_identity_operativo.user_id = id_doctor) AS tipo_consulta, 
        (SELECT status_lab FROM cotization_x_products WHERE cotization_x_products.id_cat_products = appointment_schedule.id_insumo AND appointment_schedule.id_cotizacion = cotization_x_products.id_cotization  AND cotization_x_products.deleted_at = '0000-00-00 00:00:00') AS status_lab,
        (SELECT status_name FROM cotization_x_products WHERE cotization_x_products.id_cat_products = appointment_schedule.id_insumo AND 
        appointment_schedule.id_cotizacion = cotization_x_products.id_cotization  AND cotization_x_products.deleted_at = '0000-00-00 00:00:00') AS status_name,
        (SELECT name FROM consulting_room WHERE consulting_room.id = id_consultorio) AS consultorio, 
        (SELECT hcv_identity.ID from hcv_identity JOIN users ON users.id=hcv_identity.ID_USER WHERE users.id = cotization.id_user_client) as id_identity,
        (SELECT user_name FROM users WHERE users.id = cotization.id_user_client) AS paciente,
        (SELECT hcv_identity_operativo.ID from hcv_identity_operativo JOIN users ON users.id=hcv_identity_operativo.user_id WHERE users.id = appointment_schedule.id_doctor) as id_operativo,
        (SELECT user_name FROM users WHERE users.id = appointment_schedule.id_doctor) AS doctor 
        FROM appointment_schedule 
        JOIN cotization ON cotization.id = appointment_schedule.id_cotizacion 
        WHERE  show_cotization = 1 AND cotization.deleted_at = '0000-00-00 00:00:00' AND
        appointment_schedule.deleted_at = '0000-00-00 00:00:00' and id_doctor != 0 HAVING status_lab >= 200 ";

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
        
       //Buscador general 
        if(!empty($search)){
            foreach ($map_table as $key => $val){     
                if($key == 0){
                    $condicion .= " AND ".$val." LIKE '%".$search."%'";
                } else {
                    $condicion .= " OR " .$val. " LIKE '%".$search."%' ";                 
                }                  
            }
        }     

       $sql_data = $query_result.$condicion;
       $sql_count = $model_citas->getBusqueda($sql_data);
       $sql_count = count($sql_count);
       $sql_data .=   " ORDER BY " .$map_table[$request->getVar('order')[0]['column']]."
                       ".$request->getVar('order')[0]['dir']."" . " LIMIT ".$start. "," .$length.""; 
       $data = $model_citas->getBusqueda($sql_data);

       $response = [
           "draw" => $draw,
           "recordsTotal" => $sql_count ,
           "recordsFiltered" => $sql_count,
           "data" =>$data,
           "sqlScr" => $sql_data
       ];  
       return $this->respondCreated($response);   

        
    }

}