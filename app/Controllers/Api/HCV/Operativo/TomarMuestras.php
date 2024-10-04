<?php 

/* Desarrollador: Airam Vargas
Fecha de creacion:
Fecha de Ultima Actualizacion: 29 - 08 - 2023 Airam Vargas
Perfil: Recepcionista
Descripcion: Pantalla principal para un usuario tomador de muestra, se muestra la lista de todas las muestras pendientes */

namespace App\Controllers\Api\HCV\Operativo;
require __DIR__ . '/Impresion/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Model_cotization_product\cotization_product as model;
use App\Models\Model_cotizacion\Model_citas as citas;
use App\Models\HCV\Operativo\Ficha_Identificacion as identity; 
use App\Models\HCV\Operativo\Tomador_areas as areas; 
use DateTime;

//require_once __DIR__ . '/vendor/autoload.php';

class TomarMuestras extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;
    var $citas;
    var $identity;
    var $areas;


    public function __construct() {
        //Assign global variables
        $this->db = db_connect();
        $this->model = new model();
        $this->citas = new citas();
        $this->identity = new identity();
        $this->areas = new areas();
        //$this->indicencias = new \App\Models\Catalogos\Laboratorio\Incidencias();
        helper('messages');
    }
    
    //FUNCION LA LISTA DE PRUEBAS PENDIENTES
    public function showMuestras(){ 
        $session = session();
        $user_id = $session->get('unique');
        $areas_tomador = $this->areas->readAreas($user_id);
        $areas_push = [];

        foreach($areas_tomador as $key){
            array_push($areas_push, $key['id_category_lab']);
        }
        $areas = implode("','", $areas_push);

        $id_cat_bussienes = $this->identity->select('id_cat_business_unit')->where('user_id', $user_id)->find();
        $data = $this->model->showMuestras($id_cat_bussienes[0]['id_cat_business_unit'], "'".$areas."'");
        return $this->respond($data);
    }

    //FUNCION LA INFO. DE CADA ESTUDIO/PAQUETE
    public function showStudies(){
        $session = session();
        $user_id = $session->get('unique');
        $areas_tomador = $this->areas->readAreas($user_id);
        $areas_push = [];
        $id_cotization_x_prod = $_POST['id'];

        foreach($areas_tomador as $key){
            array_push($areas_push, $key['id_category_lab']);
        }
        $areas = implode("','", $areas_push);

        $data = $this->citas->showStudies($id_cotization_x_prod, "'".$areas."'");
        return $this->respond($data);
    }

    public function aceptarMuestra(){
        $request = \Config\Services::request();
        $session = session();
        $user_id = $session->get('unique');
        $length = count($request->getPost());
        $data2 = $request->getPost();
        $arr = [];
        $id_cot_x_prod = $request->getPost('id');
        $id_consulting = $this->identity->select('id_consulting_room')->where('user_id', $user_id)->find();
        $status_lab = 102;
        $model_status = model('App\Models\Catalogos\Laboratorio\Status_lab');
        $name_status = $model_status->select('name')->where('id', $status_lab)->find();
        
        foreach ($_POST['id_cita'] as $key) {
            $data = [
                'id_doctor' => $user_id,
                'id_consultorio' => $id_consulting[0]['id_consulting_room'],
                'status_lab' => $status_lab, 
                'status_name' => $name_status[0]['name']
            ];

            $this->citas->update($key, $data); 
        }

        $count = $this->citas->studiesCount($id_cot_x_prod, $status_lab);
        if($count[0]->restan == 0){
            $data_cot = [
                'status_lab' => $status_lab, 
                'status_name' => $name_status[0]['name']
            ];

            $this->model->update($id_cot_x_prod, $data_cot); 
        }
        
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $this->respond($mensaje);
    }

    public function primerIngreso(){
        $session = session();
        $user_id = $session->get('unique');
        $request = \Config\Services::request();

        $id = $this->identity->select('ID')->where('user_id', $user_id)->find();
        $data = [
            'id_cat_business_unit' => $request->getPost('unidad_negocio'),
            'id_consulting_room' => $request->getPost('consultorio'),
            'status_area' => 1
        ];

        $this->identity->update($id[0]['ID'], $data);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $this->respond($mensaje);
    }

    public function barCode(){
        $uri = service('uri');
        $id_cita = $uri->getSegment(6);
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $data['datos'] = $model_citas->getDatosL($id_cita);
        $nacimiento = new DateTime($data['datos'][0]['BIRTHDATE']);
        $ahora =  new DateTime();
        $diferencia = $ahora->diff($nacimiento);
        $edad = $diferencia->format("%y");
        $genero = $data['datos'][0]['SEX'];
        $fecha = date('ymd');
        $new_unit = str_pad($data['datos'][0]['id_business_unit'], 2, "0", STR_PAD_LEFT);
        $cita_new = str_pad($id_cita, 6, "0", STR_PAD_LEFT);
        $prueba_new = str_pad($data['datos'][0]['id_cotization_x_product'], 6, "0", STR_PAD_LEFT);
        $codigo = $fecha.$new_unit.$prueba_new.$cita_new;
        $sex = $genero == "Mujer" ? "F" : "M";
        $nacimiento = date('d-m-Y', strtotime($data['datos'][0]['BIRTHDATE']));
        $data_citas = [
            'codigo' => $codigo
        ];

        $data['extra'] = [
            'edad' => $edad, 
            'genero' => $sex,
            'codigo' => $codigo
        ];

        $model_citas->update($id_cita, $data_citas);
        
        return $this->respond($data);
    }

    public function imprimirEtiqueta(){
        $request = \Config\Services::request();
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $id = $request->getPost('id');
        $data = [
            'imprimir' => 1
        ];
        $model_citas->update($id, $data);
        $affected_rows = $this->db->affectedRows();
        if ($affected_rows > 0) {
            $data = [
                "status" => 200,
                "msg" => "ACTUALIZADO CON EXITO"
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

    public function reimprimir(){
        $request = \Config\Services::request();
        $session = session();
        $user_id = $session->get('unique');
        $model_incidencias = model('App\Models\Tomador_muestra\Incidencias');
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $model_doctor = model('App\Models\HCV\Operativo\Ficha_Identificacion');
        $id = $request->getPost('id_cita');
        $name_medico = $model_doctor->getName($user_id);
        $datos_estudio = $model_citas->getDatosStudy($id);

        $data_incidencia = [
            'name_doctor' => $name_medico[0]['nombre'],
            'id_doctor' => $user_id,
            'id_study' => $datos_estudio[0]['id_study'],
            'name_study' => $datos_estudio[0]['producto'],
            'id_cita' => $id,
            'incidence' => $request->getPost('motivo')
        ];

        $id = $model_incidencias->insert($data_incidencia);
        if ($id) {
            $response = [
                "status" => 200,
                "msg" => "Reimpresión",
                "id" => $request->getPost('id_cita')
            ];
            return $this->respond($response);
        }else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return $this->respond($data);
        }
    }

    public function finalizar(){
        $request = \Config\Services::request();
        $session = session();
        $user_id = $session->get('unique');
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $model_status = model('App\Models\Catalogos\Laboratorio\Status_lab');
        $status_lab = 108;
        $id = $request->getPost('id_cita');
        $name_status = $model_status->select('name')->where('id', $status_lab)->find();
        $codigo = $model_citas->select('codigo')->where('id', $id)->find()[0]['codigo'];

        if($codigo == NULL){
            $data['datos'] = $model_citas->getDatosL($id);
            $fecha = date('ymd');
            $new_unit = str_pad($data['datos'][0]['id_business_unit'], 2, "0", STR_PAD_LEFT);
            $cita_new = str_pad($id, 6, "0", STR_PAD_LEFT);
            $prueba_new = str_pad($data['datos'][0]['id_cotization_x_product'], 6, "0", STR_PAD_LEFT);
            $codigoNew = $fecha.$new_unit.$prueba_new.$cita_new;

            $data = [
                'codigo' => $codigoNew,
                'status_lab' => $status_lab, 
                'status_name' => $name_status[0]['name']
            ];
        } else {
            $data = [
                'status_lab' => $status_lab, 
                'status_name' => $name_status[0]['name']
            ];
        }

        $model_citas->update($id, $data);
        $affected_rows = $this->db->affectedRows();
        $count = $model_citas->getTotalPen($user_id);
        //var_dump($data);
        if ($affected_rows > 0) {
            $data = [
                "status" => 200,
                "msg" => "ACTUALIZADO CON EXITO",
                'count' => $count[0]['id_study']
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