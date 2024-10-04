<?php
/*
Desarrollador: Jesús Esteban Sánchez Alcántara
Fecha Creacion: 11 - octubre -2023
Fecha de Ultima Actualizacion: 21-03-2024
Actualizo: Airam V. Vargas Lopez
Perfil: Recoleccion
Descripcion: Catalogo de empresas recolectoras
*/

namespace App\Controllers\Api\Recolectoras;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');
helper('sendmail');

class Empresas extends ResourceController
{
    use ResponseTrait;
    var $db;
    var $model;
    var $users_company;
    var $users_model;

    public function __construct()
    {
        //Assign global variables
        $this->db = db_connect();
        $this->model = new \App\Models\Recolectoras\Empresas();
        $this->users_company = new \App\Models\Recolectoras\Usuarios();
        $this->users_model = new \App\Models\Administrador\Usuarios();
        helper('messages');
    }

    // Lista de empresas recolectoras
    public function index()
    {
        $data["data"] = $this->model->readEmpresas();
        return $this->respond($data);
    }

    //insert data into data base
    public function create()
    {
        $request = \Config\Services::request();
        $password = $this->random_password();
        $tipo =  $request->getPost('type');
        //$model =  $this->users_model;
        $password = password_hash($password, PASSWORD_DEFAULT);
        $token = password_hash($password, PASSWORD_DEFAULT);
        $code =  rand(100000, 999999);
        $val_code = $this->users_model->selectCount('code')->where('code', $code)->find();
        $newCode = $val_code == 1 ? rand(100000, 999999) : $code;

        $data_user = [
            'id_group' => 15,
            'user_name' => $request->getPost('name'),
            'email' => $request->getPost('correo'),
            'activation_token' => $token,
            'password' => $password,
            'active' => 1,
            'code' => $newCode
        ];

        if ($this->users_model->insert($data_user) === false) {
            $error = $this->users_model->errors();
            $mensaje = [
                "status" => 400,
                "msg" => $error['email']
            ]; 
            return $this->respond($mensaje);

        }else{
            $id_user = $this->users_model->getInsertID();
            $data = [
                'name' => $request->getPost('name'),
                'description' => $request->getPost('description'),
                'type' => 0,
                'id_user'=> $id_user
            ];
            //retun id
            $id = $this->model->insert($data);
            $mensaje = messages($insert = 0, $id);
            return $this->respond($mensaje);

        }
    }

    function random_password()
    {
        $random_characters = 2;

        $lower_case = "abcdefghijklmnopqrstuvwxyz";
        $upper_case = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $numbers = "1234567890";
        $symbols = "!@#%^*&";

        $lower_case = str_shuffle($lower_case);
        $upper_case = str_shuffle($upper_case);
        $numbers = str_shuffle($numbers);
        $symbols = str_shuffle($symbols);

        $random_password = substr($lower_case, 0, $random_characters);
        $random_password .= substr($upper_case, 0, $random_characters);
        $random_password .= substr($numbers, 0, $random_characters);
        $random_password .= substr($symbols, 0, $random_characters);

        return  str_shuffle($random_password);
    }

    // Datos de la empresa recolectora
    public function readCompany() {
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $data = $this->model->getCompany($id);
        return $this->respond($data);
    }

    // Actualiza datos de empresas recolectoras
    public function update_() {
        $request = \Config\Services::request();
        $id = $request->getPost("id");
        // Datos a actualizar en BD
        $data = [
            'name' => $request->getPost('name'),
            'email' => $request->getPost('email'),
            'description' => $request->getPost('description'),
            'type' => $request->getPost('type')
        ];
        $this->model->update($id, $data);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje;
    }

    // ELIMINAR EMPRESA RECOLECTORA
    public function delete_() {
        $request = \Config\Services::request();
        $id = $request->getPost("id");
        $this->model->delete($id);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje;
    }

    //Obtener grupos para usuarios de empresa recolectora
    public function getGroups() {
        $model_groups = model('App\Models\Administrador\Grupos');
        $data = $model_groups->select('id, name')->where('id >=', 11)->where('id <', 13)->findAll();
        return $this->respond($data);
    }

