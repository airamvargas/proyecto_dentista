<?php 

namespace App\Controllers\Api\Catalogos;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Catalogos\Cat_packets as model;

class Paquetes extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct() { //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }
    
    //CREAR UNA CATEGORIA DE ESTUDIO
    public function create(){ 
        $request = \Config\Services::request();
        $model_insumo = model('App\Models\Catalogos\Insumos');

        $data = [
            'preparation' => $request->getPost('description')
        ];

        $id_product = $this->model->insert($data);

        $data_insumo = [
            'name' => $request->getPost('name'),
            'name_table' => 'cat_packets',
            'id_product' => $id_product,
            'id_category' => $request->getPost('categoria')
        ];

        $id = $model_insumo->insert($data_insumo);

        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);
    }

    //FUNCION PARA DATATABLE
    public function readPackets(){
        $data['data'] = $this->model->readPackets();
        return $this->respond($data);
    }

    //OBTENER DATOS PARA ACTUALIZAR
    public function readPacket(){ 
        $id = $_POST['id'];
        $data = $this->model->readPacket($id);
        return $this->respond($data);
    }

    //EDITAR REGISTRO 
    public function update_(){ 
        $request = \Config\Services::request();
        $model_insumo = model('App\Models\Catalogos\Insumos');

        
        $data_insumo = [
            'name' => $request->getPost('name'),
            'id_category' => $request->getPost('categoria')
        ];

        $model_insumo->update($request->getPost('id_insumo'), $data_insumo);

        $data = [
            'preparation' => $request->getPost('description')
        ];

        $this->model->update($request->getPost('id'), $data);

       

        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje; 
    }

    //ELIMINAR REGISTRO
    public function delete_(){ 
        $request = \Config\Services::request();
        $model_insumo = model('App\Models\Catalogos\Insumos');

        $model_insumo->delete($request->getPost('id_insumo'));

        $this->model->delete($request->getPost('id'));
        
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje;
    }

    //MOSTRAR ESTUDIOS X PAQUETE
    public function show($id=NULL){
        $model = model('App\Models\Catalogos\Studies_x_packet');
        $id = $_POST['id_packet'];
        $data['data'] = $model->show($id);
        return $this->respond($data);
    }

    //INSERTAR ESTUDIO
    public function insert_study(){
        $model = model('App\Models\Catalogos\Studies_x_packet');
        $request = \Config\Services::request();

        $id_study = $request->getPost('id_study');
        $id_packet = $request->getPost('id_packet');

        $repetidos = $model->repetidos($id_packet, $id_study);

        if($repetidos[0]->repetido == 0){
            $data = [
                'id_packet' => $request->getPost('id_packet'),
                'id_study' => $request->getPost('id_study')
            ];
        
            $id = $model->insert($data);
            $mensaje = messages($insert = 0, $id);
        } else {
            $mensaje = [
                'status' => 400,
                'msg' => "EL ESTUDIO YA ESTA ASIGNADO A ESTE PAQUETE"
            ];

        }

        return $this->respond($mensaje);
    }

    //ELIMINAR ESTUDIO
    public function delete_study(){
        $model = model('App\Models\Catalogos\Studies_x_packet');
        $request = \Config\Services::request();
        $id = $request ->getVar("id_delete");
        $model->delete($id);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje; 
    }

    // ASIGNAR PRECIO
    public function updatePrice(){
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $suma = $request->getPost('suma');
        $bandera = isset($suma) ? 1  : 0;

        if($bandera == 0){
            $price_fijo = str_replace(",", "", $request->getPost('price'));
            $data = [
                'suma' => $bandera,
                'price' => $price_fijo,
                'sum_price' => 0,
                'descuento' => 0,
                'price_total' => 0
            ];
            
            $this->model->update($id, $data);

        } else {
            $price = str_replace(",", "", $request->getPost('total'));
            $price_final = str_replace(",", "", $request->getPost('price_total'));

            $data = [
                'suma' =>$bandera,
                'price' => 0,
                'sum_price' => $price,
                'descuento' => $request->getPost('descuento'),
                'price_total' => $price_final
            ];
            
            $this->model->update($id, $data);
        } 

        //var_dump($data);

        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje; 

        
    }
}