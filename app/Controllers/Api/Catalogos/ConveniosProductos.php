<?php 

namespace App\Controllers\Api\Catalogos;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Catalogos\ConveniosProducto as model;

class ConveniosProductos extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $convenio;
    var $db;

    public function __construct() { //Assign global variables
        $this->model = new model();
        $this->convenio = new \App\Models\Catalogos\Convenios();
        $this->db = db_connect();
        helper('messages');
    }

    public function readProductsConvenio(){ //FUNCION PARA DATATABLE
        $request = \Config\Services::request();
        $pager = \Config\Services::pager();
        $draw = $request->getVar('draw');//dibuja contador 
        $length = $request->getVar('length');//numero de registros que la tablla puede mostrar 
        $start = $request->getVar('start');//Primer registro de paginacion
        $search =  $request->getVar('search')['value'];//valor de busqueda global
        //$search2 =  $request->getVar('columns')[0]['search']['value'];//valor de la busqueda para aplicar a esa columna especifica
        $map_table =[
            0 => "categoria",
            1 => "convenio",
            2 => "producto",
            3 => 'precio_convenio',
            4 => 'id'
        ];
       
        $query_result =  "SELECT cat_conventions_x_products.id, cat_conventions.name AS convenio, insumos.id AS id_producto, insumos.name AS producto, category.name AS categoria, precio_convenio
        FROM cat_conventions_x_products JOIN insumos ON insumos.id = cat_conventions_x_products.id_cat_products JOIN category ON category.id = insumos.id_category JOIN
        cat_conventions ON cat_conventions_x_products.id_cat_conventions = cat_conventions.id WHERE insumos.deleted_at IS NULL AND cat_conventions_x_products.deleted_at IS NULL";

        $condicion = "";

        $column0 =  $request->getVar('columns')[0]['search']['value'];
        $column1 =  $request->getVar('columns')[1]['search']['value'];
        $column2 =  $request->getVar('columns')[2]['search']['value'];
        $column3 =  $request->getVar('columns')[3]['search']['value'];
        $column4 =  $request->getVar('columns')[4]['search']['value'];

      
        //Buscador por columnas
        /*if(!empty($column0) or !empty($column1) or !empty($column2) or !empty($column3)){
            foreach ($map_table as $key => $val){
                if($key == 0){
                    $condicion .= " HAVING ".$val." LIKE '%".$column0."%'";
                } else {//OR name LIKE valor
                    $condicion .= " AND " .$val. " LIKE '%".$request->getVar('columns')[$key]['search']['value']."%'";
                }
            }
        }*/

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
        $sql_count = $this->model->readProductsConvenio($sql_data);
        $sql_count = count($sql_count);
        $sql_data .=   " ORDER BY " .$map_table[$request->getVar('order')[0]['column']]."
                        ".$request->getVar('order')[0]['dir']."" . " LIMIT ".$start. "," .$length.""; 
        $data = $this->model->readProductsConvenio($sql_data);

        $response = [
            "draw" => $draw,
            "recordsTotal" => $sql_count ,
            "recordsFiltered" => $sql_count,
            "data" =>$data
        ]; 

        return $this->respondCreated($response);
        //$data['data'] = $this->model->readProductsConvenio();
        //return $this->respond($data);
    }
    
    public function create(){ // CREAR UN PRODUCTO X CONVENIO
        $request = \Config\Services::request();
        $validacion = $this->model->selectCount('id_cat_products')->where('id_cat_products', $request->getPost('id_product'))
        ->where('id_cat_conventions', $request->getPost('convenio'))->find()[0]['id_cat_products'];
        
        if($validacion > 0){
            $mensaje = [
                'status' => 400,
                'msg' => "EL PRODUCTO O SERVICIO YA ESTA ASIGNADO A ESTE CONVENIO"
            ];
        } else {
            
            $data = [
                'id_cat_products' => $request->getPost('id_product'),
                'id_cat_conventions' => $request->getPost('convenio'),
                'precio_convenio' => $request->getPost('precio_convenio')
            ];

            $id = $this->model->insert($data);

            $mensaje = messages($insert = 0, $id);
        }
        return $this->respond($mensaje); 
    }

    public function readProductsUpdate(){ //OBTENER DATOS PARA ACTUALIZAR
        $id = $_POST['id'];
        $data = $this->model->readProductsUpdate($id);
        return $this->respond($data);
    }

    public function update_(){ //EDITAR REGISTRO DEL PRODUCTO X CONVENIO
        $request = \Config\Services::request();

        $data = [
            'id_cat_products' => $request->getPost('id_product_update'),
            'id_cat_conventions' => $request->getPost('convenio'),
            'precio_convenio' => $request->getPost('precio_convenio')
        ];

        $this->model->update($request->getPost('id_update'), $data);

        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje; 
    }

    public function delete_(){ //ELIMINAR REGISTRO DE PRODUCTO X CONVENIO
        $request = \Config\Services::request();

        $this->model->delete($request->getPost('id_delete'));

        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje;
    }

    public function readProducts_x_convenio(){
        $id = $_POST['id'];
        $data['data'] = $this->model->readProducts_x_Convenio($id);
        return $this->respond($data);
    }

    //subir archivo csv para actualizar datos
    public function subirArchivo(){
        $request = \Config\Services::request();
        $model_conv_prod = model('App\Models\Catalogos\ConveniosProducto');
        $model_insumos = model('App\Models\Catalogos\Insumos');
        $productos = array();
        $data['errores'] = [];
        $d_final = [];
        
        //Archivo comprobante del pago
        $archivo = $this->request->getFile('archivo');
        //var_dump($archivo);

        if(!$archivo->isValid()){
            $data['status'] = [
                "status" => 400,
                "msg" => "El archivo no es válido"
            ];
            return $this->respond($data);
        } else{
            $file_name = $archivo->getTempName();
            $csv_data = array_map('str_getcsv', file($file_name));
            if (count($csv_data) > 0) {
                $index = 0;
                foreach ($csv_data as $datos) {
                    
                    if ($index > 0) {
                        $productos[] = array(
                            "id_prod_conv" => $datos[0],
                            "categoria" => $datos[1],
                            "convenio" => $datos[2],
                            "id_insumo" => $datos[3],
                            "insumo" => $datos[4],
                            "precio" => $datos[5]
                        );
                    }
                    $index++;
                }
                

                foreach($productos as $newData){
                    $arr = [",", "$"];
                    $precio = str_replace($arr, "", $newData['precio']);
                    $id_convenio = $this->convenio->select('id')->like('name', $newData['convenio'])->find()[0]['id'];
                    $validacion2 = $model_conv_prod->validacion($id_convenio, $newData['id_insumo']);
                    
                    if(!empty($validacion2)){
                        if($validacion2[0]['id'] == $newData['id_prod_conv']){
                            $d_final[] = $validacion2[0]['id'];
                        } else {
                            $data['errores'][] = $newData['id_prod_conv'];
                        }
                    } else {
                        $data['errores'][] = $newData['id_prod_conv'];
                    }
                }
                
                if(!empty($data['errores'])){
                    $data['status'] = [
                        "status" => 400,
                        "msg" => "LOS DATOS NO PUEDEN SER ACTUALIZADOS"
                    ];
                    //var_dump($data);
                    return $this->respond($data);
                } else {
                    foreach($productos as $newData){
                        $arr = [",", "$"];
                        $precio = str_replace($arr, "", $newData['precio']);
                       
                        $data_price[] = [
                            'id' => $newData['id_prod_conv'],
                            'precio_convenio' => $precio
                        ];
                        //$model_conv_prod->update($newData['id_prod_conv'], $data_price);
    
                        $data_name[] = [
                            'id' => $newData['id_insumo'],
                            'name' => $newData['insumo']
                        ];
                        //$model_insumos->update($newData['id_insumo'], $data_name);
                        //var_dump($newData['id_prod_conv']);
                    }
                   
                    $model_conv_prod->updateBatch($data_price, 'id');
                    $model_insumos->updateBatch($data_name, 'id');

                    $affected_rows = $this->db->affectedRows();
                    if($affected_rows){
                        $data['status']  = [
                            "status" => 200,
                            "msg" => "DATOS ACTUALIZADOS"
                        ];
                        //var_dump($response);
                        return $this->respond($data);
                    } else {
                        $data['status'] = [
                            "status" => 400,
                            "msg" => "ERROR EN EL SERVIDOR"
                        ];
                        //var_dump($response);
                        return $this->respond($data);
                    }    
                }
            } else {
                $data['status'] = [
                    "status" => 400,
                    "msg" => "EL ARCHIVO ESTA VACÍO"
                ];
                //var_dump($response);
                return $this->respond($data);
            }   
        }
    }
}