<?php

namespace App\Controllers\Api\Administrador;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');

use App\Models\Administrador\Usuarios as model;
use App\Models\Administrador\Groups as grupos;

class Usuarios extends ResourceController
{
    use ResponseTrait;
    var $model;
    var $db;
    var $grupos;

    public function __construct()
    {
        //Assign global variables
        $this->model = new model();
        $this->grupos = new grupos();
        $this->db = db_connect();
        helper('messages');
    }

    //data from database 
    public function index()
    {
        $session = session();
        $grupo = $session->get('group');
        $data["data"] = $this->model->read($grupo);
        return $this->respond($data);
    }

    public function showGroup() {
        $session = session();
        $grupo = $session->get('group');
        $model = model('App\Models\Administrador\Grupos');
        $data = $model->getGroups($grupo);
        return $this->respond($data);
    }

    public function showBussiness()
    {
        $session = session();
        $grupo = $session->get('group');
        $model = model('App\Models\Catalogos\BusinessUnit');
        $data = $model->getBusinessUnits($grupo);
        return $this->respond($data);
    }

    public function read()
    {    //data from the datatable
        $data["data"] = $this->model->read();
        return $this->respond($data);
    }

    public function create()
    {
        $validation = \Config\Services::validation();
        $file = $this->request->getFile('image');
        if (!$file->isValid()) {
            $imagen = false;
            $name_image = "";
        } else {
            // image validation
            $validated = $this->validate([
                'image' => [
                    'uploaded[image]',
                    'mime_in[image,image/jpg,image/jpeg,image/png]',
                    'max_size[image,4096]',
                    'is_image[image]'
                ],
            ]);

            if (!$validated) {
                $mensaje = $this->errors($error = 600);
                return $this->respond($mensaje);
            } else {
                $imagen = true;
            }
        }

        $password =  $_POST['password'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $token = $this->generate_token(); 

        $data = [
            "user_name" => $_POST['nombre'] . " " . $_POST["apellido_ap"],
            "id_group" => $_POST['grupo'],
            "password" => $password,
            'activation_token' => $token,
            'email' => $_POST['email'],
            'active' => 1,
            //y'id_parent' => 
            'code' => rand(100000, 999999)
        ];


        if ($this->model->insert($data) === false) {
            $error = $this->model->errors();

            $mensaje = [
                "status" => 400,
                "msg" => $error['email']
            ];
            return $this->respond($mensaje);
        } else {
            $id = $this->model->getInsertID();
            if ($imagen) {
                $path = "../public/images";
                $file->move($path, $file->getRandomName());
                $name_image = $file->getName();
            }
            isset($_POST['id_cat_business_unit']) ? $unidad = $_POST['id_cat_business_unit'] : $unidad = 0;
            $identity_array = [
                "name" => $_POST['nombre'],
                "first_name" => $_POST["apellido_ap"],
                "second_name" => $_POST["apellido_am"],
                'phone' => $_POST['telefono'],
                'photo' => $name_image,
                'id_cat_business_unit' => $unidad,
                'id_user' => $id
            ];

            $identity = model('App\Models\Administrador\Identity_employed');
            $id_identity = $identity->insert($identity_array);
            $mensaje = messages($insert = 0, $id_identity);
            return $this->respond($mensaje);
        }
    }

    public function generate_token()
    {
        return bin2hex(random_bytes(24));
    }

    public function validar_email($email)
    {
        $model = model('App\Models\Administrador\Usuarios');
        $data = $model->select("email")->where("email", $email)->findAll();
        $total = count($data);
        return $total;
    }

    public function errors($error)
    {
        switch ($error):
            case 600:
                $mensaje = "LA IMAGEN DEBE PESAR 4 MG Y DEBE SER JPG,JPEG,PNG";
                break;
        endswitch;

        $data = [
            "status" => 400,
            "msg" => $mensaje
        ];

        return $data;
    }

    public function readUser()
    {
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $data = $this->model->getUser($id);
        return $this->respond($data);
    }

    public function update_()
    {
        $validation = \Config\Services::validation();
        $file = $this->request->getFile('image');
        if (!$file->isValid()) {
            $name_image = $_POST['name_foto'];
            $imagen = false;
        } else {
            // image validation
            $validated = $this->validate([
                'image' => [
                    'uploaded[image]',
                    'mime_in[image,image/jpg,image/jpeg,image/png]',
                    'max_size[image,4096]',
                    'is_image[image]'
                ],
            ]);

            if (!$validated) {
                $mensaje = $this->errors($error = 600);
                return $this->respond($mensaje);
            } else {
                $imagen = true;
            }
        }

        //validar contraseña//
        $password = $_POST['password'];
        if ($password != "") {
           // $password = $_POST['password'];
            $password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $password = $_POST['password_upd'];
           
        }
         $data = [
            'user_name' => $_POST['nombre'] . " " . $_POST["apellido_ap"],
            'id_group' => $_POST['grupo'],
            'password' => $password,
            'id' => $_POST['id_user'],
            'email' => $_POST['email'],
        ];

        if ($this->model->update($_POST['id_user'], $data) === false) {
            $error = $this->model->errors();

            $mensaje = [
                "status" => 400,
                "msg" => $error['email']
            ];
            return $this->respond($mensaje);
        } else {
            //$id = $this->model->getInsertID();
            $id_identity = $_POST['id_identity'];
            if ($imagen) {
                $path = "../public/images";
                $file->move($path, $file->getRandomName());
                $name_image = $file->getName();
            }

            $identity_array = [
                "name" => $_POST['nombre'],
                "first_name" => $_POST["apellido_ap"],
                "second_name" => $_POST["apellido_am"],
                'phone' => $_POST['telefono'],
                'photo' => $name_image,
                'id_cat_business_unit' => $_POST['id_cat_business_unit'],
            ];

            $identity = model('App\Models\Administrador\Identity_employed');
            $id_identity = $identity->update($id_identity,$identity_array);
            $affected_rows = $this->db->affectedRows();
            $mensaje = messages($update = 1, $affected_rows);
            return $this->respond($mensaje); 
        }
    }



    public function delete_()
    {
        $request = \Config\Services::request();
        $id = $request->getVar("id_delete");
        $this->model->delete($id);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje;
    }   
}
