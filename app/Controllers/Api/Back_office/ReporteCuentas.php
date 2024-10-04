<?php 
/*Desarrollador: Airam V. Vargas López
Fecha de creacion: 13 de noviembre de 2023
Fecha de Ultima Actualizacion: 30 de enero de 2024 -  Airam Vargas
Perfil: Back Office
Descripcion: Api de los reportes a realizar*/ 

namespace App\Controllers\Api\Back_office;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');

class ReporteCuentas extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;
    var $abonoTotal;
    var $payments;
    var $pagos_x_abonos;

    public function __construct() { //Assign global variables
        $this->db = db_connect();
        $this->model = new \App\Models\Back_office\Reportes\AbonosIndividuales();
        $this->abonoTotal = new \App\Models\Back_office\Reportes\AbonosTotales();
        $this->payments = new \App\Models\Model_cotizacion\Model_pagos();
        $this->pagos_x_abonos = new \App\Models\Back_office\Reportes\Pagos_x_abonos();
        helper('messages');
    }

    //Guardar abonos individuales, hacer calculo de los 
    public function insertAbonos(){
        $request = \Config\Services::request();
        $id_empresa = $request->getPost('empresa');
        $count = $this->abonoTotal->selectCount('id_company')->where('id_company', $id_empresa)->find()[0]['id_company'];
        $path = "uploads/back_office/comprobante_pago";
        
        //Archivo comprobante del pago
        $comprobante = $this->request->getFile('comprobante');

        if(!$comprobante->isValid()){
            $file_comprobante = "";
        } else{
            $comprobante->move($path, $comprobante->getRandomName());
            $file_comprobante = $comprobante->getName();
        }

        $data = [
            'id_company' => $id_empresa,
            'abono' => $request->getPost('abono'),
            'concepto' => $request->getPost('concepto'),
            'c_fecha' => $request->getPost('fecha'),
            'medio_pago' => $request->getPost('medio_pago'),
            'comprobante' => $file_comprobante
        ];

        $id = $this->model->insert($data);
        if($id){
            if($count == 0){
                $data_abono = [
                    'id_company' => $id_empresa,
                    'total_abonos' => $request->getPost('abono'),
                    'total_residuo' => 0
                ];
                $id_total = $this->abonoTotal->insert($data_abono);
            } else {
                $datos = $this->abonoTotal->select('id, total_abonos')->where('id_company', $id_empresa)->find()[0];
                $total = $this->model->selectSum('abono')->where('id_company', $id_empresa)->find()[0];

                $data_abono = [
                    'total_abonos' => $total['abono'],
                ];
                $this->abonoTotal->update($datos['id'], $data_abono);
            }
            $affected_rows = $this->db->affectedRows();
            if ($affected_rows) {
                $data = [
                    "status" => 200,
                    "msg" => "AGREGADO CON EXITO"
                ];
                return $this->respond($data);
            } else {
                $data = [
                    "status" => 400,
                    "msg" => "ERROR EN EL SERVIDOR"
                ];
                return  $this->respond($data);
            }
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return  $this->respond($data);
        }        
    }

    //FUNCION PARA DATATABLE ABONOS X EMPRESA
    public function readAbonos(){
        $data['data'] = $this->abonoTotal->getCompany();
        return $this->respond($data);
    }

    //FUNCION PARA DATATABLE ABONOS INDIVIDUALES DE CADA EMPRESA
    public function readIndividuales(){
        $id_company = $_POST['id_company'];
        $data['data'] = $this->model->getAbonos($id_company);
        return $this->respond($data);
    }

    //Obtener datos del abono para editarlo
    public function getIndividual(){
        $uri = service('uri');
        $id_abono = $uri->getSegment(5);
        $data = $this->model->getIndividual($id_abono);
        return $this->respond($data);
    }

    //Editar los valores del abono
    public function updateAbonos(){
        $request = \Config\Services::request();
        $id_empresa = $request->getPost('id_company');
        $total_deuda = $this->payments->selectSum('amount')->join('cotization', 'cotization.id = payments.id_cotization')->join
            ('cat_conventions', 'cat_conventions.id = cotization.id_conventions')->where('cat_conventions.id_cat_company_client', 
            $id_empresa)->where('payments.id_payment_type', PENDIENTE_T)->find()[0];
        //id_payment_type = 5 para la base en produccion
        
        $data = [
            'concepto' => $request->getPost('concepto'),
            'medio_pago' => $request->getPost('medio_pago')
        ];

        $this->model->update($request->getPost('id_update'), $data);

        $datos = $this->abonoTotal->select('id')->where('id_company', $id_empresa)->find()[0];
        $sumaAbonos = $this->model->selectSum('abono')->where('id_company', $id_empresa)->find()[0];

        $data_abono = [
            'total_abonos' => $sumaAbonos['abono']
        ];
        $this->abonoTotal->update($datos['id'], $data_abono);
        
        $affected_rows = $this->db->affectedRows();
        if ($affected_rows) {
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
            return  $this->respond($data);
        }
    }

    //Eliminar abono
    public function deleteAbonos(){
        $request = \Config\Services::request();
        $id = $request->getPost('id_abono');
        $id_company = $this->model->select('id_company')->where('id', $id)->find()[0]['id_company'];
        
        $this->model->delete($id);
        $datos = $this->abonoTotal->select('id')->where('id_company', $id_company)->find()[0];
        $sumaAbonos = $this->model->selectSum('abono')->where('id_company', $id_company)->find()[0];

        if($sumaAbonos['abono'] == 0){
            $this->abonoTotal->delete($datos['id']);
        } else {
            $data_abono = [
                'total_abonos' => $sumaAbonos['abono']
            ];
            $this->abonoTotal->update($datos['id'], $data_abono);
        }
        
        $affected_rows = $this->db->affectedRows();
        if ($affected_rows) {
            $data = [
                "status" => 200,
                "msg" => "ELIMINADO CON EXITO"
            ];
            return $this->respond($data);
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return  $this->respond($data);
        }
    }

    //Obtener el saldo existente de un abono individual
    public function getRestante(){
        $uri = service('uri');
        $id_abono = $uri->getSegment(5);
        $abonos = $this->model->select('abono')->where('id', $id_abono)->find()[0]['abono'];
        $pagos = $this->pagos_x_abonos->selectSum('monto')->where('id_abono', $id_abono)->find()[0]['monto'];
        $restante = $abonos - $pagos;
        $data = $restante;
        return $this->respond($data);
    }

    //Obtener el listado de pagos pendientes de una empresa
    public function adeudos(){
        $id_company = $_POST['id_company'];
        $data['data'] = $this->payments->adeudos($id_company);
        return $this->respond($data);
    }

    //Obtener el listado de adeudos que fueron pagados con los abonos individuales
    public function pagados(){
        $id_abono = $_POST['id_abono'];
        $data['data'] = $this->pagos_x_abonos->pagados($id_abono);
        return $this->respond($data);
    }

    //Se modifica el estatus del adeudo, puede ser un pago completo o parcial
    public function pagarAdeudos(){
        $request = \Config\Services::request();
        $id_abono = $request->getPost('id_abono');
        $pagos = json_decode($request->getPOST('pagos'));
        $abonos = $this->model->select('abono')->where('id', $id_abono)->find();
        $pagos_r = $this->pagos_x_abonos->selectSum('monto')->where('id_abono', $id_abono)->find()[0]['monto'];
        $abono_monto = $abonos[0]['abono'] - $pagos_r;
        $sobrante = 0;
        $total = 0;

        foreach($pagos as $key){
            $monto_pago = $this->payments->select('amount')->where('id', $key->folio)->find()[0]['amount'];
            if($key->adeudo == null){
                $newAmount = $key->total;
            } else {
                $newAmount = $key->adeudo;
            }
            
            if($sobrante == 0){
                if($abono_monto >= $newAmount){
                    $sobrante = $abono_monto - $newAmount;
                    if($sobrante < 0){
                        $pago = $total + 0;
                    } else{
                        $pago = $total + $newAmount;
                    }
                }else {
                    $resta = $newAmount - $abono_monto;
                    $pago = $newAmount - $resta;
                }
            } else {
                if($sobrante >= $newAmount){
                    $sobrante = $abono_monto - $total;
                    $pago = $newAmount;
                } else {
                    $resta = $newAmount - $sobrante;
                    $pago = $newAmount - $resta;
                }
            }

            $datos_abonos = [
                'id_abono' => $request->getPost('id_abono'),
                'id_payment' => $key->folio,
                'monto' => $pago
            ]; 

            $this->pagos_x_abonos->insert($datos_abonos);
            $pagado = $this->pagos_x_abonos->selectSum('monto')->where('id_payment', $key->folio)->find()[0]['monto'];
            if($monto_pago == $pagado){
                $data_pagos = [
                    'id_way_to_pay' => PAGO_GLOBAL_F,
                    'id_payment_type' => PAGO_GLOBAL_T
                ];
                $this->payments->update($key->folio, $data_pagos);
            } else {
                $data_pagos = [
                    'id_way_to_pay' => PARCIAL_F, 
                    'id_payment_type' => PARCIAL_T
                ];
                $this->payments->update($key->folio, $data_pagos);
            }
            
            $total_pagado = $this->abonoTotal->select('total_residuo, id')->where('id_company', $request->getPost('id_company'))->find()[0];
            $newPagado = $total_pagado['total_residuo'] + $pago;
            $abono_total = [
                'total_residuo' => $newPagado
            ];
             
            $this->abonoTotal->update($total_pagado['id'], $abono_total);           
        }

        $affected_rows = $this->db->affectedRows();
        if ($affected_rows) {
            $data = [
                "status" => 200,
                "msg" => "PAGADO CON ÉXITO"
            ];
            return $this->respond($data);
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return  $this->respond($data);
        }
    }

    public function pagosCotizacion(){
        $id_cotizacion = $_POST['id'];
        $data['data'] = $this->payments->pagosCotizacion($id_cotizacion);
        return $this->respond($data);
    }

    public function eliminarPago(){
        $request = \Config\Services::request();
        $id = $request->getPost('id_pago_abono');
        $id_payment = $this->pagos_x_abonos->select('id_payment')->where('id', $id)->find()[0]['id_payment'];
        $monto =  $this->pagos_x_abonos->select('monto')->where('id', $id)->find()[0]['monto'];
        $id_abono = $this->pagos_x_abonos->select('id_abono')->where('id', $id)->find()[0]['id_abono'];
        $id_company = $this->model->select('id_company')->where('id', $id_abono)->find()[0]['id_company'];
        $monto_pago = $this->payments->select('amount')->where('id', $id_payment)->find()[0]['amount'];
        
        $this->pagos_x_abonos->delete($id);
        
        $pagado = $this->pagos_x_abonos->selectSum('monto')->where('id_payment', $id_payment)->find()[0]['monto'];
        if($pagado == 0){
            $data_pagos = [
                'id_way_to_pay' => PENDIENTE_F,
                'id_payment_type' => PENDIENTE_T
            ];
            $this->payments->update($id_payment, $data_pagos);
        } else {
            $data_pagos = [
                'id_way_to_pay' => PARCIAL_F,
                'id_payment_type' => PARCIAL_T
            ];
            $this->payments->update($id_payment, $data_pagos);
        }

        $total_pagado = $this->abonoTotal->select('total_residuo, id')->where('id_company', $id_company)->find()[0];
        $newPago = $total_pagado['total_residuo'] - $monto;
        
        $abono_total = [
            'total_residuo' => $newPago
        ];
            
        $this->abonoTotal->update($total_pagado['id'], $abono_total);    

        $affected_rows = $this->db->affectedRows();
        if ($affected_rows) {
            $data = [
                "status" => 200,
                "msg" => "ELIMINADO CON ÉXITO"
            ];
            return $this->respond($data);
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return  $this->respond($data);
        }
    }

    public function cerrarPago(){
        $request = \Config\Services::request();
        $id = $request->getPost('id_pago_abono');

        $data = [
            'cerrada' => 1
        ];

        $this->pagos_x_abonos->update($id, $data);

        $affected_rows = $this->db->affectedRows();
        if ($affected_rows) {
            $data = [
                "status" => 200,
                "msg" => "PAGO CERRADO"
            ];
            return $this->respond($data);
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return  $this->respond($data);
        }

    }
}