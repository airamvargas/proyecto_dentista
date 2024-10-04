<?php

namespace App\Controllers\Catalogos;
use App\Controllers\BaseController;
class Waytopay extends BaseController
{
    
    public function __construct()
    {
        
    }

    public function index()
    {
        //call to helper menu
        helper('menu');
        //metod session
        $session = session();
        //api path
        $controller = "Api/Waytopay";
        //variables
        $data_header['title'] = "Forma de pago";
        $data_header['description'] = "Catálogo de formas de pago";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/administrador/page/formas-de-pago";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "Generales/CRUD.js", "Catalogos/Waytopay.js",'Generales/Notificaciones.js'
        ];
        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "../lib/datatables/jquery.dataTables.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];
        //Loads Views
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Catalogos/Waytopay');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter); 
    }
}
