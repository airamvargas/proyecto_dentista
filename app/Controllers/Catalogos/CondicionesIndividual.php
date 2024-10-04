<?php

namespace App\Controllers\Catalogos;

use App\Models\Access;
use App\Controllers\BaseController;

class CondicionesIndividual extends BaseController{

    //Condiciones de convenios individual
    public function individual($id=null){
        //call to helper menu
        helper('menu');
        //metod session
        $session = session();
        //api path
        $controller = "Api/Catalogos/CondicionesConvenios";
        //variables
        $model_nombre = model('App\Models\Catalogos\Convenios');
        $nombre = $model_nombre->nameConvenio($id);

        $data['nombre'] = $nombre[0]['name'];
        $data['id'] = $id;
         
        $data_header['title'] = "Condiciones del convenio ". $data['nombre'];
        $data_header['description'] = "Datos del convenio " . $data['nombre'];
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/administrador/page/convenios";


        //Documents javascript 
        $data_fotter['scripts'] = ["../lib/datatables/jquery.dataTables.js","../lib/datatables-responsive/dataTables.responsive.js",  "dashboard.js", "Generales/Accesos.js", "Generales/CRUD.js",
        "Catalogos/CondicionesIndividual.js"];
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
        echo view('Catalogos/CondicionesIndividual',$data);
        echo view('fotter_panel', $data_fotter);        
    }
}
