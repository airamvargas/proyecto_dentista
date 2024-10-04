<?php

namespace App\Controllers\Api\Administrador;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');

use App\Models\Administrador\Access as model;

class Access extends ResourceController
{
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct()
    {
        //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }

    public function index()
    {
        //datos de accesos del datatable
        $id = $_POST['id'];
        $model = model('App\Models\Administrador\Modules');
        $data['data'] = $model->getAccess($id);
        return $this->respond($data);
    }

    public function readModules()
    {   //catalogo del select de los modulos
        $model = model('App\Models\Administrador\Modules');
        $data = $model->showModules();
        return $this->respond($data);
    }

    public function create()
    {
        //creacion de los accessos
        $request = \Config\Services::request();
        $id_group = $_POST["id_group"];
        $id_module = $_POST['id_module'];
        $count =  $this->model->validateAcess($id_group, $id_module);
        //validate not exist in database
        if ($count->id_group == 0) {
            //insert data into data base
            $crear = $request->getPost('crear');
            $crear = isset($crear)  ? 1  : 0;
            $update = $request->getPost('update_a');
            $update = isset($update)  ? 1  : 0;
            $read = $request->getPost('read_a');
            $read = isset($read)  ? 1  : 0;
            $delete = $request->getPost('delete_a');
            $delete = isset($delete)  ? 1  : 0;
            
            $data = [
                'id_group' => $id_group,
                'id_module' => $id_module,
                'create_a' => $crear,
                'read_a' => $read,
                'update_a' => $update,
                'delete_a' => $delete
            ];

            $this->model->insert($data);
            $affected_rows = $this->db->affectedRows();

            if ($affected_rows > 0) {
                $data = [
                    "status" => 200,
                    "msg" => "AGREGADO CON EXITO"
                ];
                return $this->respond($data);
            } else {
                $data = [
                    "status" => 400,
                    "msg" => "ERROR AL AGREGAR"
                ];
                return $this->respond($data);
            }
        } else {
            $data = [
                "status" => 400,
                "msg" => "El MODULO YA EXISTE"
            ];
            return $this->respond($data);
        }
    }

    public function read()
    {
        //devulve los datos de una solo fila 
        $request = \Config\Services::request();
        $id_grupo = $request->getPost('id');
        $id_module = $request->getPost('id_module');
        $data = $this->model->read($id_grupo, $id_module);
        return $this->respond($data);
    }

    public function update_()
    {
        $request = \Config\Services::request();
        $id_group = $request->getPost("id_group");
        $id_module = $request->getPost("id_module");
        $crear = $request->getPost('crear');
        $crear = isset($crear)  ? 1  : 0;
        $update = $request->getPost('update_a');
        $update = isset($update)  ? 1  : 0;
        $read = $request->getPost('read_a');
        $read = isset($read)  ? 1  : 0;
        $delete = $request->getPost('delete_a');
        $delete = isset($delete)  ? 1  : 0;

        $data = [
            'create_a' => $crear,
            'read_a' => $read,
            'update_a' => $update,
            'delete_a' => $delete
        ];

        $validate = $this->model->updateAcess($data,$id_group,$id_module);
        //valida si se realizo la actualización en base de datos
        if($validate > 0){
            $data = [
                "status" => 200,
                "msg" => "ACTUALIZADO CON EXITO"
            ];
            return $this->respond($data);
        }else{
            $data = [
                "status" => 400,
                "msg" => "ERROR AL ACTUALIZAR"
            ];
            return $this->respond($data);
        }
    }

    public function delete_()
    {
        //delete Acess
        $request = \Config\Services::request();
        $id_group = $request->getPost("id_group");
        $id_module = $request->getPost("id_delete");
        $validate = $this->model->deleteAcess($id_group,$id_module);
        //valida si se elimino correcto el dato en base de datos
        if($validate > 0){
            $data = [
                "status" => 200,
                "msg" => "ELIMINADO CON EXITO"
            ];
            return $this->respond($data);
        }else{
            $data = [
                "status" => 400,
                "msg" => "ERROR AL ELIMINAR"
            ];
            return $this->respond($data);
        }
    }
}
