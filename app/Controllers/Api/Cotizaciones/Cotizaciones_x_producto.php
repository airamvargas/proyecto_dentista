<?php

namespace App\Controllers\Api\Cotizaciones;

require_once __DIR__ . '../../../vendor/autoload.php';

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');
helper('sendmail');

use App\Models\Model_cotization_product\cotization_product as model;

class Cotizaciones_x_producto extends ResourceController {
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct() { //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }

    //OBTIENE TODOS LOS PRODUCTOS DE UNA SOLA COTIZACION 
    public function readCotizationxProducts() {
        $id = $_POST['id'];
        $data['data'] = $this->model->readCotizations($id);
        return $this->respond($data);
    }

    //CREAR LAS COTIZACIONES X PRODUCTO
    public function createCotzationProduct() {
        $session = session();
        $id_user = $session->get('unique');
        $model_cotization = model('App\Models\Model_cotizacion/Cotizacion');
        $model = model('App\Models\Catalogos\Insumos');
        $model_studies_x_packet = model('App\Models\Catalogos\Studies_x_packet');
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $model_identity = model('App\Models\Administrador\Identity_employed');
        $model_unidad = model('App\Models\Catalogos\BusinessUnit');
        $model_status = model('App\Models\Catalogos\Laboratorio\Status_lab');
        $request = \Config\Services::request();
        $id_insumo = $request->getPost('id_cat_products');
        $table = $model->select('name_table, id_product, id_category')->where('id', $id_insumo)->find();
        $unidad_input = $request->getPost('unidad');
        $arr = array("$", ",");
        $priceR = str_replace($arr, "", $request->getPost('precio'));
        $id_paciente = $model_cotization->select('id_user_client')->where('id', $request->getPost('id_cotization'))->find()[0]['id_user_client'];

        if ($request->getPost('unidad') == "null") {
            $unit = $model_identity->select('id_cat_business_unit')->where('id_user', $id_user)->find();
            $unidad = $unit[0]['id_cat_business_unit'];
            $data_up = [
                'id_conventions' => $request->getPost('id_conventions')
            ];
        } else {
            $unidad = $request->getPost('unidad');
            $name = $model_unidad->select('name')->where('id', $unidad)->find();
            $u_name = $name[0]['name'];
            $data_up = [
                'id_conventions' => $request->getPost('id_conventions'),
                'id_business_unit' => $unidad,
                'name_unit' => $u_name
            ];
        }
        $model_cotization->update($request->getPost('id_cotization'), $data_up);

        if($table[0]['id_category'] == 3){
            $status_lab = 200;
            
        }else {
            $status_lab = 100;
        }

        $name_satus = $model_status->select('name')->where('id', $status_lab)->find();
        $data = [
            'id_cat_products' => $request->getPost('id_cat_products'),
            'id_cotization' => $request->getPost('id_cotization'),
            'cantidad' => $request->getPost('cantidad'),
            'price' => $priceR,
            'status_lab' => $status_lab,
            'status_name' => $name_satus[0]['name']
        ];


        $id = $this->model->insert($data);

        if ($table[0]['name_table'] != "cat_packets") {
            $data_cita = [
                'id_cotization_x_product' => $id,
                'id_study' => $request->getPost('id_cat_products'),
                'id_user' => $id_paciente,
                'id_business_unit' => $unidad,
                'status_lab' => $status_lab,
                'status_name' => $name_satus[0]['name']
            ];
            
            $model_citas->insert($data_cita);
        } else {
            $studies = $model_studies_x_packet->studiesPacket($table[0]['id_product']);
            foreach ($studies as $key) {
                $data_cita = [
                    'id_cotization_x_product' => $id,
                    'id_study' => $key['id_insumo'],
                    'id_user' => $id_paciente,
                    'id_business_unit' => $unidad,
                    'status_lab' => $status_lab,
                    'status_name' => $name_satus[0]['name']
                ];
                $model_citas->insert($data_cita);
            }
        }
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);  
    }

