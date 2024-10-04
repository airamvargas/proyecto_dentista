<?php

namespace App\Controllers;

require_once __DIR__ . '/vendor/autoload.php';

class Cotizaciones extends BaseController
{
    public function index()
    {
        helper('menu');
        $session = session();
        $user_id = $session->get('unique');
        
        //model y consulta de id_group
        $model = model('App\Models\Administrador\Usuarios');
        $id_group = $model->select('id_group')->where('id', $user_id)->find()[0]['id_group'];
        //variable wiki dependiendo si el usuario es call center o no 
        if($id_group == 6){
            $data_header['wiki_controller'] = "books/call-center/page/orden-de-servicios";
        } else {
            $data_header['wiki_controller'] = "books/recepcion/page/orden-de-servicios";
        }

        $data_left['menu'] = get_menu();
        //Variables
        $data_header['title'] = "Cotización";
        $data_header['description'] = "Listado de prospectos";

        //api path
        $controller = "Api/Cotizaciones/Cotizaciones";
        $data_fotter['controlador'] = $controller;


        //Js Scripts
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js",
            "Generales/Accesos.js", "Generales/CRUD.js", "Cotizacion/cotizaciones.js","Generales/Notificaciones.js"
        ];

        //Css Shets
        $data_header['styles'] = [
            "starlight.css", "solimaq.css", "botones.css", "../lib/datatables/jquery.dataTables.css", "Prospectos.css",
            "../../assets/lib/SpinKit/spinkit.css", "tablas.css"
        ];
  

        //External js
        $data_fotter['external_scripts'] = [
            "https://cdn.jsdelivr.net/npm/toastify-js", "https://momentjs.com/downloads/moment-with-locales.min.js",
            "https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js", "https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js"
        ];

        //External css//
        $data_header['external_styles'] = [
            "https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css",
            "https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.01.min.css"
        ];


        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Cotizacion/Cotizacion_views');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }

