<?php

/* Desarrollador: Airam V. Vargas López
Fecha de creacion: 24 de noviembre de 2023
Fecha de Ultima Actualizacion: 
Perfil: Back Office
Descripcion: Controlador del reporte de cuentas por cobrar */

namespace App\Controllers\Back_office;
use App\Controllers\BaseController;

class ReporteCuentas extends BaseController
{

    public function index() {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //variables
        $controller = "Api/Back_office/ReporteCuentas";
        $data_header['title'] = "ABONOS DE CLIENTE";
        $data_header['description'] = "Listado de abonos de cliente";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/back-office/page/abonos-de-cliente";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "Generales/CRUD.js", "Back_office/ReporteCuentas.js"
        ];

        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js",
            "https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js"
        ];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "botones.css", "Importaciones.css",  "../lib/datatables/jquery.dataTables.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];

        //Database
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Back_office/reporteCuentas');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);

    }

    public function detallesCuenta() {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();
        $uri = service('uri');
        $id_company = $uri->getSegment(4);

        //MODEL EMPRESAS
        $model_company = model('App\Models\Catalogos\Empresas');
        $name_company = $model_company->select('name')->where('id', $id_company)->find()[0]['name'];

        //variables
        $controller = "Api/Back_office/ReporteCuentas";
        $data_header['title'] = "Detalles abonos de ".$name_company;
        $data_header['description'] = "";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data['id_company'] = $id_company;
        $data_header['wiki_controller'] = "books/back-office/page/abonos-de-cliente";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "Generales/CRUD.js", "Back_office/detallesCuenta.js"
        ];

        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js",
            "https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js", "https://momentjs.com/downloads/moment.min.js"
        ];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css",  "../lib/datatables/jquery.dataTables.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];

        //Database
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Back_office/detallesAbonos', $data);
        echo view('right_panel'); 
        echo view('fotter_panel', $data_fotter);
    }

    public function detallesAdeudo() {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();
        $uri = service('uri');
        $id_abono = $uri->getSegment(4);

        //MODEL ABONOS
        $model_abonos = model('App\Models\Back_office\Reportes\AbonosIndividuales');
        $name_company = $model_abonos->select('cat_company_client.name AS empresa, id_company')->join('cat_company_client', 'cat_company_client.id = crm_abonosIndividuales.id_company')->where('crm_abonosIndividuales.id', $id_abono)->find()[0];
    
        //variables
        $controller = "Api/Back_office/ReporteCuentas";
        $data_header['title'] = "Cuentas pendientes de ".$name_company['empresa'];
        $data_header['description'] = "";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data['id_abono'] = $id_abono;
        $data['id_company'] = $name_company['id_company'];
        $data_header['wiki_controller'] = "books/back-office/page/abonos-de-cliente";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "Generales/CRUD.js", "../lib/tabulator/dist/js/luxon.min.js","../lib/tabulator/dist/js/tabulator.min.js", "Back_office/detallesAdeudo.js"
        ];

        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js",
            "https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js", "https://momentjs.com/downloads/moment.min.js"
        ];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css",  "../lib/datatables/jquery.dataTables.css", "../lib/tabulator/dist/css/tabulator_semanticui.min.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];

        //Database
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Back_office/detallesAdeudo', $data);
        echo view('right_panel'); 
        echo view('fotter_panel', $data_fotter);
    }
}