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
use App\Models\Model_cotization_product\cotization_product as model;
use App\Models\Administrador\Identity_employed as identity; 


class Citas_rechazadas extends ResourceController 
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
    public function show($id = NULL){ 
        $session = session();
        $user_id = $session->get('unique');
        $model_user = model('App\Models\Administrador\Usuarios');
        $group = $model_user->select('id_group')->where('id', $user_id)->find();

        if($group[0]['id_group'] == 6){
            $data['data'] = $this->model->showRechazadasCall();
        } else {
            $id_cat_bussienes = $this->identity->select('id_cat_business_unit')->where('id_user', $user_id)->find();
            $data['data'] = $this->model->showRechazadas($id_cat_bussienes[0]['id_cat_business_unit']);
        }
        
        return $this->respond($data); 
    }

    public function updateAgenda() {
        //actaulizamos las citas que requieren cita y agregamos a cita de agendas
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $agenda_citas = model('App\Models\Agendas\Appointment_schedule');
        $agenda_medico = model('App\Models\Agendas\Doctor_schedule');
        $agenda_consultorio = model('App\Models\Agendas\Office_schedule');
        $id_cita = $_POST['id_cita'];
        $id_agenda = $agenda_citas->select('id')->where('id_cita', $id_cita)->first()['id'];
        $id_agenda_doc = $agenda_medico->select('id')->where('id_cita', $id_agenda)->first()['id'];
        $id_agenda_consul = $agenda_consultorio->select('id')->where('id_cita', $id_agenda)->first()['id'];
        $id_insumo = $model_citas->getStudy($id_cita);
        $id_cotizacion_x_prod = $model_citas->select('id_cotization_x_product')->where('id', $id_cita)->first()['id_cotization_x_product'];
        var_dump($id_cotizacion_x_prod);
        //datos a actualizar de la cita
        $data_cita = [
            'fecha' => $_POST['fecha'],
            'hora' => $_POST['horario'],
            'id_doctor' => $_POST['medico'],
            'id_consultorio' => $_POST['consultorio']
        ];
        $model_citas->update($id_cita, $data_cita);
        $affected_rows = $this->db->affectedRows();

        //si de actualiza la cita procedemos a agregar en la agenda
        if ($affected_rows > 0) {
            $data = [
                'fecha' => $_POST['fecha'],
                'hora' => $_POST['horario'],
                'approved' => 0,
                'id_doctor' => $_POST['medico'],
                'id_consultorio' => $_POST['consultorio']
            ];
            //actualizacion de agenda de citas
            $agenda_citas->update($id_agenda, $data);
            $affected_rows = $this->db->affectedRows();

            if ($affected_rows > 0) {
                //insertamos en la agenda del medico
                $data_medico = [
                    'id_doctor' => $_POST['medico'],
                    'date_appointment' =>  $_POST['fecha'],
                    'time_appointment' => $_POST['horario'],
                ];
                $agenda_medico->update($id_agenda_doc, $data_medico);
                // insertamos en la agenda de consultorios
                $data_consultorio = [
                    'id_consulting ' => $_POST['consultorio'],
                    'date_appointment' =>  $_POST['fecha'],
                    'time_appointment' => $_POST['horario'],
                ];
                $agenda_consultorio->update($id_agenda_consul, $data_consultorio);
                //Cambiamos el status en la tabla de cotizacion x producto
                $data_status = [
                    'status_lab' => 200,
                    'status_name' => 'Consulta pendiente'
                ];
                $this->model->update($id_cotizacion_x_prod, $data_status);
                $affected_rows = $this->db->affectedRows();
                $mensaje = messages($update = 1, $affected_rows);
                return $this->respond($mensaje);
            }
        }
    }

}