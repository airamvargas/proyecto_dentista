<?php

namespace App\Controllers\OrdenServicio;

use App\Controllers\BaseController;

class Resultados extends BaseController
{
    public function index() {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();
        //Js Scripts
        $data_fotter['scripts'] = [
            "dashboard.js", "../lib/datatables/jquery.dataTables.js", "OrdenServicio/ResultadosLab.js"
        ];
        //Css Shets
        $data_header['styles'] = [
            "starlight.css", "solimaq.css", "botones.css", "../lib/datatables/jquery.dataTables.css", "Prospectos.css",
            "../../assets/lib/SpinKit/spinkit.css", "tablas.css", "resultados.css"
        ];
        //Variables
        $data_header['title'] = "Resultados de Laboratorio";
        $data_header['description'] = "Listado de pacientes que tienen disponible los resultados de estudios";
        $data_header['wiki_controller'] = "books/recepcion/page/resultados-de-laboratorio";
        //api path
        $controller = "Api/OrdenServicio/ResultadosLab";
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
        echo view('Cotizacion/Resultados_paciente');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }
}
