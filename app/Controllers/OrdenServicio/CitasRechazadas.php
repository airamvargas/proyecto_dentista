<?php

/* Desarrollador: Airam Vargas
Fecha de creacion: 25 - 08 - 2023
Fecha de Ultima Actualizacion:
Perfil: Recepcionista
Descripcion: Se manejara una tabla de las citas que hayan sido canceladas/rechazadas por los médicos
para que puedan ser reasignadas en otro horario */

namespace App\Controllers\OrdenServicio;
use App\Controllers\BaseController;

class CitasRechazadas extends BaseController {

    public function index() {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //variables
        $controller = "Api/OrdenServicio/Citas_rechazadas";
        $data_header['title'] = "Citas rechazadas";
        $data_header['description'] = "Listado de citas que han sido rechazadas";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/recepcionista-de1/page/citas-rechazadas";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js", "Generales/CRUD.js",  "OrdenServicio/Citas_rechazadas.js"
        ];

        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js", "https://momentjs.com/downloads/moment-with-locales.min.js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css", "botones.css", "../lib/datatables/jquery.dataTables.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];

        //Database
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('OrdenServicio/Citas_rechazadas');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);

    }
}