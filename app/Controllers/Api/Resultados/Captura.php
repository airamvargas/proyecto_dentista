<?php 

/* Desarrollador: Airam Vargas
Fecha de creacion:
Fecha de Ultima Actualizacion: 24 - 08 -2023 por Airam Vargas
Perfil: Recepcionista
Descripcion: Se va a corregir citas médicas pendientes para que la recepción las libere hasta que el día de la cita, 
si el médico la cancela el recepcionista podrá reagendar otra cita */

namespace App\Controllers\Api\Resultados;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use DateTime;
helper('Acceso');

class Captura extends ResourceController {
    use ResponseTrait;
    var $model;
    var $db;
    var $identity;

    public function __construct() {
        //Assign global variables
        $this->db = db_connect();
        $this->citas = new \App\Models\Model_cotizacion\Model_citas();
        $this->resultados = new \App\Models\Capturista\Crm_results();
        $this->analitos = new \App\Models\Catalogos\Cat_exams();
        $this->rangos_edad =  new \App\Models\Catalogos\Laboratorio\Age_range();
        $this->ranges_exams = new \App\Models\Catalogos\Laboratorio\Cat_ranges_exam();
        helper('messages');
    }
    
    //FUNCION PARA DATATABLE
    public function show($id = NULL){ 
        $data['data'] = $this->citas->showRecolectadas();
        return $this->respond($data); 
    }

    //FUNCION PARA DATATABLE
    public function getDatos(){ 
        $uri = service('uri');
        $id_cita = $uri->getSegment(5);
        $model_exams_study = model('App\Models\Catalogos\Exams_x_study');
        $datos = $this->citas->datosAnalitos($id_cita);
        $id_paciente = $datos[0]['id_user_client'];
        $id_product = $datos[0]['id_product'];
        $nacimiento = new DateTime($datos[0]['BIRTHDATE']);
        $ahora =  new DateTime();
        $diferencia = $ahora->diff($nacimiento);
        $edad = $diferencia->format("%y");
        //$rango = $this->rangos_edad->ageRange($diferencia->format("%y"));
        $analitos = $model_exams_study->getAnalito($id_product);
        $data['estudio'] = $datos[0]['estudio'];
        $data['error'] = [];
        $data['analitos'] = [];

        //var_dump($analitos);

        if ($datos[0]['SEX'] == "Hombre") {
            $sex = 1;
            $sexo = "Masculino";
        } else {
            $sex = 2;
            $sexo = "Femenino";
        }

        //validacion de rango de edad, si existe en base
        /*if (empty($rango)) {
            $response = [
                "status" => 400,
                "msg" => "NO SE ENCUENTRO UN RANGO DE EDAD CORRESPONDIENTE 
                PONGASE EN CONTACTO CON EL ADMINISTRADOR"
            ];
            return $this->respond($response);
        }*/

        if(!empty($analitos)){
            foreach($analitos as $datos){
                $id_analito = $datos['id'];
                $values = $this->ranges_exams->getResulText($id_analito, $sex, $edad);
                if(!empty($values)){
                    $data['analitos'][] = $values;

                }else{
                    $data['error'][] = $this->analitos->nameAnalito($id_analito);
                }
            }
        } else {
            $data['analitos'] = [];
        }

        //var_dump($data);

        return $this->respond($data);
    }

