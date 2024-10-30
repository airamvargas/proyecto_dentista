<?php

namespace App\Controllers\Pacientes;
use App\Controllers\BaseController;

use App\Models\Access;

class Cita_actual extends BaseController {
    public function index() {
        $uri = service('uri');
        $id_cita = $uri->getSegment(4);
        $id_paciente = $uri->getSegment(5);
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
            $data_header['styles'] = ["starlight.css", "clinica_dental.css",  "../lib/datatables/jquery.dataTables.css"];
            
            //Vars
            $data_header['title'] = "Detalle de Consultas";
            $data_header['description'] = "";
            $data['id_paciente'] = $id_paciente;
            $data['id_cita'] = $id_cita;
            echo view('header', $data_header);
            echo view('head_panel');
            echo view('Pacientes/cita_actual', $data);
            echo view('right_panel');
            echo view('fotter_panel', $data_fotter);
        } else{
            return redirect()->to(base_url()); 
        }
    }
}
