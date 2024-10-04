<?php 
namespace App\Controllers\Api\Catalogos;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Catalogos\CondicionesConvenios as model;

class CondicionesConvenios extends ResourceController {
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
        $data["data"] = $this->model->getCondicionesConvenios();
        return $this->respond($data);        
    }

    //create empresas
    public function create() {
        $request = \Config\Services::request();
        $data = [
            'id_cat_conventions'=> $request->getPost('convenio'),
            'id_cat_company_client' => $request->getPost('unidad_negocio'),
            'id_category' => $request->getPost('categoria'),
            'id_cat_condition_type' => $request->getPost('tipo_condicion'),
            'value' => $request->getPost('valor') 
        ];
        //retun id
        $id = $this->model->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje); 
    }

    //Datos de una empresa creada
    public function readCondicionesConvenio(){
        //we get data from a single record
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $data = $this->model->getCondicionConvenio($id);
        return $this->respond($data);
    }
 
    //update empresas
    public function update_(){
        $request = \Config\Services::request();
        $id = $request->getVar("id");
        $data = [
            'id_cat_conventions'=> $request->getPost('upd_convenio'),
            'id_cat_company_client' => $request->getPost('upd_unidad_negocio'),
            'id_category' => $request->getPost('upd_categoria'),
            'id_cat_condition_type' => $request->getPost('upd_tipo_condicion'),
            'value' => $request->getPost('upd_valor')
        ];
        $this->model->update($id, $data);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje; 
    }

    //delete condiciones de convenio
    public function delete_(){        
        $request = \Config\Services::request();
        $id = $request->getVar("id_delete");
        $this->model->delete($id);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje;
    }   

   //Catalogo de convenios a mostrar en select
    public function getConvenios(){
        $convenios = model('App\Models\Catalogos\Convenios');
        $data = $convenios->getTableConvenios();
        return json_encode($data);
    }

    //Catalogo de unidades de negocio a mostrar en select
    public function getUnidad(){
        $unidades = model('App\Models\Catalogos\BusinessUnit');
        $data = $unidades->getBusinessUnits();
        return json_encode($data);
    }

    //Catalogo de categorias a mostrar en select
    public function getCategorias(){
        $categorias = model('App\Models\Catalogos\Categorias');
        $data = $categorias->getCategorias();
        return json_encode($data);
    }

    //Catalogo de tipos de condicion a mostrar en select
    public function getConditionType(){
        $condiciones = model('App\Models\Catalogos\ConditionType');
        $data = $condiciones->getConditionTypes();
        return json_encode($data);
    }   
}