<?php

namespace App\Controllers\Api\Cotizaciones;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');

use App\Models\Model_cotizacion\Model_pagos as model;
use App\Models\Model_cotizacion\Cotizacion as cotizacion;


class Generar_compra extends ResourceController
{
    use ResponseTrait;
    var $model;
    var $db;
    var $cajamodel;
    var $group;
    var $users;
    var $cotizacion;

    public function __construct() { //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        $this->cajamodel = new \App\Models\Model_cotizacion\Model_cash_box();
        $this->group = new \App\Models\Administrador\Groups();
        $this->users = new \App\Models\Administrador\Usuarios();
        $this->cotizacion = new cotizacion();
        helper('messages');
    }

    public function readPaymentType() {
        $id = $_POST['id'];
        $model_paymentType = model('App\Models\Catalogos\Payment_type');
        $data = $model_paymentType->readType($id);
        return $this->respond($data);
    }

    public function readWaypay_() {
        $model_way = model('App\Models\Catalogos\Waytopay');
        $data2 = $model_way->redWayToPay();
        return $this->respond($data2);
    }

    public function show($id = NULL) {
        $id = $_POST['id'];
        $data['data'] = $this->model->show($id);
        return $this->respond($data);
    }

    public function showPayments() {
        $id = $_POST['id'];
        $data = $this->model->showPayments($id);
        return $this->respond($data);
    }

    public function create() {
        $session = session();
        $model_cotization = model('App\Models\Model_cotization_product\cotization_product');
        $model_cash = model('App\Models\Model_cotizacion\Model_cash_box');
        $id = $_POST['id_cotization'];
        $cantidad = $_POST['amount'];
        $cantidad=str_replace(',','',$cantidad); 
        $suma_data = $this->model->showPayments($id);
        $total_data = $model_cotization->get_total($id);
        $user_id = $session->get('unique');
        $date = date("Y-m-d");
        $suma_data[0]->total_pagos == null ? $suma = 0 :  $suma = $suma_data[0]->total_pagos;
        $total = $total_data[0]->total;
        $sum_total = $suma + $cantidad;
        
        if ($sum_total < $total) {
            if ($_POST['id_way_to_pay'] == 4) {
                $cash = $model_cash->findCash($user_id);
                if (isset($cash[0])) { //Si no viene vacio entonces obtengo id
                    $id_cash = $cash[0]['id'];
                } else { //Si viene vacio se crea la caja 
                    $data = [
                        "status" => 202,
                    ];
                    return $this->respond($data);
                }

                $data = [
                    'id_way_to_pay' => $_POST['id_way_to_pay'],
                    'id_payment_type' => $_POST['id_payment_type'],
                    'id_cotization' => $_POST['id_cotization'],
                    'id_cash_box' => $id_cash,
                    'amount' => $cantidad,
                ];

                $id = $this->model->insert($data);
                $mensaje = messages($insert = 0, $id);
            } else {
                foreach ($_POST as $name => $val) {
                    $data[$name] = $val;
                }
                $id = $this->model->insert($data);
                $mensaje = messages($insert = 0, $id);
            }
        } else if ($sum_total == $total) {
            if ($_POST['id_way_to_pay'] == 4) {
                $cash = $model_cash->findCash($user_id);
                if (isset($cash[0])) { //Si no viene vacio entonces obtengo id
                    $id_cash = $cash[0]['id'];
                } else { //Si viene vacio se crea la caja 
                    $data = [
                        "status" => 202,
                    ];
                    return $this->respond($data);
                }

                $data = [
                    'id_way_to_pay' => $_POST['id_way_to_pay'],
                    'id_payment_type' => $_POST['id_payment_type'],
                    'id_cotization' => $_POST['id_cotization'],
                    'id_cash_box' => $id_cash,
                    'amount' => $cantidad,
                    
                ];

                $id = $this->model->insert($data);
                $mensaje = messages($insert = 0, $id);
            } else {
                foreach ($_POST as $name => $val) {
                    $data[$name] = $val;
                }
                $id = $this->model->insert($data);
                $mensaje = messages($insert = 0, $id);
            }
        } else {
            $mensaje = [
                'status' => 400,
                'msg' => "EL MONTO DEBE SER IGUAL O MENOR AL TOTAL"
            ];
        }
        return $this->respond($mensaje);
    }

