<?php 

namespace App\Controllers\Api\Usuarios;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Administrador\Identity_employed as model;

class Ficha_identidad extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct() {
        //Assign global variables
        $this->db = db_connect();
        $this->model = new model();
        $this->usuarios = new \App\Models\Administrador\Usuarios();
        $this->users_empresas =  new \App\Models\Recolectoras\Usuarios();
        helper('messages');
    }
    
    //FUNCION PARA OBETENER LOS DATOS
    public function show($id = NULL){ 
        $session = session();
        $user_id = $session->get('unique');
        $parent = $this->usuarios->selectCount('id_parent')->where('id', $user_id)->where('id_parent != ', 0)->find()[0]['id_parent'];
        if($parent == 0){
            $data = $this->model->show($user_id);
        } else {
            $data = $this->users_empresas->show($user_id);
        }
        return $this->respond($data);
    }

    public function update($id = NULL){
        $session = session();
        $user_id = $session->get('unique');
        $request = \Config\Services::request();
        $id = $this->model->select('id, photo')->where('id_user', $user_id)->find();

        $file = $this->request->getFile('file_agente');

        if (!$file->isValid()) {
            $file_name = "";
            $imagen = false;
        } else {
            // image validation
            $validated = $this->validate([
                'file_agente' => [
                    'uploaded[file_agente]',
                    'mime_in[file_agente,image/jpg,image/jpeg,image/png]',
                    'max_size[file_agente,4096]',
                    'is_image[file_agente]'
                ],
            ]);

            if (!$validated) {
                $mensaje = $this->errors($error = 600);
                return $this->respond($mensaje);
            } else {
                $imagen = true;
            }
        }

        if($imagen) {
            $path =  '../public/images';
            if($id[0]['photo'] != "") {
                $filename = $path . $id[0]['photo'];
                unlink($filename);
            } 
            $newfile = $file->getRandomName();
            $file->move(WRITEPATH . $path, $newfile);
            $file_name = $file->getName(); 
        }


        $data = [
            'name' => $request->getPost('nombre'),
            'first_name' => $request->getPost('f_apellido'),
            'second_name' => $request->getPost('s_apellido'),
            'phone' => $request->getPost('telefono'),
            'photo' => $file_name
        ];

        $this->model->update($id[0]['id'], $data);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $this->respond($mensaje);  
    }
}