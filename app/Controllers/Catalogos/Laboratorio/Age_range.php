<?php

/* Desarrollador: Airam Vargas
Fecha de creacion: 07 - septiembre - 2023
Fecha de Ultima Actualizacion:
Perfil: Administrador
Descripcion: Catálogo de rangos de edades */

namespace App\Controllers\Catalogos\Laboratorio;
use App\Controllers\BaseController;

class Age_range extends BaseController
{

    public function index()
    {
        
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //variables
        $controller = "Api\Catalogos\Laboratorio\Age_range";
        $data_header['title'] = "Rangos de edad";
        $data_header['description'] = "Listado de rangos de edad";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/administrador/page/rango-de-edad";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/CRUD.js",  "Catalogos/Laboratorio/Age_range.js"
        ];
        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css",  "../lib/datatables/jquery.dataTables.css", "botones.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];

        //Database
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Catalogos/Laboratorio/Age_range');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);

    }
}