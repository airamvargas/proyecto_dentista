<?php

namespace App\Controllers\Catalogos;
use App\Controllers\BaseController;

class BusinessUnit extends BaseController
{

    public function index()
    {
        
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //variables
        $controller = "Api/Catalogos/BusinessUnit";
        $data_header['title'] = "Unidad de Negocio";
        $data_header['description'] = "Catálogo de unidad de negocio";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/administrador/page/unidad-de-negocio";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/CRUD.js",  "Catalogos/BusinessUnit.js"
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
        echo view('Catalogos/BusinessUnit');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);

    }

    public function add_products($id) {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //obtener nombre de la unidad
        $model_unit = model('App\Models\Catalogos/BusinessUnit');
        $unit = $model_unit->select('name')->where('id', $id)->findAll();

        //variables
        $controller = "Api/Catalogos/BusinessUnit";
        $data_header['title'] = "Productos de la unidad ".$unit[0]['name'];
        $data_header['description'] = "Catálogo de productos en cada unidad de negocio";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data['id_unidad'] = $id;
        $data_header['wiki_controller'] = "books/administrador/page/unidad-de-negocio";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/CRUD.js",  "Catalogos/Add_products.js"
        ];
        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js", "https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js", "https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css",  "botones.css", "../lib/datatables/jquery.dataTables.css", "HCV/administrativo/index.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css", "https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.01.min.css"];

        //Views
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Catalogos/AddProducts', $data);
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);

    }
}