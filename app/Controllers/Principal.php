<?php

namespace App\Controllers;
use App\Models\Access;
//helper('Acceso');

class Principal extends BaseController {
    public function index() {
        $session = session();
        //$acceso = Acceso();
        $data_fotter['scripts'] = [
            "../lib/datatables-responsive/dataTables.responsive.js", "Generales/Fetch.js",
            "principal.js"
        ];

        //External js
        $data_fotter['external_scripts'] = [
            "https://cdn.jsdelivr.net/npm/toastify-js", "https://momentjs.com/downloads/moment-with-locales.min.js", "https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js",
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
        $data_header['title'] = "Principal";
        $data_header['description'] = "Main Admin";
        echo view('header', $data_header);
        echo view('head_panel');
        echo view('Principal');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);  
    }
}
