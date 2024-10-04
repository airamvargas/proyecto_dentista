<?php

/* Desarrollador: Airam Vargas
Fecha de creacion: 16 - agosto - 2023
Fecha de Ultima Actualizacion:
Perfil: Administrador
Descripcion: Catálogo de contenedores para muestras */

namespace App\Controllers\Catalogos\Laboratorio;
use App\Controllers\BaseController;

class Contenedores extends BaseController
{

    public function index()
    {
        
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //variables
        $controller = "Api\Catalogos\Laboratorio\Contenedores";
        $data_header['title'] = "Contenedores";
        $data_header['description'] = "Listado de contenedores para una toma de muestra";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/administrador/page/contenedores";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/CRUD.js",  "Catalogos/Laboratorio/Contenedores.js"
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
        echo view('Catalogos/Laboratorio/Contenedores');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);

    }
}