    //Insertar datos de los analitos
    public function insertAnalitos(){
        $request = \Config\Services::request();
        $session = session();
        $user_id = $session->get('unique');
        $id_cita = $request->getPost('id_cita');
        $id_paciente = $request->getPost('id_paciente');
        $tipo_muestra = $this->citas->select('sample_types.name AS muestra, insumos.name, id_study')->join('insumos', 'insumos.id = citas.id_study')
        ->join('cat_studies', 'insumos.id_product = cat_studies.id')->join('sample_types', 'sample_types.id = cat_studies.id_muestra')->where('citas.id', $id_cita)->find()[0];
        $datos = $this->citas->datosAnalitos($id_cita);
        $sex = $datos[0]['SEX'] == "Mujer"  ? 2 : 1;
        $nacimiento = new DateTime($datos[0]['BIRTHDATE']);
        $ahora =  new DateTime();
        $diferencia = $ahora->diff($nacimiento);
        $edad = $diferencia->format("%y");
        //$rango = $this->rangos_edad->ageRange($diferencia->format("%y"));

        foreach($_POST['id_analito'] as $index => $key){
            $id_analito = $_POST['id_analito'][$index];
            $tipo = $_POST['tipo'][$index];
            //Para cada tipo de resultado se realizara una accion diferente
            switch($tipo){
                /*Resultado: numerico, se realizara una validacion si el analito tiene o no un operador asignado
                en caso para validar como se realizara la validacion si esta o no dentro de rangos*/
                case 1:
                    $values = $this->ranges_exams->valoresAnalito($id_analito, $sex, $edad);
                    $min = $values[0]->min;
                    $max = $values[0]->max; 

                    if (($values[0]->operator == null) or ($values[0]->operator == "")){
                        if($_POST['resultado'][$index] >= $min AND $_POST['resultado'][$index] <= $max){
                            $success = 1;
                        } else {
                            $success = 0;
                        }
                    } else {
                        $operador = $values[0]->operator;
                        switch($operador){
                            case "<=":
                                if($_POST['resultado'][$index] <= $min) {
                                    $success = 1;
                                } else {
                                    $success = 0;
                                }
                            break;
                            case ">=":
                                if($_POST['resultado'][$index] >= $min) {
                                    $success = 1;
                                } else {
                                    $success = 0;
                                }
                            break;
                            case '>':
                                if($_POST['resultado'][$index] > $min){
                                    $success = 1;
                                }else{
                                    $success = 0;
                                }
                            break;
                            case '<':
                                if($_POST['resultado'][$index] < $min){
                                    $success = 1;
                                }else{
                                    $success = 0;
                                }
                            break;
                        }
                    }
                break;
                case 2:
                    $values = $this->ranges_exams->valoresAnalito($_POST['id_analito'][$index], $sex, $edad);
                    $min = $values[0]->min;
                    $max = $values[0]->max;
                    $success = 0;
                break;
                case 3:
                    $values = $this->ranges_exams->valoresAnalito($_POST['id_analito'][$index], $sex, $edad);
                    $min = $values[0]->min;
                    $max = $values[0]->max;
                    $resultado = strtolower($_POST['resultado'][$index]);
                    if($resultado == strtolower($min)){
                        $success = 1;
                    } else {
                        $success = 0;
                    }
                break;
            }
            $analito = $this->analitos->nombreAnalito($id_analito);

            $data = [
                'id_cita' => $id_cita,
                'id_study' => $tipo_muestra['id_study'],
                'name_study' => $tipo_muestra['name'],
                'id_analito' => $id_analito,
                'name_analito' => $analito[0]['analito'],
                'agrupador' => $analito[0]['agrupador'],
                'answer_analito' => $_POST['resultado'][$index],
                'id_responsible' => $user_id,
                'edad' => $diferencia->format("%y"),
                'name_paciente' => $datos[0]['paciente'],
                'tipo_muestra' => $tipo_muestra['muestra'],
                'metodo' => $analito[0]['metodo'],
                'question_type' => $analito[0]['result'],
                'operator' => $values[0]->operator,
                'referencia_min' => $min,
                'referencia_max' => $max,
                'unit_of_measure'=> $analito[0]['prefix'],
                'success' => $success,
                'bandera' => 1
            ];
            $this->resultados->insert($data); 
        }


        $data_cita = [
            'status_lab' => 104,
            'status_name' => 'Captura de resultados',
            'id_capturista' => $user_id
        ];

        $this->citas->update($id_cita, $data_cita);
        $affected_rows = $this->db->affectedRows();
        if($affected_rows){
            $response = [
                "status" => 200,
                "msg" => "DATOS CAPTURADOS"
            ];
            return $this->respond($response);
        } else {
            $response = [
                "status" => 400,
                "msg" => "NO SE ENCUENTRAN DATOS REGISTRADOS, PONGASE EN CONTACTO CON EL ADMINISTRADOR"
            ];
            return $this->respond($response);
        } 
    }