    public function readUpdate() {
        $id = $_POST['id'];
        $data = $this->model->readUpdate($id);
        return $this->respond($data);
    }

    public function update($id = NULL) {
        $request = \Config\Services::request();
        $id = $request->getPost('id_update');

        $data = [
            'id_way_to_pay' => $request->getPost('forma_pago'),
            'id_payment_type' => $request->getPost('tipo_pago'),
            'amount' => $request->getPost('cantidad_update')
        ];

        $this->model->update($id, $data);

        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje;
    }

    public function delete($id = NULL) {
        $request = \Config\Services::request();
        $id = $request->getVar("id_delete");
        $this->model->delete($id);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje;
    }

    public function createBox() {
        $session = session();
        $id_group = $session->get('group');
        $id_user = $session->get('unique');
        $jerarquia = $this->group->find($id_group);
        $jerarquia = $jerarquia['hierarchy'];
        $code_jeraquia = $this->users->getCode($jerarquia);
        $date = date("Y-m-d");
        $bandera = false;
        $id = null;

        foreach ($code_jeraquia as $key) {
            if ($_POST['code'] == $key['code']) {
                $id = $key['id'];
                $bandera = true;
                break;
            } else {
                $bandera = false;
            }
        }
        //si el codigo existe se abre la caja
        if ($bandera) {
            $data_cash = [
                'id_user' => $id_user,
                'starting_amount' => $_POST['monto'],
                'date_start' => $date,
                'final_amount' => 0,
                'status_caja' => 1,
                'id_authorize' => $id,
                'name_status' => "CAJA ABIERTA",
            ];
            $id_cash = $this->cajamodel->insert($data_cash);
            $mensaje = messages($insert = 0, $id_cash);
            return $mensaje;
        } else {

            $data = [
                "status" => 400,
                "msg" => "CODIGO INCORRECTO"
            ];
            return $this->respond($data);
        }
    }

    public function status_lab(){
        $request = \Config\Services::request();
        $model_status = model('App\Models\Catalogos\Laboratorio\Status_lab');
        $name_status = $model_status->select('name')->where('id', $request->getPost('status_lab'))->find();

        $data = [
           'show_cotization' => 1
        ];

        $this->cotizacion->update($request->getPost('id'), $data);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        if($affected_rows){
            $data = [
                "status" => 200,
                "msg" => "AUTORIZACIÓN PENDIENTE"
            ];
        } else {
            $data = [
                "status" => 400,
                "msg" => "HUBO UN ERROR, INTENTE DE NUEVO"
            ];
        }
        return $this->respond($data);
    }

    public function ticket($id){
        $uri = service('uri');
        $id_cotizacion = $uri->getSegment(5);
        $model_cot_x_product = model('App\Models\Model_cotization_product\cotization_product ');
        $token = password_hash($id_cotizacion, PASSWORD_DEFAULT);
        $array = ["/", "."];
        $codigo_qr = str_replace($array, "&", $token);
        $data_up = [
            'codigo_qr' => $codigo_qr
        ];

        $this->cotizacion->update($id_cotizacion, $data_up);
        $affected_rows = $this->db->affectedRows();

        if($affected_rows){
            $data['productos'] = $model_cot_x_product->readCotizations($id_cotizacion);
            $data['pagos'] = $this->model->show($id_cotizacion);
            $data['cotizacion'] = $this->cotizacion->getDatos($id_cotizacion);
            $data['total'] = $model_cot_x_product->get_total($id_cotizacion);            
        } else {
            $data = [
                "status" => 400,
                "msg" => "HUBO UN ERROR, INTENTE DE NUEVO"
            ];
        }

        return $this->respond($data);
    }
}
