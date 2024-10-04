<?php

namespace App\Controllers\Catalogos;

use App\Models\Access;
use App\Controllers\BaseController;

class CondicionesConvenios extends BaseController {
    
    public function index(){
        //call to helper menu
        helper('menu');
        //method session
        $session = session();
        //api path
        $controller = "Api/Catalogos/CondicionesConvenios";
        //variables
        $data_header['title'] = "Condiciones de convenios";
        $data_header['description'] = "Convenios con los beneficios más a detalle";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/administrador/page/condiciones-de-convenio";

        //Documents javascript 
        $data_fotter['scripts'] = ["../lib/datatables/jquery.dataTables.js","../lib/datatables-responsive/dataTables.responsive.js",  "dashboard.js", "Generales/Accesos.js", "Generales/CRUD.js", "Catalogos/CondicionesConvenios.js"];
        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "../lib/datatables/jquery.dataTables.css", "botones.css", "Catalogos.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];
        //Loads Views
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel'); 
        echo view('right_panel');
        echo view('Catalogos/CondicionesConvenios');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }
   
}

?>