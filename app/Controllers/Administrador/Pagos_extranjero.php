<?php

namespace App\Controllers\Administrador;
use App\Controllers\BaseController;

class Pagos_extranjero extends BaseController
{

    public function index()
    {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //Js Scripts ['script1.js' , 'script2.js' , 'script3.js']
        $data_fotter['scripts'] = ["../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js", "dashboard.js", "Administrador/Pagos_extranjero.js","Generales/Accesos.js"];

        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css",  "../lib/datatables/jquery.dataTables.css"];

        //Database
        $data_header['title'] = "Pagos al extranjero";
        $data_header['description'] = "Listado de pagos al extranjero";
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Pagos_extranjero/Pagos_extranjero_view');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }

    public function get_products($id_proveedor){
        $model = model('App\Models\Model_Products\Model_Products');
        $data = $model->get_products($id_proveedor);
        return json_encode($data);
        

    }

    public function insert_pago(){
        $model = model('App\Models\Administrador\Model_pagos_ext');
        $request = \Config\Services::request();
        $path = '../public/Pagos_extranjero/';
        $arr = array("$",",");
        $tipo_cambio = str_replace($arr, "", $request->getPost('tipo_cambio')); 
        $pesos =  str_replace($arr, "", $request->getPost('pesos'));
        $usd = str_replace($arr, "", $request->getPost('usd_pago'));

        $file_pdf = $this->request->getFile('file_pdf');
        $newfile = $file_pdf->getRandomName();
        $file_pdf->move(WRITEPATH . $path, $newfile);
        $pdf = $file_pdf->getName();
        
        $data = [
            'fecha' => $request->getPost('fecha_pago'),
            'id_empresa' => $request->getPost('empresa'),
            'referencia' => $request->getPost('ref'),
            'banco' => $request->getPost('banco'),
            'usd' => $usd,
            'tipo_cambio' => $tipo_cambio,
            'pesos' => $pesos,
            'id_proveedor' => $request->getPost('id_proveedor'),
            'proveedor_name' => $request->getPost('proveedor'),
            'porciento' => $request->getPost('pago'),
            'id_maquina' => $request->getPost('id_maquina'),
            'maquina_name' => $request->getPost('maquina'),
            'modelo' => $request->getPost('modelo'),
            'id_cotizaticion_x_producto' => $request->getPost('id_cliente'),
            'nombre_cliente' => $request->getPost('cliente'),
            'pdf' => $pdf
        ];

        $id = $model->insert($data);
        return redirect()->to(base_url().'/Administrador/Pagos_extranjero');
    }

    public function get_pagos(){
        $model = model('App\Models\Administrador\Model_pagos_ext');
        $data['data'] = $model->get_pagos();
        echo json_encode($data); 
    }

    public function get_datos(){
        $model = model('App\Models\Administrador\Model_pagos_ext');
        $request = \Config\Services::request();
        $id = $request->getPost('id');                
        $data = $model->get_datos_uptade($id);
        return json_encode($data); 
    }

    public function update_pago(){
        $model = model('App\Models\Administrador\Model_pagos_ext');
        $request = \Config\Services::request();
        $path = '../public/Pagos_extranjero/';
        $arr = array("$",",");
        $tipo_cambio = str_replace($arr, "", $request->getPost('cambio_update')); 
        $pesos =  str_replace($arr, "", $request->getPost('pesos_update'));
        $usd = str_replace($arr, "", $request->getPost('usd_update'));
        $id = $request->getPost('id_update');
        $docs = $model->get_doc($id);

        $file_pdf = $this->request->getFile('file_pdf_up');
        if(!$file_pdf->isValid()){
            $pdf = $docs[0]['pdf'];
        } else{
            $newfile = $file_pdf->getRandomName();
            $file_pdf->move(WRITEPATH . $path, $newfile);
            $pdf = $file_pdf->getName();
        }
        
        $data = [
            'fecha' => $request->getPost('fecha_update'),
            'id_empresa' => $request->getPost('empresa_update'),
            'referencia' => $request->getPost('ref_update'),
            'banco' => $request->getPost('banco_update'),
            'usd' => $usd,
            'tipo_cambio' => $tipo_cambio,
            'pesos' => $pesos,
            'id_proveedor' => $request->getPost('id_proveedor_up'),
            'proveedor_name' => $request->getPost('proveedor_update'),
            'porciento' => $request->getPost('pago_update'),
            'id_maquina' => $request->getPost('id_maquinaup'),
            'maquina_name' => $request->getPost('maquina_update'),
            'modelo' => $request->getPost('modelo_update'),
            'id_cotizaticion_x_producto' => $request->getPost('id_cliente_up'),
            'nombre_cliente' => $request->getPost('cliente_update'),
            'pdf' => $pdf
        ];

        //var_dump($data);

        $model->update($id, $data);
        return redirect()->to(base_url().'/Administrador/Pagos_extranjero'); 
    }

    public function delete_pago(){
        $model = model('App\Models\Administrador\Model_pagos_ext');
        $request = \Config\Services::request();

        $id = $request->getPost('id_delete');
        $model->delete($id);
        return redirect()->to(base_url().'/Administrador/Pagos_extranjero');
    }
   
    
}
