<?php

namespace App\Controllers\OrdenServicio;
use App\Controllers\BaseController;
use Mockery;
use Mpdf\QrCode\QrCode;


require_once __DIR__ . '../../vendor/autoload.php';

class Pacientes extends BaseController {

    public function index() {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //variables
        $controller = "Api/HCV/Administrativo/Principal_pacientes";
        $data_header['title'] = "Pacientes";
        $data_header['description'] = "Listado de pacientes";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/recepcionista-de1/page/pacientes";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js", "Generales/CRUD.js",  "OrdenServicio/Pacientes.js"
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
        echo view('OrdenServicio/Pacientes');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);

    }
}
