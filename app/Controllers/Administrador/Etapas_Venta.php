<?php

namespace App\Controllers\Administrador;
use App\Controllers\BaseController;

class Etapas_Venta extends BaseController
{

    public function index()
    {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //Js Scripts ['script1.js' , 'script2.js' , 'script3.js']
        $data_fotter['scripts'] = ["../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js", "dashboard.js", "Administrador/Estapas_Venta.js"];

        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css"];

        //Database
        $data_header['title'] = "Etapas de venta";
        $data_header['description'] = "Estatus de las ventas";
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Administrador/Etapas_Venta');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }

    public function getEtapas(){
        $model = model('App\Models\Model_cotizacion\Cotizacion');
        $data['data'] = $model->getStatusVentas();
        return json_encode($data);
  
    }

    public function getStages(){
        $model = model('App\Models\Model_sales_stage\Sales_stage');
        $data = $model->getStages();
        return json_encode($data);
    }

    public function changeStatus(){
        $model = model('App\Models\Administrador\Status_Venta');
        $request = \Config\Services::request();
        $idcotizacion_producto = $request->getPost('id');
        $status = $request->getPost('id_status');
        $id_status = $model->select('id')->where('id_cotozation_x_product',$idcotizacion_producto)->first();

        if($id_status == null){

            $data = [
                "id_cotozation_x_product" => $idcotizacion_producto,
                "status" => $status
            ];

            $id = $model->insert($data);

            if($id){
                $response = [
                    "status" => 200,
                    "msg" => "STATUS ACTUALIZADO CON EXITO"
                ];
                return json_encode($response);
    
            }else{
                $response = [
                    "status" => 400,
                    "msg" => "ERROR AL ACTUALIZAR STATUS"
                ];
                return json_encode($response);
            }  


        }else{
            $data = [
                "status" => $status
            ];

            $regreso = $model->update($id_status['id'],$data);

            if($regreso){
                $response = [
                    "status" => 200,
                    "msg" => "STATUS ACTUALIZADO CON EXITO"
                ];
                return json_encode($response);
    
            }else{
                $response = [
                    "status" => 400,
                    "msg" => "ERROR AL ACTUALIZAR STATUS"
                ];
                return json_encode($response);
            }  
            
        }

    }


}
