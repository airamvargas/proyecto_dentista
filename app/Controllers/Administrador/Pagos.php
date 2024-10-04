<?php

namespace App\Controllers\Administrador;
use App\Controllers\BaseController;

class Pagos extends BaseController
{

    public function index()
    {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //Js Scripts ['script1.js' , 'script2.js' , 'script3.js']
        $data_fotter['scripts'] = ["../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js", "dashboard.js", "Administrador/Pagos.js", "Generales/Accesos.js"];

        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css"];

        //Database
        $data_header['title'] = "Pagos";
        $data_header['description'] = "Listado de pagos";
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Administrador/Pagos');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }

    public function addPays(){
        $model = model('App\Models\Administrador\Pagos');
        $request = \Config\Services::request();
        $path_comprobante = "../public/Pagos/Comprobante";
        $path_facturas =  '../public/Pagos/Facturas';

        $comprobante = $this->request->getFile('comprobante');
        $factura = $this->request->getFile('factura');

        //ARCHIVO COMPROBANTE//
        $nameficha = $comprobante->getRandomName();
        $comprobante->move(WRITEPATH . $path_comprobante, $nameficha);
        $nameComprobante = $comprobante->getName(); 

        //ARCHIVO FACTURA//
        $newfile = $factura->getRandomName();
        $factura->move(WRITEPATH . $path_facturas, $newfile);
        $file_name = $factura->getName(); 
        $uds = $request->getPost('uds');
        $costo = str_replace("$", "", $uds);
        $uds_new = str_replace(",", "", $costo);
        $tc = $request->getPost('tc');
        $venta = str_replace("$", "", $tc);
        $tc_new = str_replace(",", "", $venta);
        $pesos = $request->getPost('pesos');
        $pesos1 = str_replace("$", "", $pesos);
        $pesos_new = str_replace(",", "", $pesos1);

        $data = [
            "date" => $request->getPost('fecha_pago'),
            "id_cotization_x_product" => $request->getPost('cliente'),
            "concept" => $request->getPost('concepto'),
            "uds" => $uds_new,
            "tc" => $tc_new,
            "pesos" => $pesos_new,
            "porciento" => $request->getPost('porciento'),
            "banco" => $request->getPost('banco'),
            "proof_of_payment" => $nameComprobante,
            "invoice_receipt" => $file_name,
        ];

        $id = $model->insert($data);

        if($id){
            $data = [
                "status" => 200,
                "msg" => "PAGO AGREGADO CON EXITO"
            ];
            return json_encode($data);

        }else{
            $data = [
                "status" => 400,
                "msg" => "ERROR AL AGREGAR PAGO"
            ];
            return json_encode($data);
        }  
    }



    public function get_clientes(){
        $model = model('App\Models\Model_cotizacion\Cotizacion',false);;
        $data =  $model->getPagosClientes();
        return json_encode($data);
    
    }

  /*   public function getMaquina($id = null){
      
        $model = model('App\Models\Model_Products\Model_Products');
        //var_dump($model);
        $data = $model->where('business_id',$id)->findAll();
        return json_encode($data); 
     
    } */

    public function getPagos(){
        $model = model('App\Models\Administrador\Pagos');
        $data["data"] = $model->getPagos();
        return json_encode($data);
       
    }

  /*   public function getPago(){
        $request = \Config\Services::request();
        $model = model('App\Models\Administrador\Pagos');
        $id = $request->getPost('id');
        $data['pagos'] = $model->where('id',$id)->first();

        $model = model('App\Models\Model_Products\Model_Products');
        $data['productos'] = $model->where('business_id',$data['pagos']['id_bussiness'])->findAll();
        return json_encode($data); 
    } */

    public function updatePago(){
        $model = model('App\Models\Administrador\Pagos');
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $path_comprobante = "../public/Pagos/Comprobante/";
        $path_facturas =  '../public/Pagos/Facturas/';

        $comprobante = $this->request->getFile('comprobante');
        $factura = $this->request->getFile('factura');

        if(!$comprobante->isValid()){
            $name_comprobante = $request->getPost('name_comprobante');
        } else{
            if($request->getPost('name_comprobante') == " "){
                $newName = $comprobante->getRandomName();
                $comprobante->move(WRITEPATH.$path_comprobante, $newName);
                $name_comprobante = $comprobante->getName();  

            }else{
                $file_old = $path_comprobante.$request->getPost('name_comprobante');
                unlink($file_old);
                $newName = $comprobante->getRandomName();
                $comprobante->move(WRITEPATH.$path_comprobante, $newName);
                $name_comprobante = $comprobante->getName();  

            }
        }

       if(!$factura->isValid()){
            $name_factura = $request->getPost('name_facturas');
        } else{
            if($request->getPost('name_facturas')== " "){
                $newName = $factura->getRandomName();
                $factura->move(WRITEPATH.$path_facturas, $newName);
                $name_factura = $factura->getName(); 

            }else{
                
                $factura_old = $path_facturas.$request->getPost('name_facturas');
                unlink($factura_old);
                $newName = $factura->getRandomName();
                $factura->move(WRITEPATH.$path_facturas, $newName);
                $name_factura = $factura->getName(); 
            }

        }

        $uds = $request->getPost('uds');
        $costo = str_replace("$", "", $uds);
        $uds_new = str_replace(",", "", $costo);

        $tc = $request->getPost('tc');
        $venta = str_replace("$", "", $tc);
        $tc_new = str_replace(",", "", $venta);

        $pesos = $request->getPost('pesos');
        $pesos1 = str_replace("$", "", $pesos);
        $pesos_new = str_replace(",", "", $pesos1);

        $data = [
            "date" => $request->getPost('fecha_pago'),
            "id_cotization_x_product" => $request->getPost('cliente'),
            "concept" => $request->getPost('concepto'),
            "uds" => $uds_new,
            "tc" => $tc_new,
            "pesos" => $pesos_new,
            "porciento" => $request->getPost('porciento'),
            "banco" => $request->getPost('banco'),
            "proof_of_payment" => $name_comprobante,
            "invoice_receipt" => $name_factura,
        ];

        $model->update($id,$data);

        if($model){
            $response = [
                "status" => 200,
                "msg" => "PAGO ACTUALIZADO CON EXITO"
            ];
            return json_encode($response);

        }else{
            $response = [
                "status" => 400,
                "msg" => "ERROR AL ACTUALIZAR PAGO"
            ];
            return json_encode($response);
        }  
    }

    public function deletePago(){
        $model = model('App\Models\Administrador\Pagos');
        $request = \Config\Services::request();
        $id = $request->getPost('id_delete');
        $model->delete($id);
        if($model){
            $data = [
                "status" => 200,
                "msg" => "PAGO ELIMINADO CON EXITO"
            ];
            return json_encode($data);

        }else{
            $data = [
                "status" => 400,
                "msg" => "ERROR AL ELIMINAR PAGO"
            ];
            return json_encode($data);
        } 
        
    }

    public function getCompra(){
        $model = model('App\Models\Model_cotization_product\cotization_product');
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $data = $model->getCompras($id);
        return json_encode($data);
    }

    public function getPago(){
        $request = \Config\Services::request();
        $model = model('App\Models\Administrador\Pagos');
        $id = $request->getPost('id');
        $data = $model->getPago($id);
        return json_encode($data);

    }

    public function deleteFiles(){
        $model = model('App\Models\Administrador\Pagos');
        $request = \Config\Services::request();
        $path_comprobante = "../public/Pagos/Comprobante/";
        $path_facturas =  '../public/Pagos/Facturas/';
        $id = $request->getPost('id_delete');
        $tipo = $request->getPost('tipo');
        $nombre = $request->getPost('name');

        if($tipo == "0"){
            $file_old = $path_comprobante.$nombre;
            unlink($file_old);

            $data = [
                "proof_of_payment" => " ",
            ];

            $model->update($id,$data);

            if($model){
                $response = [
                    "status" => 200,
                    "msg" => "ARCHIVO BORRADO CON EXITO"
                ];
                return json_encode($response);
    
            }else{
                $response = [
                    "status" => 400,
                    "msg" => "ERROR AL BORRAR ARCHIVO"
                ];
                return json_encode($response);
            }  
           
        }else{
            $factura_old = $path_facturas.$nombre;
            unlink($factura_old);
            
            $data = [
                "invoice_receipt" => " ",
            ];

            $model->update($id,$data);

            if($model){
                $response = [
                    "status" => 200,
                    "msg" => "ARCHIVO BORRADO CON EXITO"
                ];
                return json_encode($response);
    
            }else{
                $response = [
                    "status" => 400,
                    "msg" => "ERROR AL BORRAR ARCHIVO"
                ];
                return json_encode($response);
            }  

        }

    }
    
}
