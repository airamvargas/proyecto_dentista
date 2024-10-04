<?php

/*
Desarrollador: Giovanni Zavala
Fecha Creacion: 17-10-2023
Fecha de Ultima Actualizacion: 17-10-2023
Perfil: Responsable sanitario
Descripcion: Resultados de estudios
*/

namespace App\Controllers\Api\Responsable_sanitario;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');

use DateTime;

class Muestras extends ResourceController
{
    use ResponseTrait;
    var $db;
    //model citas
    var $model;
    //modelo cotizacion por poducto
    var $model_c_p;
    var $model_results;
    var $model_paciente;
    var $model_analitos;
    var $rangos_edad;
    var $rangos_crm;
    var $insumos;


    public function __construct()
    {
        //variables globales 
        $this->db = db_connect();
        $this->model  = new \App\Models\Model_cotizacion\Model_citas();
        $this->model_c_p  = new \App\Models\Model_cotization_product\cotization_product();
        $this->model_results  = new \App\Models\Responsable_sanitario\Results();
        $this->model_paciente =  new \App\Models\Models_hcv\Model_identity();
        $this->model_analitos = new \App\Models\Catalogos\Cat_exams();
        $this->rangos_edad =  new \App\Models\Catalogos\Laboratorio\Age_range();
        $this->rangos_crm = new \App\Models\Catalogos\Laboratorio\Cat_ranges_exam();
        $this->insumos = new \App\Models\Catalogos\Insumos();
        helper('messages');
    }

    public function index()
    {
        //datos de la tabla de muestras
        $data["data"] = $this->model->getMuestras();
        return $this->respond($data);
    }