    //ELIMINAR COTIZACION SOLO DE UN PRODUCTO
    public function delete_() {
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $request = \Config\Services::request();
        $id = $request->getVar("id_delete");
        $this->model->delete($id);
        $affected_rows = $this->db->affectedRows();
        $model_citas->builder()->delete(['id_cotization_x_product' => $id]);
        //retun affected rows into database
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje;
    }

    public function terminarCotizacion(){
        $model_cotization = model('App\Models\Model_cotizacion/Cotizacion');
        $request = \Config\Services::request();
        $id_cotizacion = $request->getVar("id");
        $datos = $this->model->selectCount('id_cotization')->where('id_cotization', $id_cotizacion)->where('deleted_at', null)->find();
        $count = $datos[0]['id_cotization'];

        if($count == 0){
            $model_cotization->delete($id_cotizacion);
            $affected_rows = $this->db->affectedRows();
            if($affected_rows){
                $data = [
                    "status" => 200
                ];
            } else {
                $data = [
                    "status" => 400
                ];
            }
           
        } else {
            $data = [
                "status" => 200
            ];
        }
        return $this->respond($data);
    }

    public function agenda() {   //datos de la tabla de agendar citas
        $model_cotization = model('App\Models\Model_cotizacion/Cotizacion');
        $id_cotizacion = $_POST['id'];
        $data['data'] = $model_cotization->getCitas($id_cotizacion);
        return $this->respond($data);
    }

    public function getConsultorio() {
        $model_cotization = model('App\Models\Model_cotizacion/Cotizacion');
        $model_medico = model('App\Models\HCV\Operativo\Ficha_Identificacion');
        $model_consultorio = model('App\Models\Catalogos\Laboratorio\Consulting_room');
        $model_isumos = $model_consultorio = model('App\Models\Catalogos\Insumos');
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $model_deciplina = model('App\Models\HCV\Operativo\Disciplina');
        $id_cita = $_POST['id'];
        $id_cotizacion = $_POST['id_cotizacion'];
        $category = $model_isumos->getCategory($id_cita);
        //unidad de negocio
        $unidad = $model_cotization->getUunit($id_cotizacion);
        $citas = $model_citas->getConsulta($id_cita);
        $diciplina = $citas[0]['id_discipline'];
        $data['medicos'] = $model_medico->get_operativos($unidad[0]['id_business_unit'], $diciplina);
        return $this->respond($data);
    }

    public function getHoras() {
        $model_medico = model('App\Models\HCV\Operativo\Ficha_Identificacion');
        $agenda_medico = model('App\Models\Agendas\Doctor_schedule');
        date_default_timezone_set("America/Guatemala");
        $hora_actual = date('H:i');
        $id_user = $_POST['id_user'];
        $horario = $model_medico->getHorario($id_user);
        $fecha = $_POST['fecha'];
        $fecha_actual =  date('Y-m-d');
        //horas por medico de base ocupadas
        $horas = $agenda_medico->getHours($fecha, $id_user);
        $horas_medico = array();
        $horas_obsoletas = array();
        //hora de jornada laboral medico inicio 
        $hora_medico_star = strtotime($horario[0]['entry_time']);
        //hora de jornada laboral medico termino
        $hora_medico_end = strtotime($horario[0]['departure_time']);
        if (empty($horas)) {
            //crearmos los horarios dinamicamente
            for ($hora_medico_star; $hora_medico_star <=
                $hora_medico_end; $hora_medico_star = strtotime('+1 hour', $hora_medico_star)) {
                $hora = date('H:i:s', $hora_medico_star);
                array_push($horas_medico, ["tiempo" => $hora]);
            }
            $data = $horas_medico;
            return $this->respond($data);
        } else {
            //creamos las horas dipobibles del medico descartando las ocupadas
            for ($hora_medico_star; $hora_medico_star <= $hora_medico_end; $hora_medico_star = strtotime('+1 hour', $hora_medico_star)) {
                $hora = date('H:i:s', $hora_medico_star);
                array_push($horas_medico, $hora);
            }
            //creamos un arreglo asociativo para comprar las horas ocupadas
            foreach ($horas as $key) {
                array_push($horas_obsoletas, $key['time_appointment']);
            }
            //quitamos la horas repetidas
            $result = array_diff($horas_medico, $horas_obsoletas);
            $data = array();
            //creamos un arreglo con las horas disponibles clave valor
            foreach ($result as $time) {
                array_push($data, ["tiempo" => $time]);
            }
            return $this->respond($data);
        }
    }

