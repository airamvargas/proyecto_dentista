<?php 
namespace App\Controllers\Api\Catalogos;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Catalogos\Empresas as model;

class Empresas extends ResourceController {
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct(){
        //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }
        
    public function read(){    
        //data from the datatable
        $data["data"] = $this->model->getTableEmpresas();
        return $this->respond($data);        
    }

    //create empresas
    public function create() {
        $request = \Config\Services::request();
        $nombre = $request->getPost('nombre'); 
        $rfc = $request->getPost('rfc'); 
        $razon = $request->getPost('razon'); 
        $data = [
            'name' => strtoupper($nombre), //nombre de empresa a pasar en datatable
            'rfc' => strtoupper($rfc),
            'trade_name' => strtoupper($razon),
            'id_cat_fiscal_regime' => $request->getPost('regimen'),
            'email' => $request->getPost('correo'),
            'tel_contac' => $request->getPost('telefono'),
            'fiscal_address' => $request->getPost('direccion_fiscal')
        ];
        //retun id
        $id = $this->model->insert($data);
        if($id){
            $mensaje = [
                'status' => 200,
                'msg' => "AGREGADO CON EXITO",
                'nombre' => $nombre //nombre de la empresa registrado    
            ];
            return json_encode($mensaje);
        }else{
            $mensaje = [
                'status' => 400,
                'msg' => "Hubo un error al guardar los datos. Intenta de nuevo"    
            ];
            return json_encode($mensaje);
        }   
    }

    //Datos de una empresa creada
    public function readEmpresas(){
        //we get data from a single record
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $data = $this->model->getEmpresa($id);
        return $this->respond($data);
    }
 
    //update empresas
    public function update_(){
        $request = \Config\Services::request();
        $id = $request->getVar("id");
        $nom = $request->getPost('upd_nombre');
        $rfc_empresa = $request->getPost('upd_rfc'); 
        $razon_social = $request->getPost('upd_razon'); 
        $data = [
            'name' => strtoupper($nom),
            'rfc' => strtoupper($rfc_empresa),
            'trade_name' => strtoupper($razon_social),
            'id_cat_fiscal_regime' => $request->getPost('upd_regimen'),
            'email' => $request->getPost('upd_correo'),
            'tel_contac' => $request->getPost('upd_tel'),
            'fiscal_address' => $request->getPost('upd_domicilio')
        ];
        $this->model->update($id, $data);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje; 
    }

    //delete empresas
    public function delete_(){        
        $request = \Config\Services::request();
        $id = $request->getVar("id_delete");
        $this->model->delete($id);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje;
    }   

    //Catalogo de regimenes fiscales para mostrar en el modal
    public function getRegimenes(){
        $model = model('App\Models\Catalogos\FiscalRegime');
        $data = $model->get_fiscal_regime();
        return json_encode($data);
    }
    
}