    public function busqueda()
    {
        helper('menu');
        $session = session();
        $user_id = $session->get('unique');
        $data_left['menu'] = get_menu();
        //Js Scripts ['script1.js' , 'script2.js' , 'script3.js']
        $data_fotter['scripts'] = ["../lib/datatables/jquery.dataTables.js",
            "Generales/Accesos.js", "Generales/CRUD.js", "Cotizacion/Busqueda.js"
        ];

        //model y consulta de id_group
        $model = model('App\Models\Administrador\Usuarios');
        $id_group = $model->select('id_group')->where('id', $user_id)->find()[0]['id_group'];
        //variable wiki dependiendo si el usuario es call center o no 
        if($id_group == 6){
            $data_header['wiki_controller'] = "books/call-center/page/orden-de-servicios";
        } else {
            $data_header['wiki_controller'] = "books/recepcion/page/orden-de-servicios";
        }

        //Css Shets
        $data_header['styles'] = [
            "starlight.css", "solimaq.css",
            "../lib/datatables/jquery.dataTables.css", "Prospectos.css", "botones.css", "../../assets/lib/SpinKit/spinkit.css", "tablas.css"
        ];

        //VAR
        $data_header['title'] = "Búsqueda de cliente";
        $data_header['description'] = "Buscar el nombre del cliente al que se le realizará la cotización";
        $data_header['wiki_controller'] = "books/recepcionista-de1/page/orden-de-servicios";

        //api path
        $controller = "Api/Cotizaciones/Cotizaciones";
        $data_fotter['controlador'] = $controller;

        //External js
        $data_fotter['external_scripts'] = [
            "https://cdn.jsdelivr.net/npm/toastify-js", "https://momentjs.com/downloads/moment-with-locales.min.js",
            "https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js"
        ];

        //External css//
        $data_header['external_styles'] = [
            "https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css",
            "https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.01.min.css"
        ];

        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Cotizacion/Busqueda_clientes');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }

    public function ordenServicio($id) {
        //var_dump($_POST);
        helper('menu');
        helper('cotization');
        $session = session();
        $data_left['menu'] = get_menu();
        $id_group = $session->get('group');
        $user_id = $session->get('unique');
        $confirm = check_cotization($id, $user_id);

        if($confirm){
            //Js Scripts
            $data_fotter['scripts'] = ["../lib/datatables/jquery.dataTables.js",
                "Generales/CRUD.js", "Cotizacion/Estudios_cotizacion.js"
            ];

            //Css Shets
            $data_header['styles'] = ["starlight.css", "solimaq.css", "botones.css", "../lib/datatables/jquery.dataTables.css", "Prospectos.css", "tablas.css"];

            //Variables
            $data_header['title'] = "ORDEN DE SERVICIO";
            $data_header['description'] = "Detalle de servicios a solicitar";

            //api path
            $controller = "Api/Cotizaciones/Cotizaciones_x_producto";
            $data_fotter['controlador'] = $controller;
           
            //variable wiki dependiendo si el usuario es call center o no 
            if($id_group == 6){
                $data_header['wiki_controller'] = "books/call-center/page/orden-de-servicios";
            } else {
                $data_header['wiki_controller'] = "books/recepcion/page/orden-de-servicios";
            }

            //MODELO CONSULTAS
            $model = model('App\Models\Model_cotizacion\Cotizacion');
            $id_convenio = $model->select('id_conventions, id_user_client')->where('id', $id)->find();
            $id_usuario = $id_convenio[0]['id_user_client'];
            
            $model_usuarios = model('App\Models\Administrador\Usuarios');
            $name = $model_usuarios->select('user_name')->where('id', $id_usuario)->find();
            $data['id_group'] = $id_group;
            $data['id_cotizacion'] = $id;
            $data['id_convenio'] = $id_convenio[0]['id_conventions'];
            $data['name_user'] = $name[0]['user_name'];

            //External js
            $data_fotter['external_scripts'] = [
                "https://cdn.jsdelivr.net/npm/toastify-js", "https://momentjs.com/downloads/moment-with-locales.min.js",
                "https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js", "https://unpkg.com/currency.js@2.0.4/dist/currency.min.js"
            ];

            //External css//
            $data_header['external_styles'] = [
                "https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css",
                "https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.01.min.css"
            ];

            echo view('header', $data_header);
            echo view('left_panel', $data_left);
            echo view('head_panel');
            echo view('Cotizacion/Paso_cotizacion', $data);
            echo view('right_panel');
            echo view('fotter_panel', $data_fotter);
        } else {
            return redirect()->to(base_url('Cotizaciones'));
        }
        
    }

    public function agendar_citas($id) {
        $session = session();
        helper('menu');
        helper('cotization');
        $user_id = $session->get('unique');
        $id_group = $session->get('group');
        $confirm = check_cotization($id, $user_id);

        if($confirm){
            $data_left['menu'] = get_menu();
            //Js Scripts
            $data_fotter['scripts'] = ["../lib/datatables/jquery.dataTables.js",
                "Generales/CRUD.js", "Cotizacion/Agendar_citas.js"
            ];
    
            //Css Shets
            $data_header['styles'] = ["starlight.css", "solimaq.css", "botones.css", "../lib/datatables/jquery.dataTables.css", "Prospectos.css", "tablas.css"];
    
            //Database
            $data_header['title'] = "Agendar citas";
            $data_header['description'] = "Agendar una cita para un estudio, en caso de ser necesario";
    
            //api path
            $controller = "Api/Cotizaciones/Cotizaciones_x_producto";
            $data_fotter['controlador'] = $controller;
    
            //VARIABLE
            //$data['id_paciente'] = $_POST['id_usuario'];
            $data['id_cotizacion'] = $id;

            //variable wiki dependiendo si el usuario es call center o no 
            if($id_group == 6){
                $data_header['wiki_controller'] = "books/call-center/page/orden-de-servicios";
            } else {
                $data_header['wiki_controller'] = "books/recepcion/page/orden-de-servicios";
            }
    
            //External js
            $data_fotter['external_scripts'] = [
                "https://cdn.jsdelivr.net/npm/toastify-js", "https://momentjs.com/downloads/moment-with-locales.min.js",
                "https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js", "https://unpkg.com/currency.js@2.0.4/dist/currency.min.js"
            ];
    
            //External css//
            $data_header['external_styles'] = [
                "https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css",
                "https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.01.min.css"
            ];
    
            echo view('header', $data_header);
            echo view('left_panel', $data_left);
            echo view('head_panel');
            echo view('Cotizacion/Asignar_citas', $data);
            echo view('right_panel');
            echo view('fotter_panel', $data_fotter);
        }else {
            return redirect()->to(base_url('Cotizaciones'));
        }
    }

    public function generar_compra($id) {
        $session = session();
        helper('menu');
        helper('cotization');
        $user_id = $session->get('unique');
        $id_group = $session->get('group');
        $confirm = check_cotization($id, $user_id);
        $id_cotizacion = $id;

        if($confirm){
            $data_left['menu'] = get_menu();
            //Js Scripts
            $data_fotter['scripts'] = ["../lib/datatables/jquery.dataTables.js",
                "Generales/CRUD.js", "Generales/Accesos.js", "Cotizacion/Generar_compra.js"
            ];
    
            //Css Shets
            $data_header['styles'] = ["starlight.css", "solimaq.css", "botones.css", "../lib/datatables/jquery.dataTables.css", "Prospectos.css", "tablas.css"];

            //api path
            $controller = "Api/Cotizaciones/Generar_compra";
            $data_fotter['controlador'] = $controller;

            //model
            $model = model('App\Models\Model_cotization_product\cotization_product');
            $total = $model->get_total($id_cotizacion);
    
            //Variables
            $id_cotizacion = $id;
            $data_header['title'] = "GENERAR COMPRA";
            $data_header['description'] = "Pago de los productos y/o servicios cotizados";
            $data['id_cotizacion'] = $id_cotizacion;
            $data['total_precio'] = $total[0]->total;
            //$id_cotizacion = 27;

            //variable wiki dependiendo si el usuario es call center o no 
            if($id_group == 6){
                $data_header['wiki_controller'] = "books/call-center/page/orden-de-servicios";
            } else {
                $data_header['wiki_controller'] = "books/recepcion/page/orden-de-servicios";
            }
    
            //External js
            $data_fotter['external_scripts'] = [
                "https://cdn.jsdelivr.net/npm/toastify-js", "https://momentjs.com/downloads/moment-with-locales.min.js",
                "https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js", "https://unpkg.com/currency.js@2.0.4/dist/currency.min.js"
            ];    
            //External css
            $data_header['external_styles'] = [
                "https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css",
                "https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.01.min.css"
            ];
            //Views
            echo view('header', $data_header);
            echo view('left_panel', $data_left);
            echo view('head_panel');
            echo view('Cotizacion/Generar_compra', $data);
            echo view('right_panel');
            echo view('fotter_panel', $data_fotter);  
        } else {
            return redirect()->to(base_url('Cotizaciones'));
        }
    }

    public function imprimir(){
        $id = $_POST['id_cotizacion'];
       // $id = 11;
        $model_productos = model('App\Models\Model_cotization_product\cotization_product');
        $model_cotizacion = model('App\Models\Model_cotizacion\Cotizacion');
        $model_company = model('App\Models\Company_data\Company_data');

        if($model_cotizacion->select('id_company_data')->where('id',$id)->find()[0]['id_company_data'] !=0){
            $data['company'] = $model_cotizacion->getCompany($id);
        }else{
            $data['company']=$model_company->getConpany();
        }

        $datos_user = $model_cotizacion->readCliente($id);
        $data['productos'] = $model_productos->readCotizations($id);
        $data['cliente'] = $model_cotizacion->readCliente($id);
        $data['total'] = $model_productos->get_total($id);
        $data['cotizacion'] = $id;
       
        //CREAR UN DOCUMENTO PDF CON MPDF
        $response = service('response');
        $response->setHeader('Content-type', ' application/pdf');
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($this->impreso($data)); 
        $mpdf->Output();
    }

    public function impreso($data)
    {
        return view('Cotizacionpdf/Cotizacionpdf',$data);
    }

    public function ticket() {
        $uri = service('uri');
        $id_cotizacion = $uri->getSegment(3);
        //vars
        $data_header['title'] = "Imprimir ticket";
        $data_header['description'] = "Impresión de etiquetas";
        $data_left['menu'] = get_menu();
        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",  "Cotizacion/Ticket.js"
        ];
        //"qr_lib/qrcode.js", "qr_lib/qrcode.min.js",
        //External js
        $data_fotter['external_scripts'] = ["https://unpkg.com/qrious@4.0.2/dist/qrious.js", "https://cdn.jsdelivr.net/npm/toastify-js", "https://momentjs.com/downloads/moment-with-locales.min.js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "botones.css", "../lib/datatables/jquery.dataTables.css", "HCV/operativo/Etiquetas.css"];
        //External css
        $data_header['external_styles'] = ["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];

        //variables
        $data['id'] = $id_cotizacion;

        //Views
        echo view('header', $data_header);
        echo view('Cotizacion/Ticket', $data);
        echo view('fotter_panel', $data_fotter);
    
    }
     
}
