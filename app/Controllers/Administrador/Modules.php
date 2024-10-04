<?php

namespace App\Controllers\Administrador;
use App\Controllers\BaseController;
use App\Models\Administrador\Modules as model;


class Modules extends BaseController
{
    var $model;
    
    public function __construct()
    {
        $this->model = new model();
        
    }

    public function index()
    {
        //call to helper menu
        helper('menu');
        //metod session
        $session = session();
        //api path
        $controller = "Api/Administrador/Modules";
        //variables
        $data_header['title'] = "MODULOS";
        $data_header['description'] = "Catálogo de modulos webcop";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/CRUD.js", "Administrador/Modules/Modules.js"
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
        echo view('Administrador/Modules/Modules');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter); 
    }

    public function modules($id){
        //model 
        $model = model('App\Models\Administrador\Groups_modules');
        $data['data'] = $model->getData($id);
        helper('menu');
        //metod session
        $session = session();
        //api path
        $controller = "Api/Administrador/Modules";
        //variables
        $data_header['title'] = "MODULOS DE ".$data['data'][0]['name'];
        $data_header['description'] = $data['data'][0]['description'];
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/CRUD.js", "Administrador/Modules/Module.js"
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
        echo view('Administrador/Modules/Module',$data);
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter); 

    }
}
