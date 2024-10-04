<?php

namespace App\Controllers\Catalogos;
use App\Controllers\BaseController;
class Payment_type extends BaseController
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
        $controller = "Api/Catalogos/Payment_type";
        //variables
        $data_header['title'] = "Tipos de pago";
        $data_header['description'] = "Catálogo de tipos de pago";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/administrador/page/tipos-de-pago";
        
        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/CRUD.js", "Catalogos/Payment_type.js"
        ];
        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js","https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css" , "../lib/datatables/jquery.dataTables.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css","https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.02.min.css"];
        //Loads Views
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Catalogos/Payment_type');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter); 
    }
}
