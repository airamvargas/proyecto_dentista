<?php

namespace App\Controllers\Catalogos;
use App\Controllers\BaseController;

class Consultas extends BaseController
{

    public function index()
    {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //variables
        $controller = "Api/Catalogos/Consultas/Consultas_medicas";
        $data_fotter['controlador'] = $controller;
        $data_header['title'] = "Consultas médicas";
        $data_header['description'] = "Catálogo de consultas médicas existentes";
        $data_header['wiki_controller'] = "books/administrador/page/consultas-medicas";

        //Js Scripts ['script1.js' , 'script2.js' , 'script3.js']
        $data_fotter['scripts'] = ["../lib/datatables/jquery.dataTables.js", 
            "../lib/datatables-responsive/dataTables.responsive.js", "dashboard.js", "Generales/CRUD.js",
            "Catalogos/Consultas.js","Generales/Accesos.js"
        ];

        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "botones.css", "../../assets/lib/datatables/jquery.dataTables.css", "tablas.css"];

        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js", "https://unpkg.com/currency.js@2.0.4/dist/currency.min.js",
        "https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js"];
        
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css", "https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.01.min.css"];

        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Catalogos/Consultas');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }
    

}
