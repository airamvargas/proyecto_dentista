<?php

namespace App\Controllers\Api\Pacientes;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('sendmail');

use App\Models\models_paciente\Identity as model;

class Identity extends ResourceController
{
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct()
    { //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }

    public function create()
    {
        $session = session();
        $user_id = $session->get('unique');
        $model_users = model('App\Models\Model_user/Table_user');
        $model_cotization = model('App\Models\Model_cotizacion/Cotizacion');
        $request = \Config\Services::request();
        $name = $request->getPost('n_cliente') . " " . $request->getPost('ap_paterno') . " " . $request->getPost('ap_materno');

        if ($request->getPost('correo') != "") {
            $token = $this->generate_token();
            $token = str_replace(".", "&", $token);

            $data_users = [
                'id_group' => 4,
                'user_name' => $name,
                'email' => $request->getPost('correo'),
                'activation_token' => $token
            ];

            $asunto = "Cambiar Contraseña";
            $file = null;
            $full_name = $request->getPost('n_cliente')." ".$request->getPost('ap_paterno')." ".$request->getPost('ap_materno');
            $datos['usuario'] = $full_name;
            $datos['texto'] = "Crear Contraseña";
            $datos['texto_link'] ="Para crear su cntraseña y pueda entrar al portal, da click en el siguiente link";
            $datos['url'] = "/Generales/Recuperar_contrasena/index/".$token;
            $mensaje = view('General/Password', $datos);
            $send_email = send_email($request->getPost('correo'), $asunto, $mensaje, $file);

        } else {
            $data_users = [
                'id_group' => 4,
                'user_name' => $name,
            ];
        }

        $id = $model_users->insert($data_users);

        if ($id) {
            $data_cotization = [
                'id_user_vendor' => $user_id,
                'id_user_client' => $id,
            ];

            $id_cotizacion = $model_cotization->insert($data_cotization);

            $data_identity = [
                'ID_USER' => $id,
                'NAME' => $request->getPost('n_cliente'),
                'F_LAST_NAME' => $request->getPost('ap_paterno'),
                'S_LAST_NAME' => $request->getPost('ap_materno'),
                'PHONE_NUMBER' => $request->getPost('telefono'),
                'BIRTHDATE' => $request->getPost('f_nacimiento'),
                'ID_CAT_NATIONALITY' => $request->getPost('nacionalidad'),
                'ID_CAT_GENDER_IDENTITY' => $request->getPost('sexo'),
                'ID_ZIP_CODE' => $request->getPost('cp_id')
            ];

            $id_identity = $this->model->insert($data_identity);

            if ($id_identity) {
                $mensaje = [
                    'status' => 200,
                    'msg' => 'AGREGADO CON EXITO',
                    'id' => $id,
                    'id_cotizacion' => $id_cotizacion
                ];
                return $this->respond($mensaje);
            }
        }
    }

    public function generate_token()
    {
        return bin2hex(random_bytes(24));
    }
    
}
