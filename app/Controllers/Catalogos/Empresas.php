<?php

namespace App\Controllers\Catalogos;

use App\Models\Access;
use App\Controllers\BaseController;

class Empresas extends BaseController{

    public function index(){
        //call to helper menu
        helper('menu');
        //metod session
        $session = session();
        //api path
        $controller = "Api/Catalogos/Empresas";
        //variables
        $data_header['title'] = "Empresas por convenios";
        $data_header['description'] = "Empresas de clientes";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/administrador/page/empresas";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js",
            "../lib/datatables-responsive/dataTables.responsive.js", 
            "dashboard.js", "Generales/Accesos.js", 
            "Generales/CRUD.js", 
            "Catalogos/Empresas.js" 
        ];
        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "../lib/datatables/jquery.dataTables.css", "botones.css", "Catalogos.css"]; 
        //External css
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];
        //Loads Views
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('right_panel');
        echo view('Catalogos/Empresas');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }
}