    //GUARDADO DE RESULTADOS
    public function results()
    {
        $session = session();
        $user_id = $session->get('unique');
        $id_paciente = $_POST['id_paciente'];
        $id_cita = $_POST['id_cita'];
        $id_estudio = $_POST['id_study'];
        $id_c = $this->model->select('id_cotization_x_product')->where('id', $id_cita)->find();
        $paciente = $this->model_paciente->readPatient($id_paciente);
        $tipo = $this->model->getDatosL($id_cita)[0]['tipo_muestra'];
        $name_study =  $this->insumos->where('id_product', $id_estudio)->find()[0]['name'];

        if ($paciente[0]['SEX'] == "Hombre") {
            $id_sex = 1;
            $sex = "Masculino";
        } else {
            $id_sex = 2;
            $sex = "Femenino";
        }

        $nombre_paciente = $paciente[0]['NAME'] . " " . $paciente[0]['F_LAST_NAME'] . " " . $paciente[0]['S_LAST_NAME'];
        $nacimiento = new DateTime($paciente[0]['BIRTHDATE']);
        $ahora =  new DateTime();
        $diferencia = $ahora->diff($nacimiento);
        $edad = $diferencia->format("%y");
        //validamos si hay un rango existe 
        /*$rango = $this->rangos_edad->ageRange($edad);

        //validacion de rango de edad, si existe en base
        if (empty($rango)) {
            $response = [
                "status" => 400,
                "msg" => "NO SE ENCUENTRO UN RANGO DE EDAD CORRESPONDIENTE 
                PONGASE EN CONTACTO CON EL ADMINISTRADOR"
            ];
            return $this->respond($response);
        }*/

        //validacion que exista ese rango de edad dentro de ese analito
        $validate_db = $this->getValidate($_POST, $id_sex, $edad);

        if ($validate_db) {
            foreach ($_POST['resultado'] as $index => $key) {
                switch ($_POST['tipo'][$index]) {
                    case 1:
                        //traemos los datos de cada uno de los anaitos para validar los rangos
                        $values = $this->rangos_crm->getResulText($_POST['id_analito'][$index], $id_sex, $edad);
                        $metodo = $values[0]->metodo;
                        $min = $values[0]->min;
                        $max = $values[0]->max;
                        $operator = $values[0]->operator;
                        $unidad = $values[0]->unidad;
                        $agrupador =  $values[0]->agrupador;

                        //validacion si los datos tienen un operador
                        //valores numericos

                        if (($values[0]->operator == null) or ($values[0]->operator  == "")) {
                            if (($_POST['resultado'][$index] >= $values[0]->min ) and ($_POST['resultado'][$index] <= $values[0]->max )) {
                                $cumple = 1;
                            } else {
                                $cumple = 0;
                            }
                        } else {
                            //realizamos las operaciones con el resultado dado
                            $operador = $values[0]->operator ;
                            switch ($operador) {
                                case '>':
                                    if ($_POST['resultado'][$index] > $values[0]->min ) {
                                        $cumple = 1;
                                    } else {
                                        $cumple = 0;
                                    }
                                    break;
                                case '>=':
                                    if ($_POST['resultado'][$index] >= $values[0]->min) {
                                        $cumple = 1;
                                    } else {
                                        $cumple = 0;
                                    }
                                    break;
                                case '<':
                                    if ($_POST['resultado'][$index] < $values[0]->min) {
                                        $cumple = 1;
                                    } else {
                                        $cumple = 0;
                                    }
                                    break;

                                case '<=':
                                    if ($_POST['resultado'][$index] <= $values[0]->min) {
                                        $cumple = 1;
                                    } else {
                                        $cumple = 0;
                                    }
                                    break;
                            }
                        }

                    break;

                    case 2:
                        $values = $this->rangos_crm->getResulText($_POST['id_analito'][$index], $id_sex, $edad);
                        $min = $values[0]->min;
                        $max = $values[0]->max;
                        $metodo = $values[0]->metodo;
                        $operator = $values[0]->operator;
                        $unidad = $values[0]->unidad;
                        $agrupador =  $values[0]->agrupador;
                        $cumple = 1;
                        break;
                    case 3:
                       
                       
                        $values = $this->rangos_crm->getResulText($_POST['id_analito'][$index], $id_sex, $rango[0]['id']);
                        $min = $values[0]->min;
                        $max = $values[0]->max;
                        $metodo = $values[0]->metodo;
                        $operator = $values[0]->operator;
                        $unidad = $values[0]->unidad;
                        $agrupador =  $values[0]->agrupador;

                        if(strtolower($_POST['resultado'][$index]) == strtolower($min)){
                            $cumple = 1;
                        }else{
                            $cumple = 0;
                        }

                        break; 
                }

                //creamos un arreglo bidimensional para la insercción de datos
                $data[] = [
                    'id_cita' => $id_cita,
                    'id_study' => $id_estudio,
                    'name_analito' => $_POST['analito'][$index],
                    'id_analito' => $_POST['id_analito'][$index],
                    'answer_analito' => $key,
                    'id_responsible' => $user_id,
                    'edad' => $edad,
                    'name_paciente' => $nombre_paciente,
                    'tipo_muestra' => $tipo,
                    'metodo' => $metodo,
                    'operator' => $operator,
                    'referencia_min' => $min,
                    'referencia_max' => $max,
                    'sex' => $sex,
                    'success' => $cumple,
                    'question_type' => $_POST['tipo'][$index],
                    'unit_of_measure' => $unidad,
                    'name_study' => $name_study,
                    'agrupador' => $agrupador,
                    'bandera' => 1
                ]; 
            }

            $this->model_results->insertBatch($data);
            $affected_rows = $this->db->affectedRows(); 

            if ($affected_rows > 0) {
                $data_status = [
                    'status_lab' => 110,
                    'status_name' => 'Estudio liberado',
                    'id_capturista' => $user_id,
                    'id_responsable' => $user_id,
                ];

                //actualizamos el status de los datos de cita y cotizacion por producto
                $this->model->update($id_cita, $data_status);
                $this->model_c_p->update($id_c[0]['id_cotization_x_product'], $data_status);
                $affected_rows2 = $this->db->affectedRows();

                //validamos la inserccion correcta de los datos en base
                if ($affected_rows2 > 0) {
                    $response = [
                        "status" => 200,
                        "msg" => "GUARDADO CON EXITO"
                    ];
                    return $this->respond($response);
                } else {
                    $response = [
                        "status" => 400,
                        "msg" => "ERROR AL GUARDAR"
                    ];
                    return $this->respond($response);
                }
            }
        } else {
            $response = [
                "status" => 400,
                "msg" => "NO SE ENCONTRARON DATOS DE ALGUNOS ANALITOS NO SE PUEDEN GUARDAR LOS DATOS"
            ];
            return $this->respond($response);
        }
    }

    //validamos si los analitos tengan un rango de edad en base
    public function getValidate($post, $id_sex, $edad)
    {
        $bandera = true;
        foreach ($post['id_analito'] as  $key) {
            $values = $this->rangos_crm->getResulText($key, $id_sex, $edad);
            if (empty($values)) {
                $bandera = false;
                break;
            }
        }
        return $bandera;
    }

    public function reOpen()
    {
        //reabre el estudio para ser editado 
        $id_cita = $_POST['id_cita'];

        $data_status = [
            'status_lab' => 104,
            'status_name' => 'Captura de resultados'
        ];

        $this->model->update($id_cita, $data_status);
        $affected_rows = $this->db->affectedRows();

        if ($affected_rows > 0) {
            $response = [
                "status" => 200,
                "msg" => "GUARDADO CON EXITO"
            ];
            return $this->respond($response);
        } else {
            $response = [
                "status" => 400,
                "msg" => "ERROR AL GUARDAR"
            ];
            return $this->respond($response);
        }
    }

