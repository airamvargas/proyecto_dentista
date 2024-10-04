<?php

namespace App\Controllers\Cotizacion;

use App\Controllers\BaseController;
use BaconQrCode\Common\Mode;

require_once __DIR__ . '../../vendor/autoload.php';

class Cajas extends BaseController
{
        public function index()
        {
                helper('menu');
                $session = session();
                $data_left['menu'] = get_menu();
                //Js Scripts
                $data_fotter['scripts'] = [
                        "dashboard.js", "../lib/datatables/jquery.dataTables.js",
                         "Cotizacion/Cajas.js"
                ];
                //Css Shets
                $data_header['styles'] = [
                        "starlight.css", "solimaq.css", "botones.css", "../lib/datatables/jquery.dataTables.css", "Prospectos.css",
                        "../../assets/lib/SpinKit/spinkit.css"
                ];
                //Variables
                $data_header['title'] = "Cajas";
                $data_header['description'] = "Listado de cajas";
                $data_header['wiki_controller'] = "books/recepcionista-de1/page/cajas";
                //api path
                $controller = "Api/Cotizaciones/Cajas";
                $data_fotter['controlador'] = $controller;
                //External js
                $data_fotter['external_scripts'] = [
                        "https://cdn.jsdelivr.net/npm/toastify-js", "https://momentjs.com/downloads/moment-with-locales.min.js",
                        "https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js", "https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js"
                ];
                //External css//
                $data_header['external_styles'] = [
                        "https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css",
                        "https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.01.min.css"
                ];
                echo view('header', $data_header);
                echo view('left_panel', $data_left);
                echo view('head_panel');
                echo view('Cotizacion/Cajas');
                echo view('right_panel');
                echo view('fotter_panel', $data_fotter);
        }

        public function reciboPdf($id){
                //Model de caja 
                $model_cash = model("App\Models\Model_cotizacion\Model_cash_box");
                $model_pagos = model("App\Models\Model_cotizacion\Model_pagos");
                $model_logo = model("App\Models\Company_data\Company_data");
                $logo = $model_logo->asArray()->find();
                $data['logo'] = $logo[0]['logo'];
                $data['caja'] = $model_cash->getCash($id);
                $data['pagos'] = $model_pagos->getPaymentsbox($id);
                $filename = "recibo.pdf";
                $response = service('response');
                $response->setHeader('Content-type', ' application/pdf');
                $mpdf = new \Mpdf\Mpdf();
                //$mpdf->shrink_tables_to_fit=1;
                $mpdf->WriteHTML($this->impreso($data));
                $mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD); 

        }

        public function impreso($data){
                return view('Cotizacion/Recibo_cajas', $data);

        }
}
