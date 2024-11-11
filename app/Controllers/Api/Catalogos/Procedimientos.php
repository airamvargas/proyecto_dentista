<?php 

namespace App\Controllers\Api\Catalogos;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Catalogos\Model_tratamientos as model;

class Procedimientos extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct() { //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }
    
    //CREAR UN PROCEDIMIENTO
    public function add_procedimiento(){ 
        $request = \Config\Services::request();

        $data = [
            'nombre' => $request->getPost('nombre_proc'),
            'precio' => $request->getPost('precio'), 
            'observaciones' => $request->getPost('observacion')
        ];

        $id = $this->model->insert($data);

        if($id){
            $mensaje = [
              'status' => 200,
              'msg' => "DATOS AGREGADOS",
              'id' => $id
            ];
            return $this->respond($mensaje);
        }else{
            $mensaje = [
                'status' => 400,
                'msg' => "Hubo un error al guardar los datos. Intenta de nuevo",    
            ]; 
            return $this->respond($mensaje);      
        } 
    }

    //FUNCION PARA DATATABLE
    public function read(){
        $data['data'] = $this->model->readProcedimientos();
        return $this->respond($data);
    }

    //OBTENER DATOS PARA ACTUALIZAR
    public function readProcedimientoUp(){ 
        $id = $_POST['id'];
        $data = $this->model->readProcedimientoUp($id);
        return $this->respond($data);
    }

    //EDITAR REGISTRO 
    public function update_(){ 
        $request = \Config\Services::request();
        $id = $request->getPost('id_update');

        $data = [
            'nombre' => $request->getPost('nombre_proc'),
            'precio' => $request->getPost('precio'), 
            'observaciones' => $request->getPost('observacion')
        ];

        $this->model->update($id, $data);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        if($affected_rows){
            $mensaje = [
              'status' => 200,
              'msg' => "DATOS AGREGADOS",
              'id' => $id
            ];
            return $this->respond($mensaje);
        } else{
            $mensaje = [
                'status' => 400,
                'msg' => "Hubo un error al guardar los datos. Intenta de nuevo",    
            ]; 
            return $this->respond($mensaje);      
        } 
    }

    //ELIMINAR REGISTRO
    public function delete_(){ 
        $request = \Config\Services::request();
        $this->model->delete($request->getPost('id'));
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        if($affected_rows){
            $mensaje = [
              'status' => 200,
              'msg' => "DATOS AGREGADOS",
              'id' => $id
            ];
            return $this->respond($mensaje);
        } else{
            $mensaje = [
                'status' => 400,
                'msg' => "Hubo un error al guardar los datos. Intenta de nuevo",    
            ]; 
            return $this->respond($mensaje);      
        }
    }

    //FUNCION BUSQUEDA PARA AUTOCOMPLETE
    public function readTratamiento($busqueda){
        $data = $this->model->readTratamiento($busqueda);
        return $this->respondCreated($data, 200);    
    }
}