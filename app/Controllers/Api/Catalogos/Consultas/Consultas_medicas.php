<?php 

namespace App\Controllers\Api\Catalogos\Consultas;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Product as model;
use App\Models\Catalogos\Insumos as insumo;

class Consultas_medicas extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;
    var $insumo;

    public function __construct() { //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }
    
    //Obtener categoria para los productos
    public function readCategoria(){
        $model = model('App\Models\Catalogos\Categorias');
        $data = $model->getCategorias();
        return $this->respond($data);
    }

    //Obtener disciplinas para las consultas
    public function readDisciplina(){
        $model = model('App\Models\HCV\Operativo\Disciplina');
        $data = $model->get_speciality();
        return $this->respond($data);
    }

    //CREAR UN NUEVO PRODUCTO
    public function create(){
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();
        $model_insumo = model('App\Models\Catalogos\Insumos');
        $model_medical = model('App\Models\Medical_consultation\Medical_consultation_setup');
        //var_dump($request);

        $data = [
            'description' => $request->getPost('descripcion'),
        ];

        $id_product = $this->model->insert($data);

        $data_insumo = [
            'name_table' => 'cat_products',
            'id_product' => $id_product,
            'id_category' => 3,
            'name' => $request->getPost('nombre'),
            'cita' => 1
        ];
        $id = $model_insumo->insert($data_insumo);

        $data_medical = [
            'name_table' => 'cat_products',
            'id_product' => $id_product,
            'id_discipline' => $request->getPost('disciplina')
        ];
        $model_medical->insert($data_medical);

        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);
    }

    //SERVER SIDE PARA LA TABLA DE PRODUCTOS
    public function read(){
        $request = \Config\Services::request();
        $model = model('App\Models\Product');
        $pager = \Config\Services::pager();
        $draw = $request->getVar('draw');//dibuja contador 
        $length = $request->getVar('length');//numero de registros que la tablla puede mostrar 
        $start = $request->getVar('start');//Primer registro de paginacion
        $search =  $request->getVar('search')['value'];//valor de busqueda global
        //$search2 =  $request->getVar('columns')[0]['search']['value'];//valor de la busqueda para aplicar a esa columna especifica

        $map_table =[
            0 => "id",
            1 => "categoria",
            2 => "producto",
            3 => 'description'  
        ];
       
        $query_result =  "SELECT insumos.id, id_product, category.name AS categoria, insumos.name AS producto, cat_products.description, media_path, stock FROM insumos 
        JOIN cat_products ON cat_products.id = insumos.id_product JOIN category ON category.id = insumos.id_category WHERE cat_products.deleted_at 
        = '0000-00-00 00:00:00' AND name_table LIKE '%cat_products%'";

        $condicion = "";

        $column0 =  $request->getVar('columns')[0]['search']['value'];
        $column1 =  $request->getVar('columns')[1]['search']['value'];
        $column2 =  $request->getVar('columns')[2]['search']['value'];
        $column3 =  $request->getVar('columns')[3]['search']['value'];

       //Buscador general 
        if(!empty($search)){
            foreach ($map_table as $key => $val){
                if($key == 0){
                   $condicion .= " HAVING ".$val." LIKE '%".$search."%'";
                } else {//OR name LIKE valor
                   $condicion .= " OR " .$val. " LIKE '%".$search."%'";
                }
           }
        } 

       $sql_data = $query_result.$condicion;
       $sql_count = $model->read($sql_data);
       $sql_count = count($sql_count);
       $sql_data .=   " ORDER BY " .$map_table[$request->getVar('order')[0]['column']]."
                       ".$request->getVar('order')[0]['dir']."" . " LIMIT ".$start. "," .$length.""; 
       $data = $model->read($sql_data);

       $response = [
           "draw" => $draw,
           "recordsTotal" => $sql_count ,
           "recordsFiltered" => $sql_count,
           "data" =>$data,
       ];   
       return $this->respond($response);

    }

    public function readUpdate(){
        $id = $_POST['id'];
        $data = $this->model->readUpdate($id);
        return $this->respond($data);
    }

    public function update_(){
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();
        $model_insumo = model('App\Models\Catalogos\Insumos');
        $model_medical = model('App\Models\Medical_consultation\Medical_consultation_setup');

        //ID DEL PRODUCTO A ACTUALIZAR //
        $id = $request->getPost('id_producto');
        $id_insumo = $request->getPost('id_insumo');
        $dat_medical = $model_medical->select('id')->like('name_table', 'cat_products')->where('id_product', $id)->find();
        
        $id_medical = $dat_medical[0]['id'];
            
        $data_medical = [
            'id_discipline' => $request->getPost('disciplina')
        ];

        $model_medical->update($id_medical, $data_medical);
        $data_insumo = [
            'id_category' => 3,
            'name' => $request->getPost('nombre'),
            'cita' => 1
        ];

        $model_insumo->update($id_insumo, $data_insumo);

        $data = [
            'description' => $request->getPost('descripcion')
        ];

        $this->model->update($id, $data);

        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje;
    } 

    public function delete_() {
        $model_insumo = model('App\Models\Catalogos\Insumos');
        $id = $_POST['id_delete'];
        $id_insumo = $_POST['id_insumo'];
        
        $model_insumo->delete($id_insumo);
        $id = $this->model->delete($id);

        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje; 
    }

    public function errors($error)
    {
        switch ($error):
            case 600:
                $mensaje = "LA IMAGEN DEBE PESAR 4 MB Y DEBE SER JPG,JPEG,PNG";
                break;
        endswitch;

        $data = [
            "status" => 400,
            "msg" => $mensaje
        ];

        return $data;
    }

}