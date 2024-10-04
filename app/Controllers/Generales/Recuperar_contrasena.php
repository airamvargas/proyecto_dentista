<?php

namespace App\Controllers\Generales;
use App\Controllers\BaseController;

class Recuperar_contrasena extends BaseController
{
    public function index($token)
    {
        $model = model('App\Models\Administrador\Usuarios');
        $get_token = $model->getToken($token);
        $active = $get_token['activation_token'];

        if($active == 1){
            $data['data'] = $model->getDataidentity($token);
            $data['token'] = $token;

            //var_dump($data['token']);
            $data_header['styles'] = ["starlight.css", "solimaq.css", "Importaciones.css",  "paciente/Cambio_contraseña.css", "../lib/datatables/jquery.dataTables.css"];
            $data_header['title'] = "Cambio de contraseña";
            $data_header['description'] = "Cambio de contraseña";

            //External js
            $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js"];
            //External css//
            $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"];
            $data_fotter['scripts'] = [ "Generales/Recover_password.js"];
            
            echo view('header', $data_header);
            echo view('General/Change_password', $data);
            echo view('fotter_panel', $data_fotter);
        } 
    }
}
