<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class Products_x_unit extends Model{
    protected $table      = 'businessunit_x_products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_product', 'id_business_unit', 'price', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    //
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function show($id){
        return $this->asArray()
		->select('businessunit_x_products.id, businessunit_x_products.id_product, cat_business_unit.name AS unidad, insumos.name AS producto, businessunit_x_products.price, category.name AS categoria')
		->join('cat_business_unit', 'cat_business_unit.id = businessunit_x_products.id_business_unit')
        ->join('insumos', 'insumos.id = businessunit_x_products.id_product')
        ->join('category', 'category.id = insumos.id_category')
        ->where('businessunit_x_products.id_business_unit', $id)
        ->where('insumos.deleted_at', '0000-00-00 00:00:00')
		->findAll();
    }

    public function repetidos($id_product, $id_unit){
        $sql = "SELECT COUNT(*) AS repetido FROM businessunit_x_products WHERE id_product = :product: AND id_business_unit = :unit: AND deleted_at = '0000-00-00 00:00:00'";
        $datos = $this->db->query($sql, ['product' => $id_product, 'unit' => $id_unit]);
        return $datos->getResult();
    }

    public function getPriceStudy($id){
        return $this->asArray()
        ->select('insumos.name, businessunit_x_products.price')
        ->join('insumos', 'insumos.id = businessunit_x_products.id_product')
        ->where('businessunit_x_products.id', $id)
        ->find();
    }

    public function getSumStudies($id, $name_table, $id_product, $id_unit){
        $sql = "SELECT (SELECT name FROM insumos WHERE name_table LIKE '%".$name_table."%' AND insumos.id_product = :product: AND deleted_at ='0000-00-00 00:00:00') AS packet, SUM(businessunit_x_products.price) 
        AS suma, (SELECT businessunit_x_products.price FROM businessunit_x_products WHERE businessunit_x_products.id = :id:) AS price FROM studies_x_packet JOIN cat_studies ON cat_studies.id = studies_x_packet.id_study JOIN insumos ON insumos.id_product = 
        cat_studies.id JOIN businessunit_x_products ON businessunit_x_products.id_product = insumos.id WHERE studies_x_packet.id_packet = :product: AND 
        insumos.name_table LIKE '%cat_studies%' AND businessunit_x_products.id_business_unit = :unit: AND studies_x_packet.deleted_at = 
        '0000-00-00 00:00:00' AND businessunit_x_products.deleted_at = '0000-00-00 00:00:00'";
        $datos = $this->db->query($sql, ['id' => $id, 'product' => $id_product, 'unit' => $id_unit]);
        return $datos->getResult();
    }
}

?>