    //Insertar usuarios por empresa recolectora
    public function insertUser() {
        $request = \Config\Services::request();
        $model_users = model('App\Models\Administrador\Usuarios');
        $pass = $request->getPost('password');
        $email = $request->getPost('email');
        $file = $this->request->getFile('image');
        $user_name = $request->getPost('nombre') . " " . $request->getPost('apellido_ap') . " " . $request->getPost('apellido_am');
        $password = password_hash($request->getPost('password'), PASSWORD_DEFAULT);
        $token = password_hash($request->getPost('password'), PASSWORD_DEFAULT);
        $code =  rand(100000, 999999);
        $val_code = $model_users->selectCount('code')->where('code', $code)->find();
        $newCode = $val_code == 1 ? rand(100000, 999999) : $code;

        if (!$file->isValid()) {
            $file_name = "";
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

        if ($imagen) {
            $path =  '../public/images';
            $newfile = $file->getRandomName();
            $file->move(WRITEPATH . $path, $newfile);
            $file_name = $file->getName();
        }

        $data_users = [
            'id_group' => $request->getPost('grupo'),
            'user_name' => $user_name,
            'email' => $email,
            'password' => $password,
            'activation_token' => $token,
            'code' => $newCode,
            'id_parent' => $request->getPost('id_parent'),
            'active' => 1
        ];
        

        if ($this->users_model->insert($data_users) !=false) {
            $id_user = $this->users_model->getInsertID();
            $data_identity = [
                'id_user' => $id_user,
                'name' => $request->getPost('nombre'),
                'first_name' => $request->getPost('apellido_ap'),
                'second_name' => $request->getPost('apellido_am'),
                'phone' => $request->getPost('telefono'),
                'photo' => $file_name
            ];

            $id = $this->users_company->insert($data_identity);
        } else {
            $error = $this->users_model->errors();
            $mensaje = [
                "status" => 400,
                "msg" => $error['email']
            ]; 
            return $this->respond($mensaje);

        }

        if ($id) {
            $mensaje = "Estimad@ " . $user_name . ":<br><br>
            A continuación, te enviamos tus datos de acceso a nuestro portal: <br><br>
            USUARIO: " . $request->getPost('email') . "<br>
            CONTRASEÑA: " . $request->getPost('password') . "<br><br>
            <a href='" . base_url() . "'>'" . base_url() . "'<a><br><br>";
            $asunto = "DATOS DE USUARIO";
            $file = [];
            $envio = send_email($email, $asunto, $mensaje, $file);
            if ($envio) {
                $response = [
                    "status" => 200,
                    "msg" => "USUARIO REGISTRADO"
                ];
                return $this->respond($response);
            }
        }
    }

    //api de usuarios
    public function getUsers($id_parent){
        $data["data"] = $this->users_model->getUsersExternal($id_parent);
        return $this->respond($data); 
    } 

    //api ver datos del usuario para actualizar
    public function showUser(){
        $id_user = $_POST['id'];
        $data = $this->users_model->showUserBuss($id_user);
        return $this->respond($data); 
    }

    //Actualizacion de datos del usuario
    public function updateUser() {
        $request = \Config\Services::request();
        $model_users = model('App\Models\Administrador\Usuarios');
        $pass = $request->getPost('password');
        $email = $request->getPost('email');
        $file = $this->request->getFile('image');
        $user_name = $request->getPost('nombre') . " " . $request->getPost('apellido_ap') . " " . $request->getPost('apellido_am');

        if (!$file->isValid()) {
            $file_name = $request->getPost('name_photo');
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

        if ($imagen) {
            $path =  '../public/images';
            $newfile = $file->getRandomName();
            $file->move(WRITEPATH . $path, $newfile);
            $file_name = $file->getName();
        }

        $data_users = [
            'id_group' => $request->getPost('grupo'),
            'user_name' => $user_name,
        ];
        
        //$this->users_model->update($request->getPost('id_update_user'), $data_users);

        if ($this->users_model->update($request->getPost('id_update_user'), $data_users) != false) {
            $data_identity = [
                'name' => $request->getPost('nombre'),
                'first_name' => $request->getPost('apellido_ap'),
                'second_name' => $request->getPost('apellido_am'),
                'phone' => $request->getPost('telefono'),
                'photo' => $file_name
            ];

            $id = $this->users_company->update($request->getPost('id_update'), $data_identity);
        } else {
            $error = $this->users_model->errors();
            $mensaje = [
                "status" => 400,
                "msg" => $error['email']
            ]; 
            return $this->respond($mensaje);

        }

        if ($id) {
            $response = [
                "status" => 200,
                "msg" => "USUARIO ACTUALIZADO"
            ];
            return $this->respond($response);
        } else {
            $response = [
                "status" => 400,
                "msg" => "USUARIO REGISTRADO"
            ];
            return $this->respond($response);
        }
    }

    // ELIMINAR EMPRESA RECOLECTORA
    public function deleteUser() {
        $request = \Config\Services::request();
        $id_user = $request->getPost('id_user');
        $id = $request->getPost("id");
        $this->users_model->delete($id_user);
        $this->users_company->delete($id);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        if($affected_rows > 0){
            $response = [
                "status" => 200,
                "msg" => "USUARIO ACTUALIZADO"
            ];
            return $this->respond($response);
        } else {
            $response = [
                "status" => 400,
                "msg" => "HUBO UN ERROR, INTENTE DE NUEVO"
            ];
            return $this->respond($response);
        }
    }
}
