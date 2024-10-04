<?php

/* Desarrollador: Airam Vargas
Fecha de creacion:
Fecha de Ultima Actualizacion: 24 - 08 -2023 por Airam Vargas
Perfil: Recepcionista
Descripcion: Se cambio  */

namespace App\Controllers\Api\HCV\Operativo;
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
        $session = session();
        $usuarios = model('App\Models\Administrador\Usuarios');
        $user_id = $session->get('unique');
        $grupo = $usuarios->select('id_group')->where('id', $user_id)->find();

        if($grupo[0]['id_group'] == 8){
            $data['data'] = $this->model->readAppointment($user_id);
        } else {
            $data['data'] = $this->model->readAppointmentMuestras();
        }
       
        return $this->respond($data);
    }
    
    //ACEPTAR CITA
    public function acceptAppointment(){
        $request = \Config\Services::request();
        $id_cot_x_prod = $request->getPost('id_cot_x_prod');
        $status_lab = 201;
        $model_status = model('App\Models\Catalogos\Laboratorio\Status_lab');
        $name_status = $model_status->select('name')->where('id', $status_lab)->find();
        
        $data = [
            'approved' => 1
        ];
        $this->model->update($request->getPost('id'), $data);

        $data_status = [
            'status_lab' => $status_lab,
            'status_name' => $name_status[0]['name']
        ];

        $this->cotization_x_product->update($id_cot_x_prod, $data_status);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $this->respond($mensaje);
    }
    
    //RECHAZAR CITA
    public function rejectAppointment(){
        $session = session();
        $user_id = $session->get('unique');
        $request = \Config\Services::request();
        $id_cot_x_prod = $request->getPost('id_cot_x_prod');
        $status_lab = 202;
        $model_status = model('App\Models\Catalogos\Laboratorio\Status_lab');
        $model_notificaciones = model('App\Models\Generales\Notificaciones');
        $model_cotization = model('App\Models\Model_cotizacion/Cotizacion');
        $data_product = $this->cotization_x_product->find($id_cot_x_prod);
        $id_recepcion = $model_cotization->find($data_product['id_cotization'])['id_user_vendor'];
        $name_status = $model_status->select('name')->where('id', $status_lab)->find();
        
        $data = [
            'approved' => 2
        ];
        $this->model->update($request->getPost('id'), $data);

        $data_status = [
            'status_lab' => $status_lab,
            'status_name' => $name_status[0]['name']
        ];

        $this->cotization_x_product->update($id_cot_x_prod, $data_status);
        $affected_rows = $this->db->affectedRows(); 
        $affected_rows = 1;
        if($affected_rows > 0){
            $notificacion = [
                'id_type' => 2,
                'state' => 0,
                'id_user_emisor' => $user_id,
                'id_user_receptor' => $id_recepcion,
                'date' => date("Y-m-d H:i:s"),
                'sub_mensaje' => "numero de cotizacion ".$data_product['id_cotization'],
                'url' => "OrdenServicio/Pendientes"
            ];

            $id = $model_notificaciones->insert($notificacion);
            if($id){
                $mensaje = messages($update = 1, $affected_rows);
                return $this->respond($mensaje); 
            }

        }
    }

    //FUNCION PARA DATATABLE CITAS ACEPTADAS
    public function readAppointmentAccept(){
        $session = session();
        $usuarios = model('App\Models\Administrador\Usuarios');
        $user_id = $session->get('unique');
        $grupo = $usuarios->select('id_group')->where('id', $user_id)->find();

        if($grupo[0]['id_group'] == 8){
            $data['data'] = $this->model->readAppointmentAccept($user_id);
        }
        return $this->respond($data);
    }
}