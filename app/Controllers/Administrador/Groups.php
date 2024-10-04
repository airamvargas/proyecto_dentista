<?php

namespace App\Controllers\Administrador;
use App\Controllers\BaseController;
class Groups extends BaseController
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
        $controller = "Api/Administrador/Groups";
        //variables
        $data_header['title'] = "PERFILES";
        $data_header['description'] = "Catálogo de perfiles Webcorp";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/CRUD.js", "Administrador/Groups.js"
        ];
        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js","https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css" ,"botones.css", "../lib/datatables/jquery.dataTables.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css","https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.02.min.css"];
        //Loads Views
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Administrador/Groups');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter); 
    }
}
