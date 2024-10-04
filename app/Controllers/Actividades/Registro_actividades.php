<?php

namespace App\Controllers\Actividades;
use App\Controllers\BaseController;

class Registro_actividades extends BaseController
{

    public function index()
    {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();

        //Js Scripts ['script1.js' , 'script2.js' , 'script3.js']
        $data_fotter['scripts'] = ["../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js", "dashboard.js", "Actividades/Registro_actividades.js","Generales/Accesos.js"];

        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css",  "../lib/datatables/jquery.dataTables.css"];

        //Database
        $data_header['title'] = "Registro de actividades";
        $data_header['description'] = "Listado de registro de actividades";
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Actividades/Registro_actividades_view');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }


    public function insert_activity(){
        $model_activity = model('App\Models\Actividades\Model_actividades');
        $request = \Config\Services::request();

        $data = [
            'fecha' => $request->getPost('fecha'),
            'rubro' => $request->getPost('rubro'),
            'empresa' => $request->getPost('empresa'),
            'actividad' => $request->getPost('actividad'),
            'responsable' => $request->getPost('responsable'),
            'concluida' => $request->getPost('concluida')
        ];

        $model_activity->insert($data);
        return redirect()->to(base_url().'/Actividades/Registro_actividades');

    }

    public function get_users(){
        $model = model('App\Models\Model_user\Table_user');
        $data = $model->get_users();
        echo json_encode($data);
    }

    public function get_datos(){
        $model_activity = model('App\Models\Actividades\Model_actividades');      
        $data['data'] = $model_activity->get_datos();
        return json_encode($data); 
    }

    public function get_update(){
        $model_activity = model('App\Models\Actividades\Model_actividades');  
        $request = \Config\Services::request();
        $id = $request->getPost('id');    
        $data = $model_activity->get_datos_update($id);
        return json_encode($data); 
    }

    public function update_activity(){
        $model_activity = model('App\Models\Actividades\Model_actividades');
        $request = \Config\Services::request();

        $id = $request->getPost('id_update');

        $data = [
            'fecha' => $request->getPost('fecha_update'),
            'rubro' => $request->getPost('rubro_update'),
            'empresa' => $request->getPost('empresa_update'),
            'actividad' => $request->getPost('actividad_update'),
            'responsable' => $request->getPost('responsable_update'),
            'concluida' => $request->getPost('concluida_update')
        ];

        var_dump($data);

        $model_activity->update($id, $data);
        return redirect()->to(base_url().'/Actividades/Registro_actividades');
    }

    public function delete_activity(){
        $model_activity = model('App\Models\Actividades\Model_actividades');
        $request = \Config\Services::request();
        $id = $request->getPost('id_delete');
        $model_activity->delete($id);
        return redirect()->to(base_url().'/Actividades/Registro_actividades');
    }
   
    
}
