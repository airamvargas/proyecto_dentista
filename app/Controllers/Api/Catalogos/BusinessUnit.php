<?php 

namespace App\Controllers\Api\Catalogos;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');

class BusinessUnit extends ResourceController 
{
    use ResponseTrait;
    var $db;

    public function __construct()
    {
        //Assign global variables
        $this->db = db_connect();
        helper('messages');
    }
    
    //show data on tables
    public function read() {
        $model = model('App\Models\Catalogos\BusinessUnit');
        $data["data"] = $model -> getBusinessUnits(); 
        return $this->respond($data); 
    }

    //create a new element
    public function create(){
        $model = model('App\Models\Catalogos\BusinessUnit');
        $request = \Config\Services::request();

        $data = [
            'name'=> $request->getPost('nombre'),
            'description' => $request->getPost('description'),
            'start_time' => $request->getPost('start_time'),
            'final_hour' => $request->getPost('final_hour')
        ];

        $id = $model->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);
    }

    // read element to modify
    public function readBusinessUnit(){
        $model = model('App\Models\Catalogos\BusinessUnit');
        $request = \Config\Services::request();
        $id_bloodType = $request->getPost('id');
        $data = $model -> getBusinessUnit($id_bloodType);
        return $this->respond($data);

    }

    //update element
    public function update_(){
        $model = model('App\Models\Catalogos\BusinessUnit');
        $request = \Config\Services::request();
        $id = $request ->getVar("id");

        $data = [
            'name'=> $request->getPost('nombre'),
            'description'=> $request->getPost('description'),
            'start_time' => $request->getPost('start_time'),
            'final_hour' => $request->getPost('final_hour') 
        ];

        $model ->update($id, $data);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje; 
    }

    // delete element 
    public function delete_(){
        $model = model('App\Models\Catalogos\BusinessUnit');
        $request = \Config\Services::request();
        $id_category = $request ->getVar("id_delete");
        $model->delete($id_category);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje; 
     
    
    }

    //show products x business unit
    public function show($id = NULL){
        $model = model('App\Models\Catalogos\Products_x_unit');
        $id = $_POST['id_unidad'];
        $data['data'] = $model->show($id);
        return $this->respond($data);
    }

    //add products x business unit
    public function create_product(){
        $model = model('App\Models\Catalogos\Products_x_unit');
        $request = \Config\Services::request();

        $id_product = $request->getPost('id_product');
        $id_unit =  $request->getPost('id_unidad');
        $price = str_replace(",", "", $request->getPost('precio'));

        $repetidos = $model->repetidos($id_product, $id_unit);

        if($repetidos[0]->repetido == 0){
            $data = [
                'id_product' => $request->getPost('id_product'),
                'id_business_unit' => $request->getPost('id_unidad'),
                'price' => $price
            ];
        
            $id = $model->insert($data);
            $mensaje = messages($insert = 0, $id);
        } else {
            $mensaje = [
                'status' => 400,
                'msg' => "EL PRODUCTO Y/O SERVICIO YA FUE AGREGADO"
            ];
        }
        
        return $this->respond($mensaje);
    }

    // delete element 
    public function delete_product(){
        $model = model('App\Models\Catalogos\Products_x_unit');
        $request = \Config\Services::request();
        $id = $request ->getVar("id_delete");
        $model->delete($id);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje; 
    }

    //OBTENER SUMA DE ESTUDIOS 
    public function sumStudies(){
        $model = model('App\Models\Catalogos\Products_x_unit');
        $model_insumo = model('App\Models\Catalogos\Insumos');

        $id = $_POST['id'];
        $id_insumo = $_POST['product'];
        $id_unit = $_POST['unit'];

        $packet = $model_insumo->select('name_table, id_product')->where('id', $id_insumo)->find();
        $name_table = $packet[0]['name_table'];
        

        switch($name_table){
            case 'cat_studies': 
                $data = $model->getPriceStudy($id);
            break;
            case 'cat_packets':
                $id_product = $packet[0]['id_product'];
                $data = $model->getSumStudies($id, $name_table, $id_product, $id_unit);
                
            break;
            case 'cat_products': 
                $data = $model->getPriceStudy($id);
            break;
        }  
        
        return $this->respond($data); 
    }

    // ASIGNAR PRECIO
    public function updatePrice(){
        $request = \Config\Services::request();
        $model = model('App\Models\Catalogos\Products_x_unit');
        $id = $request->getPost('id');
        $price_fijo = str_replace(",", "", $request->getPost('price'));

        $data = [
            'price' => $price_fijo,
        ];
            
        $model->update($id, $data); 

        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje;
    }
  

    public function readBusiness(){
        $request = \Config\Services::request();
        $session = session();
        $user_id = $session->get('unique');
        $model_unidades = model('App\Models\HCV\Operativo\Unidad_negocio');
        $data = $model_unidades->get_unidades($user_id);
        return $this->respond($data); 
    }

    //Descargar archivo csv de los productos de cada unidad de negocio
    public function down_csv(){
        $model = model('App\Models\Catalogos\Products_x_unit');
        $uri = service('uri');
        $id_unit = $uri->getSegment(5);

        $data = $model->show($id_unit);
        $centinela = 0;
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Encoding: UTF-8');
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=csv_export.csv');

        $fp = fopen('php://output', 'w');
        fputs($fp, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF))); // UTF-8 BOM !!!!!

        $header = array(
            "Unidad", "Categoria", "Producto", "Precio");
        fputcsv($fp, $header);

        foreach ($data as $fields) {
            $centinela++;
            $lineData = array(
                $fields['unidad'], $fields['categoria'], $fields['producto'], $fields['price']
            );
            fputcsv($fp, $lineData);
        }
        fclose($fp);
        exit();
    }

}