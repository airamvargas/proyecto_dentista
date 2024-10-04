<?php
/*
Desarrollador: Jesus Esteban Sanchez Alcantara
Fecha Creacion: 16-agosto-2023
Fecha de Ultima Actualizacion: 17-agosto-2023
Perfil: Administracion
Descripcion: Catalogo de preguntas
*/
namespace App\Controllers\Catalogos\Laboratorio;
use App\Controllers\BaseController;

class Pregunta extends BaseController
{

    public function index()
    {
        
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //variables
        $controller = "Api\Catalogos\Laboratorio\Preguntas";
        $data_header['title'] = "Preguntas preanalíticas";
        $data_header['description'] = "Catálogo de preguntas preanalíticas";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/administrador/page/preguntas";

        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/CRUD.js",  "Catalogos/Laboratorio/Pregunta.js"
        ];
        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css",  "../lib/datatables/jquery.dataTables.css", "botones.css", "tablas.css"];
        //External css
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];

        //Views
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Catalogos/Laboratorio/Preguntas');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);

    }
}
