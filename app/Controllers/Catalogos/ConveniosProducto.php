<?php

namespace App\Controllers\Catalogos;
use App\Controllers\BaseController;

class ConveniosProducto extends BaseController
{

    public function index() {
        
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //VARIABLES
        $data['id_convenio'] = "";
        $data_header['wiki_controller'] = "books/back-office/page/productos-por-convenio";


        //Js Scripts ['script1.js' , 'script2.js' , 'script3.js']
        $data_fotter['scripts'] = [ "dashboard.js", "../../assets/lib/datatables/jquery.dataTables.js",
            "../lib/datatables-responsive/dataTables.responsive.js",
            "../../assets/lib/datatables-responsive/dataTables.responsive.js", 
            "Generales/Accesos.js", "Generales/CRUD.js",
            "Catalogos/ConveniosProducto.js"
        ];

        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css", "botones.css",
            "../../assets/lib/SpinKit/spinkit.css","../lib/datatables/jquery.dataTables.css", 
            "../../assets/lib/datatables/jquery.dataTables.css"
        ];
        
        //api path
        $controller = "Api/Catalogos/ConveniosProductos";
        $data_fotter['controlador'] = $controller;

        $data_header['title'] = "Productos por Convenio";
        $data_header['description'] = "Listado de los productos y a que convenio pertenecen";

        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js",  
            "https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js", "https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js"
        ];

        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css",
        "https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.01.min.css"];

        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Catalogos/ConvenioProductos',$data);
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }

    public function add_products($id) {
        
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //VARIABLES
        $data['id_convenio'] = $id;

        $model = model('App\Models\Catalogos\Convenios');
        $name = $model->nameConvenio($id);
        $data_header['wiki_controller'] = "books/back-office/page/productos-por-convenio";

        //var_dump($name);

        //Js Scripts ['script1.js' , 'script2.js' , 'script3.js']
        $data_fotter['scripts'] = [ "dashboard.js", "../../assets/lib/datatables/jquery.dataTables.js",
            "../lib/datatables-responsive/dataTables.responsive.js",
            "../../assets/lib/datatables-responsive/dataTables.responsive.js", 
            "Generales/Accesos.js", "Generales/CRUD.js",
            "Catalogos/Productos_x_convenio.js"
        ];

        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css", "botones.css",
            "../../assets/lib/SpinKit/spinkit.css","../lib/datatables/jquery.dataTables.css", 
            "../../assets/lib/datatables/jquery.dataTables.css"
        ];
        
        //api path
        $controller = "Api/Catalogos/ConveniosProductos";
        $data_fotter['controlador'] = $controller;
        $data_header['wiki_controller'] = "books/administrador/page/convenios";


        $data_header['title'] = "Productos del convenio ".$name[0]['name'];
        $data_header['description'] = "Listado de los productos pertenecientes a un producto";

        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js",  
            "https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js", "https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js"
        ];

        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css",
        "https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.01.min.css"];

        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Catalogos/ConvenioProductos',$data);
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }

}
