<?php

/*namespace App\Models;

use CodeIgniter\Model;

class Model_Compras extends Model
{
    protected $table = 'proveedor_x_products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_product', 'id_proveedor','supplier_price'];
    
    


    /*function getAll(){
        return $this->asArray()
        ->select('proveedor_x_products.id,proveedor_x_products.supplier_price,cat_products.name,cat_products.type,cat_products.model,cat_products.media_path,cat_products.ability,business.business_name')
        ->join('cat_products', 'cat_products.id = proveedor_x_products.id_product')
        ->join('proveedor', 'proveedor_x_products.id_proveedor = proveedor.id_proveedor');
        
    }


    
}*/

    namespace App\Models;

    use CodeIgniter\Model;




    class Model_Compras extends Model
    {
        //Productos x proveedor
        public function products_x_proveddor(){
            
            $db = \Config\Database::connect();
            $builder = $db->table('proveedor_x_products');
            $builder->select('proveedor_x_products.id,proveedor_x_products.supplier_price,cat_products.name,cat_products.type,cat_products.model,cat_products.media_path,cat_products.ability,business.business_name');
            $builder->join('cat_products', 'cat_products.id = proveedor_x_products.id_product');
            $builder->join('proveedor', 'proveedor_x_products.id_proveedor = proveedor.id_proveedor');
            $builder->join('business', 'business.id = proveedor.business_id');
            //$builder->where('proveedor_x_products.id_proveedor', $idprovrdor);
            $query = $builder->get();
            return $query->getResult();


        }

        public function addcar($json){
            $compra = $this->db->table('buys_x_proveedor');
            $compra->insert($json);

        }

        public function get_products($idvende){
            $db = \Config\Database::connect();
            $builder = $db->table('buys_x_proveedor');
            $builder->select('buys_x_proveedor.id,buys_x_proveedor.price,cat_products.name,cat_products.media_path');
            $builder->join('proveedor_x_products', 'proveedor_x_products.id = buys_x_proveedor.pro_x_product');
            $builder->join('cat_products', 'cat_products.id = proveedor_x_products.id_product');
            $builder->where('buys_x_proveedor.user_id', $idvende);
            $query = $builder->get();
            return $query->getResult();

        }
    }


?>    