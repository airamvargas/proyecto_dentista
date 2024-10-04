<?php

/* Desarrollador: Giovanni Zavala
Fecha de creacion: 8-sep-2023
Fecha de Ultima Actualizacion: 26-sep-2023 
Perfil: Tomador de muestra
Descripcion: Cancelacion de estudio y pasar a toma de muestra para impresion de etiquetas */

namespace App\Controllers\Api\HCV\Operativo;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');

class  Preguntas extends ResourceController
{
    var $db;

    public function __construct()
    { //Assign global variables
        $this->db = db_connect();
    }

    public function CancelStudy()
    {
        //cargamos los modelos
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $model_productos = model('App\Models\Model_cotization_product\cotization_product');
        $model_doctor = model('App\Models\HCV\Operativo\Ficha_Identificacion');
        $model_insumos = model('App\Models\Catalogos\Insumos');
        $model_incidencias = model('App\Models\Tomador_muestra\Incidencias');
        //post id del estudio
        $id_estudio = $_POST['id_estudio'];
        //fecha de hoy
        $hoy = date("Y-m-d");
        //helper session
        $session = session();
        $user_id = $session->get('unique');
        //obtenemos el nombre el medico
        $name_medico = $model_doctor->getName($user_id);

        //sacamos los id de la cita y d la tabla de cotizacion por producto
        $ids = $model_citas->select('id,id_cotization_x_product')->where("id_doctor", $user_id)->where('status_lab', 102)
            ->where('id_study', $id_estudio)
            ->findAll();
        //estatus de rechazo
        $estatus_lab = 106;
        //sacamos el nombre del estudio
        $name_estudio = $model_insumos->select('name')->where('id', $id_estudio)->find();

        $data_cita = [
            'status_lab' => $estatus_lab,
        ];

        //actualizamos la cita con el nuevo status
        $model_citas->update($ids[0]['id'], $data_cita);
        //si actualizo bien en base
        $affected_rows = $this->db->affectedRows();
        //erificamos que si haya actualizado
        if ($affected_rows > 0) {
            $data_producto = [
                'status_lab' => $estatus_lab,
            ];
            $model_productos->update($ids[0]['id_cotization_x_product'], $data_producto);
            $affected_rows2 = $this->db->affectedRows();

            if ($affected_rows2 > 0) {
                $data_incidencia = [
                    'name_doctor' => $name_medico[0]['nombre'],
                    'id_doctor' => $user_id,
                    'id_study' => $id_estudio,
                    'name_study' => $name_estudio[0]['name'],
                    'id_cita' => $ids[0]['id'],
                    'incidence' => $_POST['motivo']
                ];
                $id = $model_incidencias->insert($data_incidencia);

                if ($id) {
                    $response = [
                        "status" => 200,
                        "msg" => "Estudio cancelado"
                    ];
                    return $this->respond($response);
                }
            }
        } else {
            $response = [
                "status" => 400,
                "msg" => "Error al cancelar estudio"
            ];
            return $this->respond($response);
        }
    }



    public function createRequest()
    {
       //modelos
        $model_citas = model('App\Models\Model_cotizacion\Model_citas');
        $model_productos = model('App\Models\Model_cotization_product\cotization_product');
        $model_doctor = model('App\Models\HCV\Operativo\Ficha_Identificacion');
        $model_insumos = model('App\Models\Catalogos\Insumos');
        $model_prenealiticos = model('App\Models\Tomador_muestra\Preanaliticos');
        //estatus toma de muestra 
        $estatus_lab = 107;
        //id del estudio a actualizar 
        $id_estudio = $_POST['id_estudio'];
        //metodo de session
        $session = session();
        $user_id = $session->get('unique');
        $name_medico = $model_doctor->getName($user_id);

        //obtenemos los ids de los productos y del medico
        $ids = $model_citas->select('id,id_cotization_x_product')->where("id_doctor", $user_id)->where('status_lab', 102)
            ->where('id_study', $id_estudio)->findAll();

        //obtenemos nombre del estudio que se va a realizar    
        $name_estudio = $model_insumos->select('name')->where('id', $id_estudio)->find();
        $valores = "";

        //verificamos si el estudio tiene preguntas 
        if (count($_POST) > 1) {
            //recorremos los datos de formulario
            foreach ($_POST['tipo'] as $index => $key) {
                if ($key < 3) {
                    $respuesta = $_POST['respuesta'][$index];
                } else {
                    if (empty($_POST['values'])) {
                        $respuesta = "";
                    } else {
                        foreach ($_POST['values'] as $check) {
                            $valores = $valores . $check . ",";
                            $respuesta = $valores;
                        }
                    }
                }

                $data[] = [
                    'question' => $_POST['pregunta'][$index],
                    'answer' => $respuesta,
                    'name_medico' => $name_medico[0]['nombre'],
                    'name_study' => $name_estudio[0]['name'],
                    'id_doctor' => $user_id,
                    'id_study' => $id_estudio,
                    'id_cita' => $ids[0]['id']
                ];
            }

            $model_prenealiticos->insertBatch($data);
            $affected_rows = $this->db->affectedRows();

            if ($affected_rows > 0) {
                $data_status = [
                    'status_lab' => $estatus_lab,
                ];

                $model_citas->update($ids[0]['id'], $data_status);
                $affected_rows2 = $this->db->affectedRows();

                if ($affected_rows2 > 0) {
                    $count = $model_citas->studiesCount($ids[0]['id_cotization_x_product'], $estatus_lab);
                    if($count[0]->restan == 0){
                        $model_productos->update($ids[0]['id_cotization_x_product'], $data_status);
                    }
                    
                    $response = [
                        "status" => 200,
                        "msg" => "GUARDADO CON EXITO"
                    ];
                    return $this->respond($response);
                }
            } else {
                $response = [
                    "status" => 400,
                    "msg" => "HUBO UN ERROR"
                ];
                return $this->respond($response);
            }
        } else {
            $data_status = [
                'status_lab' => $estatus_lab,
            ];
            $model_citas->update($ids[0]['id'], $data_status);
            $affected_rows = $this->db->affectedRows();

            if ($affected_rows > 0) {
                $model_productos->update($ids[0]['id_cotization_x_product'], $data_status);

                $response = [
                    "status" => 200,
                    "msg" => "GUARDADO CON EXITO"
                ];
                return $this->respond($response);
            }else{
                $response = [
                    "status" => 400,
                    "msg" => "HUBO UN ERROR"
                ];
                return $this->respond($response);
            }
        } 
    }

    public function getMuestra()
    {
        $session = session();
        $user_id = $session->get('unique');
        $model_productos = model('App\Models\Model_cotization_product\cotization_product');
        $data =  $model_productos->getMuestra($user_id);
        return $this->respond($data);
    }
}
