<?php 

/* Desarrollador: Airam Vargas
Fecha de creacion:
Fecha de Ultima Actualizacion: 24 - 08 -2023 por Airam Vargas
Perfil: Recepcionista
Descripcion: Se va a corregir citas médicas pendientes para que la recepción las libere hasta que el día de la cita, 
si el médico la cancela el recepcionista podrá reagendar otra cita */

namespace App\Controllers\Api\OrdenServicio;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Model_cotization_product\cotization_product as model;
use App\Models\Administrador\Identity_employed as identity; 


class Pendientes extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;
    var $identity;

    public function __construct() {
        //Assign global variables
        $this->db = db_connect();
        $this->model = new model();
        $this->identity = new identity();
        helper('messages');
    }
    
    //FUNCION PARA DATATABLE
    public function show($id = NULL){ 
        $session = session();
        $user_id = $session->get('unique');
        $model_user = model('App\Models\Administrador\Usuarios');
        $group = $model_user->select('id_group')->where('id', $user_id)->find();

        if($group[0]['id_group'] == 6){
            $data['data'] = $this->model->showPendientesCall();
        } else {
            $id_cat_bussienes = $this->identity->select('id_cat_business_unit')->where('id_user', $user_id)->find();
            $data['data'] = $this->model->showPendientes($id_cat_bussienes[0]['id_cat_business_unit']);
        }
        
        return $this->respond($data); 
    }

    public function showLab(){
        $id = $_POST['id'];
        $data = $this->model->showLab($id);
        return $this->respond($data);
    }

    public function showCitas(){
        $id = $_POST['id'];
        $data = $this->model->showCitas($id);
        return $this->respond($data);
    }

    public function status_lab(){
        $session = session();
        $user_id = $session->get('unique');
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $model_notificaciones = model('App\Models\Generales\Notificaciones');
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $id_medico = $model_citas->select('id_doctor')->where('id_cotization_x_product',$id)->find();
        $status_lab = $request->getPost('status_lab');
        $model_status = model('App\Models\Catalogos\Laboratorio\Status_lab');
        $name_status = $model_status->select('name')->where('id', $status_lab)->find();

        $data = [
           'status_lab' => $status_lab, 
           'status_name' => $name_status[0]['name']
        ];

       $this->model->update($id, $data);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        if($affected_rows){
            if($status_lab == 101){
                $data = [
                    "status" => 200,
                    "msg" => "TOMAR MUESTRA"
                ];
            }else {
                $data = [
                    "status" => 200,
                    "msg" => "CONSULTA AUTORIZADA"
                ];
            }  


            $notificacion = [
                'id_type' => 3,
                'state' => 0,
                'id_user_emisor' => $user_id,
                'id_user_receptor' => $id_medico[0]['id_doctor'],
                'date' => date("Y-m-d H:i:s"),
                'sub_mensaje' => "con el folio",
                'url' => "HCV/Operativo/Citas"
            ];

            $id = $model_notificaciones->insert($notificacion);
            if($id){
                return $this->respond($data);
            }

        } else {
            $data = [
                "status" => 400,
                "msg" => "HUBO UN ERROR, INTENTE DE NUEVO"
            ];
        }
        return $this->respond($data);
    }
}