<?php

/* Desarrollador: Airam Vargas
Fecha de creacion: 
Fecha de Ultima Actualizacion: 11 - 09 - 2023 - Airam Vargas
Perfil: Administrador
Descripcion: Cátalogo de analitos*/

namespace App\Controllers\Catalogos;

use App\Controllers\BaseController;

class Exams extends BaseController
{
    public function index()
    {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //variables
        $controller = "Api/Catalogos/Exams";
        $data_header['title'] = "Analitos";
        $data_header['description'] = "Listado de analitos";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/administrador/page/analitos";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/CRUD.js",  "Catalogos/Exams.js"
        ];

        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css",  "../lib/datatables/jquery.dataTables.css", "tablas.css"];
        //External css//
        $data_header['external_styles'] = ["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];

        //Database
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Catalogos/IndividualExam');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }

    public function values()
    {
        $uri = service('uri');
        $id_exam = $uri->getSegment(4);
        $model_exam = model('App\Models\Catalogos\Cat_exams');
        $nameExam = $model_exam->select('name,result')->where('id', $id_exam)->find();
        $session = session();


        switch ($nameExam[0]['result']) {
            case 1:
                $data['resultado'] = "Númerico";
                break;
            case 2:
                $data['resultado'] = "Texto";
                break;
            case 3:
                $data['resultado'] = "Cerrado";
                break;
        }

        //variables
        $controller = "Api/Catalogos/Exams";
        $data_header['title'] = "Valores del analito";
        $data_header['description'] = "Listado de valores del analito " . $nameExam[0]['name'] . ", según género y edad";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data['id_exam'] = $id_exam;
        $data_header['wiki_controller'] = "books/back-office/page/agregar-rango-de-valores";
       

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/CRUD.js",  "Catalogos/Laboratorio/Exams_values.js"
        ];

        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css",  "../lib/datatables/jquery.dataTables.css", "tablas.css"];
        //External css//
        $data_header['external_styles'] = ["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];

        //Database
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Catalogos/Laboratorio/Values', $data);
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }
}
