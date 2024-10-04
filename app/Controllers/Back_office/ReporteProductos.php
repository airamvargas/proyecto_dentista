<?php

/* Desarrollador: Airam V. Vargas López
Fecha de creacion: 17 de noviembre de 2023
Fecha de Ultima Actualizacion: 
Perfil: Back Office
Descripcion: Controlador del reporte de ventas por productos*/



namespace App\Controllers\Back_office;

use App\Controllers\BaseController;

class ReporteProductos extends BaseController
{

    public function index()
    {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //variables
        $controller = "Api/Back_office/Reportes";
        $data_header['title'] = "Reporte de ventas por productos";
        $data_header['description'] = "Listado de ventas por productos";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/back-office/page/reporte-de-ventas-por-productos";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "Generales/CRUD.js",
            //"../lib/datatables/jquery.dataTables.js",
            "../lib/datatables-responsive/dataTables.responsive.js",
            
            "Back_office/ReporteProductos.js"
        ];

        //External js
        $data_fotter['external_scripts'] = [
            "https://cdn.jsdelivr.net/npm/toastify-js",
            "https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js",



            "https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js",
            "https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js",
            "https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js",
            "https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js",
            "https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js",
            "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js",
            "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"

        ];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css",  "../lib/datatables/jquery.dataTables.css"];
        //External css//
        $data_header['external_styles'] = [
            "https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"
        ];

        //Database
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Back_office/reporteProductos');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }
}