    public function getConsultorios() {
        //trae los consultorios diponibles 
        $model_cotization = model('App\Models\Model_cotizacion/Cotizacion');
        $consultorio = model('App\Models\Catalogos\Laboratorio\Consulting_room');
        $id_cotizacion = $_POST['id_cotizacion'];
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $unidad = $model_cotization->getUunit($id_cotizacion);
        $negocio = $unidad[0]['id_business_unit'];
        //datos de consultorios
        $data = $consultorio->officesAvailable($negocio, $fecha, $hora);
        return $this->respond($data);
    }

    public function updateCita() {   //actaulizamos las citas que requieren cita y agregamos a cita de agendas
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $agenda_citas = model('App\Models\Agendas\Appointment_schedule');
        $agenda_medico = model('App\Models\Agendas\Doctor_schedule');
        $agenda_consultorio = model('App\Models\Agendas\Office_schedule');
        $id_cita = $_POST['id_cita'];
        $id_insumo = $model_citas->getStudy($id_cita);
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
                'id_cotizacion' =>  $_POST['id_cotizacion'],
                'id_insumo' => $id_insumo[0]['id_study'],
                'fecha' => $_POST['fecha'],
                'hora' => $_POST['horario'],
                'id_doctor' => $_POST['medico'],
                'id_consultorio' => $_POST['consultorio'],
                'id_cita' => $_POST['id_cita']

            ];
            $agenda_citas->insert($data);
            $id_agenda = $agenda_citas->getInsertID();
            //si se crea la agenda
            if ($id_agenda) {
                //insertamos en la agenda del medico
                $data_medico = [
                    'id_doctor' => $_POST['medico'],
                    'date_appointment' =>  $_POST['fecha'],
                    'time_appointment' => $_POST['horario'],
                    'id_cita' => $id_agenda,
                ];
                $agenda_medico->insert($data_medico);
                // insertamos en la agenda de consultorios
                $data_consultorio = [
                    'id_consulting ' => $_POST['consultorio'],
                    'date_appointment' =>  $_POST['fecha'],
                    'time_appointment' => $_POST['horario'],
                    'id_cita' => $id_agenda,
                ];

                $id_agenda_consultorio = $agenda_consultorio->insert($data_consultorio);
                $mensaje = messages($insert = 0, $id_agenda_consultorio);
                return $this->respond($mensaje);
            }
        }
    }

    //ELIMINAR TODOS LOS PRODUCTOS
    public function delete_all() {
        //model citas
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $request = \Config\Services::request();
        $id_cotization = $request->getVar("id_delete_all");
        $count = $this->model->get_cotizations($id_cotization);

        if ($count[0]->total == 0) {
            $mensaje = [
                'status' => 200,
                'msg' => 210
            ];
        } else {
            $this->model->delete_all($id_cotization);
            //retun affected rows into database
            $affected_rows = $this->db->affectedRows();
            $mensaje = messages($detele = 2, $affected_rows);
        }
        return $this->respond($mensaje);
    }

    //OBTENER EL PRECIO TOTAL DE LA COTIZACION
    public function get_total() {
        $id = $_POST['id_cotizacion'];
        $data = $this->model->get_total($id);
        return $this->respond($data);
    }

    public function enviar() {   //envio de cotizacion al correo del paciente
        $id = $_POST['id_cotizacion'];
        $model_cotizacion = model('App\Models\Model_cotizacion\Cotizacion');
        $datos_user = $model_cotizacion->readCliente($id);
        if ($datos_user[0]->email_cliente == "") {
            $response = [
                "status" => 400,
                "msg" => "NO CONTAMOS CON UN CORREO PARA ENVIAR LA INFORMACIÓN"
            ];
            return $this->respond($response);
        } else {
            $model_productos = model('App\Models\Model_cotization_product\cotization_product');
            $model_cotizacion = model('App\Models\Model_cotizacion\Cotizacion');
            $model_company = model('App\Models\Company_data\Company_data');
            $datos_user = $model_cotizacion->readCliente($id);
            $data['productos'] = $model_productos->readCotizations($id);
            $data['cliente'] = $model_cotizacion->readCliente($id);
            $data['total'] = $model_productos->get_total($id);
            $data['cotizacion'] = $id;
            $data['company'] = $model_company->getConpany();
            //CREAR UN DOCUMENTO PDF CON MPDF
            $output2 = '../public/Cotizaciones/cotizacion' . $id . '.pdf';
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($this->impreso($data));
            $file = $mpdf->Output($output2, 'F');
            $correo_envio = $datos_user[0]->email_cliente;
            $mensaje = "Cotizacion";
            $asunto = "";
            $file_array = array(
                $output2,
            );
            $envio = send_email($correo_envio, $asunto, $mensaje, $file_array);
            if ($envio) {
                unlink($output2);
                $response = [
                    "status" => 200,
                    "msg" => "CORREO ENVIADO CON EXITO"
                ];
                return $this->respond($response);
            }
        }
    }

    //envio de cotizacion al correo del paciente
    public function sendCotizacion() {
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $correo = $request->getPost('correo');
        $model_cotizacion = model('App\Models\Model_cotizacion\Cotizacion');
        $datos_user = $model_cotizacion->readCliente($id);
        $model_productos = model('App\Models\Model_cotization_product\cotization_product');
        $model_cotizacion = model('App\Models\Model_cotizacion\Cotizacion');
        $model_company = model('App\Models\Company_data\Company_data');
        $datos_user = $model_cotizacion->readCliente($id);
        $data['productos'] = $model_productos->readCotizations($id);
        $data['cliente'] = $model_cotizacion->readCliente($id);
        $data['total'] = $model_productos->get_total($id);
        $data['cotizacion'] = $id;
        $data['company'] = $model_company->getConpany();

        //CREAR UN DOCUMENTO PDF CON MPDF
        $output2 = '../public/Cotizaciones/cotizacion' . $id . '.pdf';
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($this->impreso($data));
        $file = $mpdf->Output($output2, 'F');
        $mensaje = "Cotizacion";
        $asunto = "Cotización";
        $file_array = array(
            $output2,
        );
        $envio = send_email($correo, $asunto, $mensaje, $file_array);
        if ($envio) {
            unlink($output2);
            $response = [
                "status" => 200,
                "msg" => "CORREO ENVIADO CON EXITO"
            ];
            return $this->respond($response);
        }
    }

    //vista de la creacion del archivo pdf
    public function impreso($data) {
        return view('Cotizacionpdf/Cotizacionpdf', $data);
    }

    //horas por unidad de negocio
    public function getHorasunity() {
        $model_cotizacion = model('App\Models\Model_cotizacion\Cotizacion');
        $id_cotizacion = $_POST['id_cotizacion'];
        $horas_bussines = $model_cotizacion->getUunit($id_cotizacion);
        $horas_negocio = array();
        $hora_negocio_start = strtotime($horas_bussines[0]['start_time']);
        $hora_negocio_end = strtotime($horas_bussines[0]['final_hour']);

        for ($hora_negocio_start; $hora_negocio_start <=
            $hora_negocio_end; $hora_negocio_start = strtotime('+1 hour', $hora_negocio_start)) {
            $hora = date('H:i:s', $hora_negocio_start);
            array_push($horas_negocio, $hora);
        }
        $data = $horas_negocio;
        return $this->respond($data);
    }

    public function hourlySearch() {
        $model_cotization = model('App\Models\Model_cotizacion/Cotizacion');
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $model_medico = model('App\Models\HCV\Operativo\Ficha_Identificacion');
        $consultorio = model('App\Models\Catalogos\Laboratorio\Consulting_room');
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $id_cotizacion = $_POST['id_cotizacion'];
        $id_cita = $_POST['id_cita'];
        $unidad = $model_cotization->getUunit($id_cotizacion);
        //requieren citas
        $citas = $model_citas->getConsulta($id_cita);
        $diciplina = $citas[0]['id_discipline'];
        $data['medicos'] = $model_medico->getDoctor($fecha, $hora, $diciplina, $unidad[0]['id_business_unit']);
        $data['consultorios'] = $consultorio->officesAvailable($unidad[0]['id_business_unit'], $fecha, $hora);
        return $this->respond($data);
    }

    public function getContorioslab() {
        //Consultorios diponobles por unidad de negocio
        $id_cotizacion = $_POST['id_cotizacion'];
        $model_cotization = model('App\Models\Model_cotizacion/Cotizacion');
        $consultorio = model('App\Models\Catalogos\Laboratorio\Consulting_room');
        $unidad = $model_cotization->getUunit($id_cotizacion);
        $negocio = $unidad[0]['id_business_unit'];
        $data =  $consultorio->getConsultorios($negocio);
        return $this->respond($data);
    }

    public function createLab() {
        $model = model('App\Models\Catalogos\Insumos');
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $model_consultorio = model('App\Models\Catalogos\Laboratorio\Consulting_room');
        $agenda_consultorio = model('App\Models\Agendas\Office_schedule');
        $agenda_citas = model('App\Models\Agendas\Appointment_schedule');
        $model_cotizacion = model('App\Models\Model_cotizacion\Cotizacion');
        $model_unidad = model('App\Models\Catalogos\BusinessUnit');
        $id_cita = $_POST['id_cita'];
        $id_consultorio = $_POST['consultorio'];
        $id_cotizacion = $_POST['id_cotizacion'];
        $fecha = $_POST['fecha'];
        //datos de la tabla de citas
        $citas = $model_citas->find($id_cita);
        //datos de la duracion de cita
        $duration =  $model->getDuration($citas['id_study']);
        //datos de la agenda de citas
        $agendacon = $agenda_consultorio->searchConsulting($id_consultorio, $fecha);
        //horario de consultorio
        $horas_consultorio  = $model_consultorio->find($id_consultorio);

        if (empty($agendacon)) {
            $hora = $horas_consultorio['start_time'];
            $data_cita = [
                'fecha' => $fecha,
                'hora' => $hora,
                'id_consultorio' => $id_consultorio

            ];
            $model_citas->update($id_cita, $data_cita);
            $affected_rows = $this->db->affectedRows();

            if ($affected_rows > 0) {
                $data = [
                    'id_cotizacion' =>  $_POST['id_cotizacion'],
                    'id_insumo' => $citas['id_study'],
                    'fecha' => $_POST['fecha'],
                    'hora' => $hora,
                    'id_consultorio' => $_POST['consultorio'],
                    'id_cita' => $id_cita

                ];
                $agenda_citas->insert($data);
                $id_agenda = $agenda_citas->getInsertID();
                $data_consultorio = [
                    'id_consulting ' => $_POST['consultorio'],
                    'date_appointment' =>  $_POST['fecha'],
                    'time_appointment' => $hora,
                    'id_cita' => $id_agenda,
                ];
                $id_agenda_consultorio = $agenda_consultorio->insert($data_consultorio);
                $mensaje = messages($insert = 0, $id_agenda_consultorio);
                return $this->respond($mensaje);
            }
        } else {
            $max_hours = $agenda_consultorio->getHours($fecha, $id_consultorio);
            $hora_suma = '+' . $duration[0]['duration'] . 'minute';
            $horas_total = strtotime($hora_suma, strtotime($max_hours[0]['time_appointment']));
            $hora = date('H:i:s', $horas_total);
            $data_cita = [
                'fecha' => $fecha,
                'hora' => $hora,
                'id_consultorio' => $id_consultorio

            ];
            $model_citas->update($id_cita, $data_cita);
            $affected_rows = $this->db->affectedRows();

            if ($affected_rows > 0) {
                $data = [
                    'id_cotizacion' =>  $_POST['id_cotizacion'],
                    'id_insumo' => $citas['id_study'],
                    'fecha' => $_POST['fecha'],
                    'hora' => $hora,
                    'id_consultorio' => $_POST['consultorio']

                ];
                $agenda_citas->insert($data);
                $id_agenda = $agenda_citas->getInsertID();
                $data_consultorio = [
                    'id_consulting ' => $_POST['consultorio'],
                    'date_appointment' =>  $_POST['fecha'],
                    'time_appointment' => $hora,
                    'id_cita' => $id_agenda,
                ];
                $id_agenda_consultorio = $agenda_consultorio->insert($data_consultorio);
                $mensaje = messages($insert = 0, $id_agenda_consultorio);
                return $this->respond($mensaje);
            }
        }
    }

    public function validateCita() {
        $model_cotization = model('App\Models\Model_cotizacion/Cotizacion');
        $id_cotizacion = $_POST['id'];
        $data = $model_cotization->validateCitas($id_cotizacion);
        if (empty($data)) {
            $correcto = true;
        } else {
            $correcto =  false;
        }
        return $this->respond($correcto);
    }

    //datos para editar cita 
    public function getCita() {
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $model_medico = model('App\Models\HCV\Operativo\Ficha_Identificacion');
        $agenda_medico = model('App\Models\Agendas\Doctor_schedule');
        $consultorio = model('App\Models\Catalogos\Laboratorio\Consulting_room');
        date_default_timezone_set("America/Guatemala");
        $id_cita = $_POST['id'];
        $data_citas = $model_citas->find($id_cita);
        $citas = $model_citas->getConsulta($id_cita);
        $diciplina = $citas[0]['id_discipline'];
        $data['medicos'] = $model_medico->get_operativos($data_citas['id_business_unit'], $diciplina);
        //horario laboral del medico
        $horario = $model_medico->getHorario($data_citas['id_doctor']);
        //horas_ocupadas
        $horas = $agenda_medico->getHours($data_citas['fecha'], $data_citas['id_doctor']);
        $horas_medico = array();
        $hora_medico_star = strtotime($horario[0]['entry_time']);
        $hora_medico_end = strtotime($horario[0]['departure_time']);

        for ($hora_medico_star; $hora_medico_star <= $hora_medico_end; $hora_medico_star = strtotime('+1 hour', $hora_medico_star)) {
            $hora = date('H:i:s', $hora_medico_star);
            array_push($horas_medico, $hora);
        }

        $horas_obsoletas = array();
        foreach ($horas as $key) {
            array_push($horas_obsoletas, $key['time_appointment']);
        }
        //quitamos la horas repetidas
        $result = array_diff($horas_medico, $horas_obsoletas);
        array_push($result, $data_citas['hora']);
        //ordenamos el arrelo de form ascentende del valor
        asort($result);
        $data_dispinibles = array();
        //creamos un arreglo con las horas disponibles clave valor
        foreach ($result as $time) {
            array_push($data_dispinibles, ["tiempo" => $time]);
        }
        $data['horas'] = $data_dispinibles;
        $data['consultorios'] = $consultorio->officesAvailableup($data_citas['id_business_unit'], $data_citas['fecha'], $data_citas['hora']);
        $data['citas'] = $data_citas;
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
                $affected_rows = $this->db->affectedRows();
                $mensaje = messages($update = 1, $affected_rows);
                return $this->respond($mensaje);
            }
        }
    }

    //busqueda por horas update
    public function searchGethoras() {
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $model = model('App\Models\Catalogos\BusinessUnit');
        $model_medico = model('App\Models\HCV\Operativo\Ficha_Identificacion');
        $consultorio = model('App\Models\Catalogos\Laboratorio\Consulting_room');
        $id_cita = $_POST['id'];
        $data_citas = $model_citas->find($id_cita);
        $horas_bussines = $model->getBusinessUnit($data_citas['id_business_unit']);
        $horas_negocio = array();
        $hora_negocio_start = strtotime($horas_bussines[0]['start_time']);
        $hora_negocio_end = strtotime($horas_bussines[0]['final_hour']);

        for ($hora_negocio_start; $hora_negocio_start <=
            $hora_negocio_end; $hora_negocio_start = strtotime('+1 hour', $hora_negocio_start)) {
            $hora = date('H:i:s', $hora_negocio_start);
            array_push($horas_negocio, $hora);
        }
        $citas = $model_citas->getConsulta($id_cita);
        $diciplina = $citas[0]['id_discipline'];
        $data['horas'] = $horas_negocio;
        $data['medicos'] = $model_medico->getDoctorhours($data_citas['fecha'], $data_citas['hora'], $diciplina, $data_citas['id_business_unit']);
        $data['consultorios'] = $consultorio->officesAvailableup($data_citas['id_business_unit'], $data_citas['fecha'], $data_citas['hora']);
        $data['citas'] = $data_citas;
        return $this->respond($data);
    }

    public function getLabcitas() {
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $consultorio = model('App\Models\Catalogos\Laboratorio\Consulting_room');
        $id_cita = $_POST['id'];
        $citas = $model_citas->find($id_cita);
        $negocio = $citas['id_business_unit'];
        $data['consultorios'] =  $consultorio->getConsultorios($negocio);
        $data['citas'] = $citas;
        return $this->respond($data);
    }

    public function updateLaboratorio() {
        $model = model('App\Models\Catalogos\Insumos');
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $model_consultorio = model('App\Models\Catalogos\Laboratorio\Consulting_room');
        $agenda_consultorio = model('App\Models\Agendas\Office_schedule');
        $agenda_citas = model('App\Models\Agendas\Appointment_schedule');
        $id_cita = $_POST['id_cita'];
        $fecha = $_POST['fecha'];
        $consultorio = $_POST['consultorio'];
        //datos de la tabla de citas
        $citas = $model_citas->find($id_cita);
        //id agenda general
        $id_agenda = $agenda_citas->select('id')->where('id_cita', $id_cita)->first()['id'];
        //id agenda consultorio
        $id_agenda_consul = $agenda_consultorio->select('id')->where('id_cita', $id_agenda)->first()['id'];
        //datos de la duracion de cita
        $duration =  $model->getDuration($citas['id_study']);
        //datos de la agenda de citas
        $agendacon = $agenda_consultorio->searchConsulting($consultorio, $fecha);
        //horario de consultorio
        $horas_consultorio  = $model_consultorio->find($consultorio);

        if (empty($agendacon)) {
            $hora = $horas_consultorio['start_time'];
            $data_cita = [
                'fecha' => $fecha,
                'hora' => $hora,
                'id_consultorio' => $consultorio

            ];
            $model_citas->update($id_cita, $data_cita);
            $affected_rows = $this->db->affectedRows();

            if ($affected_rows > 0) {
                $data = [
                    'fecha' => $_POST['fecha'],
                    'hora' => $hora,
                    'id_consultorio' => $_POST['consultorio']

                ];
                $agenda_citas->update($id_agenda, $data);

                $data_consultorio = [
                    'id_consulting ' => $_POST['consultorio'],
                    'date_appointment' =>  $_POST['fecha'],
                    'time_appointment' => $hora,
                ];
                $agenda_consultorio->update($id_agenda_consul, $data_consultorio);
                $affected_rows = $this->db->affectedRows();
                $mensaje = messages($update = 1, $affected_rows);
                return $this->respond($mensaje);
            }
        } else {
            $max_hours = $agenda_consultorio->getHours($fecha, $consultorio);
            $hora_suma = '+' . $duration[0]['duration'] . 'minute';
            $horas_total = strtotime($hora_suma, strtotime($max_hours[0]['time_appointment']));
            $hora = date('H:i:s', $horas_total);
            $data_cita = [
                'fecha' => $fecha,
                'hora' => $hora,
                'id_consultorio' => $consultorio

            ];
            $model_citas->update($id_cita, $data_cita);
            $affected_rows = $this->db->affectedRows();

            if ($affected_rows > 0) {
                $data = [
                    'fecha' => $_POST['fecha'],
                    'hora' => $hora,
                    'id_consultorio' => $_POST['consultorio']

                ];
                $model_citas->update($id_cita, $data_cita);
                $affected_rows = $this->db->affectedRows();
                $data_consultorio = [
                    'id_consulting ' => $_POST['consultorio'],
                    'date_appointment' =>  $_POST['fecha'],
                    'time_appointment' => $hora,
                    'id_cita' => $id_agenda,
                ];
                $agenda_consultorio->update($id_agenda_consul, $data_consultorio);
                $affected_rows = $this->db->affectedRows();
                $mensaje = messages($update = 1, $affected_rows);
                return $this->respond($mensaje);
            }
        }
    }
}
