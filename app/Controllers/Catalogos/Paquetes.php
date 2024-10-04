<?php

namespace App\Controllers\Catalogos;
use App\Controllers\BaseController;

class Paquetes extends BaseController
{

    public function index() {
        
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //variables
        $controller = "Api/Catalogos/Paquetes";
        $data_header['title'] = "PAQUETES";
        $data_header['description'] = "Listado de grupos de estudios a realizar, con precio y preparación ";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/administrador/page/paquetes";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/CRUD.js",  "Catalogos/Paquetes.js"
        ];

        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js", "https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css", "botones.css", "../lib/datatables/jquery.dataTables.css", "tablas.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];

        //Database
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Catalogos/Paquetes');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);

    }

    public function add_studies($id) {
        
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //obtener nombre del estudio
        $model_insumos= model('App\Models\Catalogos\Insumos');
        $packet = $model_insumos->select('id_product, name')->where('id', $id)->findAll();

        //variables
        $controller = "Api/Catalogos/Paquetes";
        $data_header['title'] = "Estudios del ".$packet[0]['name'];
        $data_header['description'] = "Listado de grupos de examenes a realizar, con precio y preparación ";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data['id_packet'] = $packet[0]['id_product'];

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/CRUD.js",  "Catalogos/Add_studies.js"
        ];

        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js", "https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css", "botones.css", "../lib/datatables/jquery.dataTables.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css", "https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.01.min.css"];

        //Database
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Catalogos/Add_studies', $data);
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter); 

    }
}
