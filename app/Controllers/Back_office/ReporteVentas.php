<?php

/* Desarrollador: Airam V. Vargas López
Fecha de creacion: 13 de noviembre de 2023
Fecha de Ultima Actualizacion: 
Perfil: Back Office
Descripcion: Controlador del reporte de ventas */

namespace App\Controllers\Back_office;
use App\Controllers\BaseController;

class ReporteVentas extends BaseController
{

    public function index() {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //variables
        $controller = "Api/Back_office/Reportes";
        $data_header['title'] = "Reporte de ventas por orden de servicio";
        $data_header['description'] = "Listado de ventas por orden de servicio";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/back-office/page/reporte-de-ventas-por-orden-de-servicio";

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
        echo view('Back_office/reporteVentas');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);

    }

    public function detalles() {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();
        $uri = service('uri');
        $id_cotizacion = $uri->getSegment(5);

        //variables
        $controller = "Api/Back_office/Reportes";
        $data_header['title'] = "Detalles cotización";
        $data_header['description'] = "Detalles de la cotización";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data['id_cotizacion'] = $id_cotizacion;
        $data_header['wiki_controller'] = "books/back-office/page/reporte-de-ventas-por-orden-de-servicio";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "Generales/CRUD.js", "Back_office/ReporteVentas.js"
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
        echo view('Back_office/detallesCotizacion', $data);
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);

    }
}