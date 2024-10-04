<?php

namespace App\Controllers\Catalogos;
use App\Controllers\BaseController;

class Tipo_Procedimientos extends BaseController{

    public function index(){
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //variables
        $controller = "Api/Catalogos/Tipo_Procedimientos";
        $data_header['title'] = "Tipos de procedimientos";
        $data_header['description'] = "Listado de procedimientos odontologicos, psicologicos, nutricionales o general";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/back-office/page/procedimientos-en-citas";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/CRUD.js", "Catalogos/Tipos_Procedimientos.js"
        ];
        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js",  
        "https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js", "https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js"
        ];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css",
        "https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.01.min.css"];
        // Styles css
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css", "../lib/datatables/jquery.dataTables.css", "tablas.css"];
       
        //Views
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Catalogos/Tipos_Procedimientos');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);

    }
}
