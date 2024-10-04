<?php

namespace App\Controllers\Api\Cotizaciones;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');
class Cajas extends ResourceController
{
    use ResponseTrait;
    var $goup;
    var $users;
    var $cajamodel;
    var $db;

    public function __construct()
    { //Assign global variables
        $this->db = db_connect();
        $this->goup = new \App\Models\Administrador\Groups();
        $this->users = new \App\Models\Administrador\Usuarios();
        $this->cajamodel = new \App\Models\Model_cotizacion\Model_cash_box();
        helper('messages');
    }
    //FUNCION PARA DATATABLE
    public function Index()
    {
        $session = session();
        $id_group = $session->get('group');
        $id_user = $session->get('unique');
        $jerarquia = $this->goup->find($id_group);
        $jerarquia = $jerarquia['hierarchy'];
        //validamos la existencia de la caja
        $validate = $this->validateCode($_POST, $jerarquia, $id_user);
        return $this->respond($validate);
    }

    public function validateCode($metodo, $jerarquia, $id_user)
    {
        $fecha_hoy = date('Y-m-d');
        $caja_active =  $this->cajamodel->findCash($id_user);
        //revisamos si existe una caja con el usuario de reprcion
        if (empty($caja_active)) {
            $code_jeraquia = $this->users->getCode($jerarquia);
            $bandera = false;
            $id = null;
            //buscamos el codigo introducido si existe
            foreach ($code_jeraquia as $key) {
                if ($metodo['code'] == $key['code']) {
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
                    'starting_amount' => $metodo['monto'],
                    'date_start' => $fecha_hoy,
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
                return $data;
            }
        } else {
            $data = [
                "status" => 400,
                "msg" => "YA EXISTE UNA CAJA ABIERTA"
            ];
            return $data;
        }
    }
    public function redDatatable()
    {
        $session = session();
        $id_user = $session->get('unique');
        $data["data"] = $this->cajamodel->readChashbox($id_user);
        return $this->respond($data);
    }

    public function closeBox()
    {
        $session = session();
        $id_group = $session->get('group');
        $id_user = $session->get('unique');
        $jerarquia = $this->goup->find($id_group);
        $jerarquia = $jerarquia['hierarchy'];
        $code_jeraquia = $this->users->getCode($jerarquia);
        $bandera = false;
        $id = null;
        $remplace = array("$", ",");
        $monto_final = str_replace($remplace, "", $_POST['final']);

        switch ($_POST['status']) {
            case 2:
                $name_status = "CIERRE DE CAJA";
                break;
            case 3:
                $name_status = "ARQUEO DE CAJA";
                break;
        }

        //BUSCAMOS EL CODIGO 
        foreach ($code_jeraquia as $key) {
            //COMPARAMOS EL CODIGO  DEL USUARIO SI EXISTE
            if ($_POST['code'] == $key['code']) {
                $id = $key['id'];
                $bandera = true;
                break;
            } else {
                $bandera = false;
            }
        }

        if ($bandera) {
            if ($_POST['status'] == 3) {
                $inicio_caja = str_replace($remplace, "", $_POST['resta']);

                $data_cash =
                    [
                        'status_caja' => 2,
                        'name_status' => $name_status,
                        'id_close_authorization' => $id,
                        'date_close' =>  date('Y-m-d'),
                        'final_amount' => $monto_final
                    ];

                $this->cajamodel->update($_POST['id_delete'], $data_cash);
                $affected_rows = $this->db->affectedRows();

                if ($affected_rows > 0) {
                    $data_cash = [
                        'id_user' => $id_user,
                        'starting_amount' => $inicio_caja,
                        'date_start' => date('Y-m-d'),
                        'final_amount' => 0,
                        'status_caja' => 1,
                        'id_authorize' => $id,
                        'name_status' => "APERTURA POR ARQUEO",
                    ];
                    $id_cash = $this->cajamodel->insert($data_cash);
                    $mensaje = messages($insert = 0, $id_cash);
                    return $mensaje;
                }
            } else {
                $data_cash =
                    [
                        'status_caja' => 2,
                        'name_status' => $name_status,
                        'id_close_authorization' => $id,
                        'date_close' =>  date('Y-m-d'),
                        'final_amount' => $monto_final
                    ];

                $this->cajamodel->update($_POST['id_delete'], $data_cash);
                $affected_rows = $this->db->affectedRows();
                $mensaje = messages($update = 1, $affected_rows);
                return $this->respond($mensaje);
            }

        } else {
            $data = [
                "status" => 400,
                "msg" => "CODIGO INCORRECTO"
            ];
            return $this->respond($data);
        }
    }
}
