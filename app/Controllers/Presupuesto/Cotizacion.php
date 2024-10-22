<?php

namespace App\Controllers\Presupuesto;
use App\Controllers\BaseController;

use App\Models\Access;

class Cotizacion extends BaseController {
    public function index() {
        $session = session();
        if($session){
            //var_dump($session);
            $data_fotter['scripts'] = [
                "../lib/datatables-responsive/dataTables.responsive.js",
                "principal.js"
            ];

            //External js
            $data_fotter['external_scripts'] = [
                "https://cdn.jsdelivr.net/npm/toastify-js", "https://momentjs.com/downloads/moment-with-locales.min.js",
                "https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js", "https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js",
                "https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js",
            ];

            //External css//
            $data_header['external_styles'] = [
                "https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css",
                "https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.01.min.css"
            ];
    
            //Css Shets
            $data_header['styles'] = ["starlight.css", "botones.css", "clinica_dental.css",  "../lib/datatables/jquery.dataTables.css"];
            
            //Vars
            $data_header['title'] = "Presupuesto";
            $data_header['description'] = "Generar un presupuesto y/o cotización para un paciente";
            echo view('header', $data_header);
            echo view('head_panel');
            echo view('Presupuesto/Cotizacion');
            echo view('right_panel');
            echo view('fotter_panel', $data_fotter);
        } else{
            return redirect()->to(base_url()); 
        }
        
    }
}
