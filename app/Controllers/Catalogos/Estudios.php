<?php

namespace App\Controllers\Catalogos;
use App\Controllers\BaseController;

class Estudios extends BaseController
{

    public function index() {
        
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();
        $id_group = $session->get('group');

        //variables
        $controller = "Api/Catalogos/Estudios";
        $data_header['title'] = "Estudios";
        $data_header['description'] = "Listado de grupos de examenes a realizar, con precio y preparación ";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/administrador/page/estudios";
        $data['id_group'] = $id_group;

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/CRUD.js",  "Catalogos/Estudios.js"
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
        echo view('Catalogos/Estudios', $data);
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);

    }

    public function add_exams($id) {
        
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //obtener nombre del estudio
        $model_insumos= model('App\Models\Catalogos\Insumos');
        $study = $model_insumos->select('id_product, name')->where('id', $id)->findAll();

        //variables
        $controller = "Api/Catalogos/Estudios";
        $data_header['title'] = "Analitos del estudio ".$study[0]['name'];
        $data_header['description'] = "Listado de analitos que corresponden a este estudio";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data['id_study'] = $study[0]['id_product'];
        $data_header['wiki_controller'] = "books/administrador/page/estudios";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/CRUD.js",  "Catalogos/Add_exams.js"
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
        echo view('Catalogos/Add_exams', $data);
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }

    /* Desarrollador: Giovanni Zavala Cortes
    Fecha de creacion:30/08/2023
    Fecha de Ultima Actualizacion: 30/08/2023 
    Perfil: Administrador
    Descripcion: Catalogo de asignacion de preguntas al estudio */

    //Catalogo de preguntas por estudio
    public function addQuestions($id){
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //obtener nombre del estudio
        $model_insumos= model('App\Models\Catalogos\Insumos');
        $study = $model_insumos->select('id_product, name')->where('id', $id)->findAll();

        //variables
        //$controller = "Api/Catalogos/Estudios";
        $data_header['title'] = $study[0]['name'];
        $data_header['description'] = "Listado de preguntas ";
        $data_left['menu'] = get_menu();
        //$data_fotter['controlador'] = $controller;
        $data['id_study'] = $id;
        $data_header['wiki_controller'] = "books/administrador/page/estudios";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "Generales/Fetch.js",  "Catalogos/Add_questions.js"
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
        echo view('Catalogos/Add_Questions', $data);
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);

    }
}