    public function subirArchivo(){
        $request = \Config\Services::request();
        $session = session();
        $user_id = $session->get('unique');
        $id_cita = $request->getPost('id_cita');
        $id_paciente = $request->getPost('id_paciente');
        $tipo_muestra = $this->citas->select('sample_types.name AS muestra, insumos.name, id_study')->join('insumos', 'insumos.id = citas.id_study')
        ->join('cat_studies', 'insumos.id_product = cat_studies.id')->join('sample_types', 'sample_types.id = cat_studies.id_muestra')->where('citas.id', $id_cita)->find()[0];
        $file = $this->request->getFile('file_documento');
        $datos = $this->citas->datosAnalitos($id_cita);
        $sex = $datos[0]['SEX'] == "Mujer"  ? 2 : 1;
        $nacimiento = new DateTime($datos[0]['BIRTHDATE']);
        $ahora =  new DateTime();
        $diferencia = $ahora->diff($nacimiento);
        
        if (!$file->isValid()) {
            $response = [
                "status" => 400,
                "msg" => "EL ARCHIVO NO ES VALIDO, INTENTE SUBIR OTRO TIPO DE ARCHIVO"
            ];
            return $this->respond($response);
        } else {
            $path = "uploads/resultados/";
            $file->move($path, $file->getRandomName());
            $name_file = $file->getName();
        }

        $data_results = [
            'id_cita' => $id_cita,
            'id_study' => $tipo_muestra['id_study'],
            'name_study' => $tipo_muestra['name'],
            'id_responsible' => $user_id,
            'edad' => $diferencia->format("%y"),
            'name_paciente' => $datos[0]['paciente'],
            'documento' => $name_file,
            'bandera' => 2
        ];

        $id_resultado = $this->resultados->insert($data_results);
        if($id_resultado > 0){
            $data_cita = [
                'status_lab' => 104,
                'status_name' => 'Captura de resultados',
                'id_capturista' => $user_id
            ];
            
            $this->citas->update($id_cita, $data_cita);

            $affected_rows = $this->db->affectedRows();
            if($affected_rows){
                $response = [
                    "status" => 200,
                    "msg" => "ARCHIVO GUARDADO"
                ];
                return $this->respond($response);
            } else {
                $response = [
                    "status" => 400,
                    "msg" => "NO SE ENCUENTRAN DATOS REGISTRADOS, PONGASE EN CONTACTO CON EL ADMINISTRADOR"
                ];
                return $this->respond($response);
            }
        } else {
            $response = [
                "status" => 400,
                "msg" => "HUBO UN ERROR, INTENTE DE NUEVO"
            ];
            return $this->respond($response);
        }
    }

    public function editarArchivo(){
        $request = \Config\Services::request();
        $session = session();
        $user_id = $session->get('unique');
        $id_results = $request->getPost('id_results');
        $id_cita = $request->getPost('id_cita');
        $file = $this->request->getFile('file_documento');
        
        if (!$file->isValid()) {
           $name_file = $request->getPost('name_photo');
        } else {
            $path = "uploads/resultados/";
            $file->move($path, $file->getRandomName());
            $name_file = $file->getName();
        }

        $data_results = [
            'documento' => $name_file
        ];

        $resultado = $this->resultados->update($id_results, $data_results);
        if($resultado > 0){
            $data_cita = [
                'status_lab' => 110,
                'status_name' => 'Estudio liberado',
                'id_responsable' => $user_id
            ];
            
            $this->citas->update($id_cita, $data_cita);

            $affected_rows = $this->db->affectedRows();
            if($affected_rows){
                $response = [
                    "status" => 200,
                    "msg" => "ARCHIVO GUARDADO"
                ];
                return $this->respond($response);
            } else {
                $response = [
                    "status" => 400,
                    "msg" => "NO SE ENCUENTRAN DATOS REGISTRADOS, PONGASE EN CONTACTO CON EL ADMINISTRADORHUBO UN ERROR, INTENTE DE NUEVO"
                ];
                return $this->respond($response);
            }
        } else {
            $response = [
                "status" => 400,
                "msg" => "HUBO UN ERROR, INTENTE DE NUEVO"
            ];
            return $this->respond($response);
        }
    }

    /* public function getValidate($analitos, $sex, $rango){
        foreach($analitos as $datos){
            $id_analito = $datos['id'];
            $values = $this->ranges_exams->valoresAnalito($id_analito, $sex, $rango);
            if (empty($values)) {
                $bandera = false;
                break;
            } else {
                $bandera = true;
            }
        }
        return $bandera;
    }*/
}