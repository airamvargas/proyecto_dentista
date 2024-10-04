<?php

namespace App\Controllers\Administrador;
use App\Controllers\BaseController;

class Cotizacion extends BaseController
{

    public function index()
    {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();
        //Js Scripts ['script1.js' , 'script2.js' , 'script3.js']
        $data_fotter['scripts'] = ["../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js", "Generales/Accesos.js", "Cotizacion/Busqueda.js"];

        //Css Shets
        $data_header['styles'] = ["starlight.css", "clinica_dental.css"];

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

        //Database
        $data_header['title'] = "Cotización";
        $data_header['description'] = "";
        echo view('header', $data_header);
        //echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Administrador/Cotizacion');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }
}
