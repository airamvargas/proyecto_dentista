<?php

namespace App\Models;

use CodeIgniter\Model;




class Model_proveedor extends Model
{

    protected $table      = 'proveedor';
    protected $primaryKey = 'id_proveedor';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['contact', 'contact','phone','embark','name_proveedor','Marca', 'email', 'logo','business_id'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function get_provedor()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('proveedor');
        $builder->select('*');
       
        //$builder->select('proveedor.*, business.business_name');
       // $builder->join('business', 'business.id = proveedor.business_id');
        $query = $builder->get();
        return $query->getResult();
    }


    public function insert_proveedor($datos_proveedor)
    {
        $Nombres = $this->db->table('proveedor');
        $Nombres->insert($datos_proveedor);
    }



    public function get_prove($idprove)
    {
       
        $db = \Config\Database::connect();
        $builder = $db->table('proveedor');
        $builder->select('*');
        $query = $builder->getWhere(['id_proveedor' => $idprove]);
        return $query->getResult();
    }

    public function update_provedor($id, $actualiza_provedor)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('proveedor');
        $builder->set($actualiza_provedor);
        $builder->where('id_proveedor', $id);
        $builder->update();
    }

    public function delete_prove($id_provedor)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('proveedor');
        $builder->delete(['id_proveedor' => $id_provedor]);
    }


    //Productos//

    public function obtener_productos()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('cat_products');
        $builder->select('*');
        //$builder->where('cat_products.deleted_at', '0000-00-00 00:00:00');
        $query = $builder->get();
        return $query->getResult();
       
    }

    //proveedor_x_products

    public function insert_pxp($data,$precio,$id_prove)
    {
       
        foreach( $data as $key => $n ) {
            $dataproductos[] = array (
                'id_product' => $n,
                'id_proveedor' => $id_prove,
                
                
            );
          }   

        $builder = $this->db->table('proveedor_x_products');
        $builder->insertBatch($dataproductos);
    
    }

    public function get_productos($idprovrdor)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('cat_products');
        $builder->select('proveedor_x_products.id, proveedor_x_products.id_product, cat_products.name,cat_products.model,cat_products.media_path,cat_products.ability,cat_products.english_name, cat_products.cost_china, cat_products.type, cat_products.model_china');
        $builder->join('proveedor_x_products', 'cat_products.id = proveedor_x_products.id_product');
        $builder->join('proveedor', 'proveedor_x_products.id_proveedor = proveedor.id_proveedor');
        $builder->where('proveedor_x_products.id_proveedor', $idprovrdor);
        //$builder->where('cat_products.deleted_at', '0000-00-00 00:00:00');
        $query = $builder->get();
        return $query->getResult();
       
    }

    public function getproduct($idproducto)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('proveedor_x_products');
        $builder->select('*');
        $query = $builder->getWhere(['id' => $idproducto]);
        return $query->getResult();
    }

   
    public function update_product($actualizar_producto,$id){
        $db = \Config\Database::connect();
        $builder = $db->table('proveedor_x_products');
        $builder->set($actualizar_producto);
        $builder->where('id', $id);
        $builder->update();

    }

    public function get_idpxp($id_provedor, $id_maquina){
        $db = \Config\Database::connect();
        $builder = $db->table('proveedor_x_products');
        $builder->select('id');
        $builder->where('id_proveedor', $id_provedor);
        $builder->where('id_product', $id_maquina);
        $query = $builder->get();
        return $query->getResult();
    }

    public function borrar($idproducto){
        $db = \Config\Database::connect();
        $builder = $db->table('proveedor_x_products');
        $builder->delete(['id' => $idproducto]);
    }

    public function get_empresa(){
        $db = \Config\Database::connect();
        $builder = $db->table('business');
        $builder->select('business.business_name,business.id');
        $query = $builder->get();
        return $query->getResult();
        

    }

    public function get_price($id){
        $db = \Config\Database::connect();
        $builder = $db->table('cat_products');
        $builder->select('*');
        $query = $builder->getWhere(['id' => $id]);
        return $query->getResult();

    }

    public function get_model_china($id){
        $db = \Config\Database::connect();
        $builder = $db->table('cat_products');
        $builder->select('*');
        $query = $builder->getWhere(['id' => $id]);
        return $query->getResult();
    }

    public function getProvedorEmpresa(){
        return $this->asArray()
        ->select('proveedor.*,business.business_name as empresa')
        ->join('business', 'business.id = proveedor.business_id')
        ->findAll();

    }

    public function getProvedor($idEmpresa){
        return $this->asArray()
        ->select('proveedor.id_proveedor,proveedor.name_proveedor')
        ->where('business_id',$idEmpresa)
        //->where('deleted_at','0000-00-00 00:00:00')
        ->findAll();

    }



    

}
