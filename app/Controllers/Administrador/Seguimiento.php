<?php

namespace App\Controllers\Administrador;
use App\Controllers\BaseController;

class Seguimiento extends BaseController
{

    public function index()
    {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //Js Scripts ['script1.js' , 'script2.js' , 'script3.js']
        $data_fotter['scripts'] = ["../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js", "dashboard.js", "Administrador/Seguimiento.js"];

        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css"];

        //Database
        $data_header['title'] = "Seguimiento";
        $data_header['description'] = "Grafica de las etapas de venta";
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('fotter_panel', $data_fotter);
        echo view('Administrador/Seguimiento');
        echo view('right_panel');
       // echo view('fotter_panel', $data_fotter);
    }

    public function getGrafica(){
        $model = model('App\Models\Model_cotizacion\Cotizacion');
        $data = $model->grafica();
       return json_encode($data);
    }
    public function getGraficalimit(){
        $model = model('App\Models\Model_cotizacion\Cotizacion');
        $request = \Config\Services::request();
        $offset = $request->getPost('offset');
        $data1 = $model->graficaNext($offset);
        $total = count($data1);
        if($total == 0){
            $data['offset'] = (int)$offset-5;
            $data['grafica'] = $model->graficaNext($data['offset']);

        }else{
            $data['offset'] = (int)$offset+5;
            $data['grafica'] = $model->graficaNext($offset);

        }
       return json_encode($data);
    }


    public function getBack(){
        $model = model('App\Models\Model_cotizacion\Cotizacion');
        $request = \Config\Services::request();
        $offset = $request->getPost('offset');
        $offset2 = $offset-10;

        if($offset2 < 0 ){ 
            $offset = 1;
            $data['offset'] = 5;
            $data['grafica'] = $model->graficaNext($offset);

        }else{
            $data['offset'] = (int)$offset-5;
            $data['grafica'] = $model->graficaNext($offset-10);
        
        }

        return json_encode($data); 

    }

    public function geEtapas(){
         $model = model('App\Models\Model_sales_stage\Sales_stage');
        $data = $model->getStages();
        return json_encode($data);

    }
}
