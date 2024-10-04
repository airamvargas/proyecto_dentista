<?php

namespace App\Controllers\Catalogos;

use App\Models\Access;
use App\Controllers\BaseController;

class ConveniosEmpresas extends BaseController{

    //CONVENIOS POR EMPRESA
    public function convenios($id=null){
        //call to helper menu
        helper('menu');
        //metod session
        $session = session();
        //api path
        $controller = "Api/Catalogos/Convenios";
        //variables
        $model_nombre = model('App\Models\Catalogos\Empresas');
        $nombre = $model_nombre->nameEmpresa($id);
        $data['nombre'] = $nombre[0]['name'];
        $data['id'] = $id; 
        $data_header['title'] = "Convenios de la empresa ". $data['nombre'];
        $data_header['description'] = "Datos de los convenios de la empresa " . $data['nombre'];
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/back-office/page/convenios-de-empresas";

        //Documents javascript 
        $data_fotter['scripts'] = ["../lib/datatables/jquery.dataTables.js","../lib/datatables-responsive/dataTables.responsive.js", "dashboard.js", "Generales/Accesos.js", 
        "Generales/CRUD.js", 
        "Catalogos/ConveniosEmpresas.js"];
        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js", "https://momentjs.com/downloads/moment-with-locales.min.js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "../lib/datatables/jquery.dataTables.css", "Catalogos.css", "botones.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];
        //Loads Views
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('right_panel');
        echo view('Catalogos/ConveniosEmpresas',$data);
        echo view('fotter_panel', $data_fotter);         
    }
}
