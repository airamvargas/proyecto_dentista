<?php

namespace App\Controllers\OrdenServicio;
use App\Controllers\BaseController;
use Mockery;
use Mpdf\QrCode\QrCode;


require_once __DIR__ . '../../vendor/autoload.php';

class Pendientes extends BaseController {

    public function index() {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //variables
        $controller = "Api/OrdenServicio/Pendientes";
        $data_header['title'] = "Ordenes de servicio pendientes";
        $data_header['description'] = "Listado de ordenes que servicio que siguen pendientes";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/recepcionista-de1/page/pendientes";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js", "Generales/CRUD.js",  "OrdenServicio/Pendientes.js"
        ];

        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js", "https://momentjs.com/downloads/moment-with-locales.min.js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css", "botones.css", "../lib/datatables/jquery.dataTables.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];

        //Database
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('OrdenServicio/Pendientes');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);

    }

    public function imprimir($id){
        $model_productos = model('App\Models\Model_cotization_product\cotization_product');
        $model_cotizacion = model('App\Models\Model_cotizacion\Cotizacion');
        $model_company = model('App\Models\Company_data\Company_data');
        $model_pagos = model('App\Models\Model_cotizacion\Model_pagos');

        if($model_cotizacion->select('id_company_data')->where('id',$id)->find()[0]['id_company_data'] !=0){
            $data['company'] = $model_cotizacion->getCompany($id);
        }else{
            $data['company']=$model_company->getConpany();
        }

        $data['whats'] = $data['company'][0]['whatsapp'] == "" ? "" : "Whatsapp: ".$data['company'][0]['whatsapp'];

        $datos_user = $model_cotizacion->readCliente($id);
        $data['productos'] = $model_productos->readCotizations($id);
        $data['cliente'] = $model_cotizacion->readCliente($id);
        $data['total'] = $model_productos->get_total($id);
        $data['cotizacion'] = $id;
        $pagos = $model_pagos->show($id);
        $qrCode = $data['cliente'][0]->codigo_qr;
        
        //CREAR UN DOCUMENTO PDF CON MPDF
        $response = service('response');
        $response->setHeader('Content-type', ' application/pdf');
        $mpdf = new \Mpdf\Mpdf(['format' => [150, 215], 'orientation' => 'L']);
        foreach ($pagos as $key) {
            if($key->forma_pago == "PENDIENTE"){
                $mpdf->SetWatermarkText('PAGADO'); 
            }
        }
        
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->showWatermarkText = true;
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->setAutoTopMargin  = 'stretch';
        $mpdf->setAutoBottomMargin  = 'stretch';
        //$mpdf->output($qrCode, $mpdf, 0,0,0);
        $mpdf->WriteHTML($this->impreso($data)); 
        $mpdf->Output();
    }

    public function impreso($data)
    {
        return view('Cotizacionpdf/Ordenpdf',$data);
    }
}
