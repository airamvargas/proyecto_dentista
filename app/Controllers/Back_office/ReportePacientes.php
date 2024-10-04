<?php

/* Desarrollador: Airam V. Vargas López
Fecha de creacion: 17 de noviembre de 2023
Fecha de Ultima Actualizacion: 22 de noviembre de 2023
Perfil: Back Office
Descripcion: Controlador del reporte de pacientes*/

namespace App\Controllers\Back_office;
use App\Controllers\BaseController;

class ReportePacientes extends BaseController
{

    public function index() {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //variables
        $controller = "Api/Back_office/Reportes";
        $data_header['title'] = "Reporte de pacientes";
        $data_header['description'] = "Listado de pacientes";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/back-office/page/reporte-de-ventas-por-pacientes";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "Generales/CRUD.js"
        ];

        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js",
            "https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js"
        ];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css",  "../lib/datatables/jquery.dataTables.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];

        //Database
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Back_office/reportePacientes');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);

    }

    public function detalles() {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();
        $uri = service('uri');
        $id_usuario = $uri->getSegment(5);

        //variables
        $controller = "Api/Back_office/Reportes";
        $data_header['title'] = "Detalles de los servicios prestados";
        $data_header['description'] = "";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data['id_usuario'] = $id_usuario;
        $data_header['wiki_controller'] = "books/back-office/page/reporte-de-ventas-por-pacientes";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "Generales/CRUD.js", "Back_office/ReportePacientes.js"
        ];

        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js",
            "https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js"
        ];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css",  "../lib/datatables/jquery.dataTables.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css", "https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"];

        //Database
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Back_office/detallesPaciente', $data);
        echo view('right_panel'); 
        echo view('fotter_panel', $data_fotter);

    }
}