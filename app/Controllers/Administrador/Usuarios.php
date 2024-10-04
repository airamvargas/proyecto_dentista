<?php

namespace App\Controllers\Administrador;

use App\Controllers\BaseController;

class Usuarios extends BaseController
{

    public function index()
    {
        //call to helper menu
        helper('menu');
        //metod session
        $session = session();
        //api path
        $controller = "Api/Administrador/Usuarios";
        //variables
        $data_header['title'] = "USUARIOS";
        $data_header['wiki_controller'] = "books/back-office/page/usuarios";
        $data_header['description'] = "Catálogo de usuarios";
        $data_left['menu'] = get_menu();
        $data_fotter['controlador'] = $controller;
        //Documents javascript 
        $data_fotter['scripts'] = [
            "../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js",
            "dashboard.js", "Generales/CRUD.js", "Administrador/Usuarios.js"
        ];
        //External js
        $data_fotter['external_scripts'] = ["https://cdn.jsdelivr.net/npm/toastify-js","https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "botones.css", "../lib/datatables/jquery.dataTables.css","solimaq.css"];
        //External css//
        $data_header['external_styles']=["https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css","https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.02.min.css"];
        //Loads Views
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Administrador/Usuarios');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter); 
    }

   

    /* public function get_grupos()
    {
        $model = model('App\Models\Administrador\Grupos');
        $data = $model->get_grupos();
        return json_encode($data);
    }

    public function get_usuarios()
    {
        $model = model('App\Models\Administrador\Usuarios');
        $data['data'] = $model->users();
        return json_encode($data);
    }

    public function save_user()
    {
        $model = model('App\Models\Administrador\Usuarios');
        $request = \Config\Services::request();
        $email =  $request->getPost('email');
        $validar = $this->validar_email($email);

        if ($validar == 0) {
            $token = $this->generate_token();

            $file = $this->request->getFile('file');
            if ($file->getsize() > 0) {
                $path = "../public/images";
                $file->move($path, $file->getRandomName());
                $name_photo = $file->getName();
            } else {
                $name_photo = "";
            }

            $password =  $request->getPost('contrasena');
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $datos = [
                "user_name" => $request->getPost('nombre'),
                "id_group" => $request->getPost('grupo'),
                "password" => $hashed_password,
                'activation_token' => $token,
                'photo' => $name_photo,
                'telefono' => $request->getPost('telefono'),
                'email' => $email,
                'active' => 1,
                'business_id' => $request->getPost('empresa')

            ];


            $id = $model->insert($datos);

            if ($id) {
                $data = [
                    "status" => 200,
                    "msg" => "USUARIO AGREGADO CON EXITO"
                ];
                return json_encode($data);
            } else {
                $data = [
                    "status" => 400,
                    "msg" => "ERROR AL AGREGAR PRODUCTO"
                ];
                return json_encode($data);
            }
        } else {
            $data = [
                "status" => 201,
                "msg" => "EL CORREO YA EXISTE"
            ];
            return json_encode($data);
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

    public function get_data_user()
    {
        $model = model('App\Models\Administrador\Usuarios');
        $request = \Config\Services::request();
        $id =  $request->getPost('id');
        $data =  $model->get_user($id);
        return json_encode($data);
    }

    public function update_user()
    {
        $model = model('App\Models\Administrador\Usuarios');
        $request = \Config\Services::request();
        $file = $this->request->getFile('file');
        $id =  $request->getPost('id');
        $data =  $model->get_user($id);
        $email =  $request->getPost('email');
        $password =  $request->getPost('pass');
        $path = "../public/images/";

        if ($email == $data[0]->email) {
            $email =  $request->getPost('email');
        } else {
            $validar = $this->validar_email($email);
            if ($validar != 0) {
                $data = [
                    "status" => 201,
                    "msg" => "EL CORREO YA EXISTE"
                ];
                return json_encode($data);
            }
        }

        if ($password == $data[0]->password) {
            $password =  $request->getPost('pass');
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }

        if (!$file->isValid()) {
            $img = $request->getPost('name_foto');
        } else {
            $img = $request->getPost('name_foto');
            $filename = $path . $img;
            unlink($filename);
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . $path, $newName);
            $img = $file->getName();
        }

        $datos = [
            "user_name" => $request->getPost('nombre'),
            "id_group" => $request->getPost('grupo'),
            "password" => $password,
            'photo' => $img,
            'telefono' => $request->getPost('telefono'),
            'email' => $email,
            'business_id' => $request->getPost('empresa')

        ];

        $upd = $model->update($id, $datos);
        if ($upd) {
            $data = [
                "status" => 200,
                "msg" => "USUARIO ACTUALIZADO CON EXITO"
            ];
            return json_encode($data);
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR AL AGREGAR USUARIO"
            ];
            return json_encode($data);
        }
    }

    public function delete_user(){
        $request = \Config\Services::request();
        $model = model('App\Models\Administrador\Usuarios');
        $id = $request->getPost('id_delete');
        $new_id =  $model->delete($id);

        if ($new_id) {
            $data = [
                "status" => 200,
                "msg" => "USUARIO BORRADO CON EXITO"
            ];
            return json_encode($data);
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR AL BORRAR USUARIO"
            ];
            return json_encode($data);
        }

        
    } */
}
