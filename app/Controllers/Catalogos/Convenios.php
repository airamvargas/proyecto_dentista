<?php

namespace App\Controllers\Catalogos;

use App\Models\Access;
use App\Controllers\BaseController;

class Convenios extends BaseController {
    
    public function index(){
        //call to helper menu
        helper('menu');
        //method session
        $session = session();
        //api path
        $controller = "Api/Catalogos/Convenios";
        //variables
        $data_header['title'] = "Convenios";
        $data_header['description'] = "Listado de convenios con empresas";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/administrador/page/convenios";
        //Documents javascript 
        $data_fotter['scripts'] = ["../lib/datatables/jquery.dataTables.js","../lib/datatables-responsive/dataTables.responsive.js",  "dashboard.js", "Generales/Accesos.js", "Generales/CRUD.js", "Catalogos/Convenios.js"];
        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js", "https://momentjs.com/downloads/moment-with-locales.min.js", "https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "../lib/datatables/jquery.dataTables.css", "botones.css", "Catalogos.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];
        //Loads Views
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel'); 
        echo view('right_panel');
        echo view('Catalogos/Convenios');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }
    
    public function products($id){
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //obtener nombre del convenio
        $model_unit = model('App\Models\Catalogos\Convenios');
        $unit = $model_unit->select('name')->where('id', $id)->findAll();

        //VARIABLES
        $data['id_convenio'] = $id;
        $data_header['wiki_controller'] = "books/administrador/page/convenios";

        //Js Scripts ['script1.js' , 'script2.js' , 'script3.js']
        $data_fotter['scripts'] = [ "dashboard.js", "../../assets/lib/datatables/jquery.dataTables.js",
            "../lib/datatables-responsive/dataTables.responsive.js",
            "../../assets/lib/datatables-responsive/dataTables.responsive.js", 
            "Generales/Accesos.js", "Generales/CRUD.js", "Catalogos/Convenio_productos.js"
        ];

        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css", "botones.css",
            "../../assets/lib/SpinKit/spinkit.css","../lib/datatables/jquery.dataTables.css", 
            "../../assets/lib/datatables/jquery.dataTables.css"
        ];
        
        //api path
        $controller = "Api/Catalogos/Convenios";
        $data_fotter['controlador'] = $controller;

        $data_header['title'] = "Productos del convenio ".$unit[0]['name'];
        $data_header['description'] = "Listado de los productos que pertenecen a un convenio";

        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js", "https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js", 
            "https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js"
        ];

        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css",
        "https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.01.min.css"];

        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Catalogos/ConvenioProductos_individual', $data);
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }
}

?>