    public function aprobar()
    {
        $session = session();
        $user_id = $session->get('unique');
        //aprobado por resposable sanitario
        $id_cita = $_POST['id_cita'];

        $data_status = [
            'status_lab' => 110,
            'status_name' => 'Estudio liberado',
            'id_responsable' => $user_id,
        ];

        $this->model->update($id_cita, $data_status);
        $affected_rows = $this->db->affectedRows();

        if ($affected_rows > 0) {
            $response = [
                "status" => 200,
                "msg" => "GUARDADO CON EXITO"
            ];
            return $this->respond($response);
        } else {
            $response = [
                "status" => 400,
                "msg" => "ERROR AL GUARDAR"
            ];
            return $this->respond($response);
        }
    }


    public function updateAnalito()
    {
        //actalizacion de los resultados del analito
        $session = session();
        $user_id = $session->get('unique');

        foreach ($_POST['id_result'] as $index => $key) {
            $results =  $this->model_results->find($key);
            $id_cita =  $results['id_cita'];
            if ($results['question_type'] == 1) {
                if (($results['operator'] == null) or ($results['operator'] == "")) {
                    if (($_POST['resultado'][$index] >= $results['referencia_min']) and ($_POST['resultado'][$index] <= $results['referencia_max'])) {
                        $cumple = 1;
                    } else {
                        $cumple = 0;
                    }
                } else {
                    $operador = $results['operator'];
                    switch ($operador) {
                        case '>':
                            if ($_POST['resultado'][$index] > $results['referencia_min']) {
                                $cumple = 1;
                            } else {
                                $cumple = 0;
                            }
                            break;
                        case '>=':
                            if ($_POST['resultado'][$index] >= $results['referencia_min']) {
                                $cumple = 1;
                            } else {
                                $cumple = 0;
                            }
                            break;
                        case '<':
                            if ($_POST['resultado'][$index] < $results['referencia_min']) {
                                $cumple = 1;
                            } else {
                                $cumple = 0;
                            }
                            break;

                        case '<=':
                            if ($_POST['resultado'][$index] <= $results['referencia_min']) {
                                $cumple = 1;
                            } else {
                                $cumple = 0;
                            }
                            break;
                    }
                }
            }

            //actualizamos los resultados

            $data = [
                'answer_analito' => $_POST['resultado'][$index],
                'id_responsible' => $user_id,
                'success' => $cumple
            ];

            $this->model_results->update($key, $data);
        }

        $affected_rows = $this->db->affectedRows();

        if ($affected_rows > 0) {
            $data_status = [
                'status_lab' => 110,
                'status_name' => 'Estudio liberado',
                'id_capturista' => $user_id,
                'id_responsable' => $user_id,
            ];

            $this->model->update($id_cita, $data_status);
            $affected_rows2 = $this->db->affectedRows();

            if ($affected_rows2 > 0) {
                $response = [
                    "status" => 200,
                    "msg" => "GUARDADO CON EXITO"
                ];
                return $this->respond($response);
            } else {
                $response = [
                    "status" => 400,
                    "msg" => "ERROR AL GUARDAR"
                ];
                return $this->respond($response);
            }
        } else {
            $response = [
                "status" => 400,
                "msg" => "NO SE ENCONTRARON DATOS DE ALGUNOS ANALITOS NO SE PUEDEN GUARDAR LOS DATOS"
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
        $tipo_muestra = $this->model->select('sample_types.name AS muestra, insumos.name, id_study')->join('insumos', 'insumos.id = citas.id_study')
        ->join('cat_studies', 'insumos.id_product = cat_studies.id')->join('sample_types', 'sample_types.id = cat_studies.id_muestra')->where('citas.id', $id_cita)->find()[0];
        $file = $this->request->getFile('file_documento');
        $datos = $this->model->datosAnalitos($id_cita);
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

        $id_resultado = $this->model_results->insert($data_results);
        if($id_resultado > 0){
            $data_cita = [
                'status_lab' => 110,
                'status_name' => 'Estudio liberado',
                'id_responsable' => $user_id
            ];
            
            $this->model->update($id_cita, $data_cita);

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

    public function eliminarArchivo(){
        $request = \Config\Services::request();
        $session = session();
        $id_cita = $request->getPost('id_cita');
        $id_paciente = $request->getPost('id_paciente');
    
        $id_results = $this->model_results->select('id')->where('id_cita', $id_cita)->find()[0]['id'];

        $data_citas = [
            'status_lab' => 109,
            'status_name' => "Recolecta de muestra"
        ];

        $this->model->update($id_cita, $data_citas);
        $this->model_results->delete($id_results);

        $affected_rows = $this->db->affectedRows();
        if($affected_rows){
            $response = [
                "status" => 200,
                "msg" => "ARCHIVO ELIMINADO"
            ];
            return $this->respond($response);
        } else {
            $response = [
                "status" => 400,
                "msg" => "HUBO UN ERROR, INTENTE DE NUEVO"
            ];
            return $this->respond($response);
        }
    }
}