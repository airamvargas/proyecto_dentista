<?php

namespace App\Controllers\Catalogos;
use App\Controllers\BaseController;

class Tratamientos extends BaseController
{

    public function index() {
        $session = session();

        //variables
        $data_header['title'] = "Tratamientos";
        $data_header['description'] = "Listado de tratamientos que pueden ser realizados";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/Fetch.js",  "Catalogos/Procedimientos.js"
        ];

        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js",  
        "https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js", "https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js"
        ];

        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css",
        "https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.01.min.css"];
        
        $data_header['styles'] = ["starlight.css", "botones.css", "clinica_dental.css", "Importaciones.css",  "../lib/datatables/jquery.dataTables.css"];
       
        //Database
        echo view('header', $data_header);
        echo view('head_panel');
        echo view('Catalogos/Procedimientos');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);

    }
}
