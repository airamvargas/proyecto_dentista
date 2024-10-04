<?php

namespace App\Controllers\Catalogos;
use App\Controllers\BaseController;

class ChronicDesseases extends BaseController
{

    public function index()
    {
        
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //variables
        $controller = "Api/Catalogos/ChronicDesseases";
        $data_header['title'] = "Padecimientos Cronicos";
        $data_header['description'] = "Catálogo de padecimientos cronicos";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/CRUD.js",  "Catalogos/ChronicDesseases.js"
        ];
        
        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css",  "../lib/datatables/jquery.dataTables.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];

        //Database
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Catalogos/ChronicDesseases');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);

    }
}