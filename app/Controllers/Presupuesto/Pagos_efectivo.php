<?php

namespace App\Controllers\Cotizacion;

use App\Controllers\BaseController;

class Pagos_efectivo extends BaseController
{
        public function index($id = null)
        {
                helper('menu');
                $session = session();
                $model = model("\App\Models\Model_cotizacion\Model_cash_box");
                $validate =  $model->find($id);
                $validate == null ? $validate = 0 : $validate = $validate['id_user'];
                if ($validate === $session->get('unique')) {
                        $data_left['menu'] = get_menu();
                        //Js Scripts
                        $data_fotter['scripts'] = [
                                "dashboard.js", "../lib/datatables/jquery.dataTables.js",
                                "Cotizacion/Pagos_efectivo.js"
                        ];
                        //Css Shets
                        $data_header['styles'] = [
                                "starlight.css", "solimaq.css", "botones.css", "../lib/datatables/jquery.dataTables.css", "Prospectos.css",
                                "../../assets/lib/SpinKit/spinkit.css"
                        ];
                        //Database
                        $data_header['title'] = "Pagos en caja";
                        $data_header['description'] = "Pagos";
                        //api path
                        $controller = "Api/Cotizaciones/Cajas";
                        $data_fotter['controlador'] = $controller;
                        //External js
                        $data_fotter['external_scripts'] = [
                                "https://cdn.jsdelivr.net/npm/toastify-js", "https://momentjs.com/downloads/moment-with-locales.min.js",
                                "https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js", "https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js",
                                "https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"
                        ];
                        //External css//
                        $data_header['external_styles'] = [
                                "https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css",
                                "https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.01.min.css"
                        ];

                        //data
                        $data['box'] = $id;
                        echo view('header', $data_header);
                        echo view('left_panel', $data_left);
                        echo view('head_panel');
                        echo view('Cotizacion/Pagos_efectivo',$data);
                        echo view('right_panel');
                        echo view('fotter_panel', $data_fotter);
                } else {
                        return redirect()->to(base_url("Cotizacion/Cajas"));   
                }
        }
}
