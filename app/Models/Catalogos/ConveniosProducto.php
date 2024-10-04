<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class ConveniosProducto extends Model {

    protected $table      = 'cat_conventions_x_products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_cat_products', 'id_cat_conventions', 'precio_convenio', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function readProductsConvenio($sql){
        return $this->db->query($sql)->getResult();
    }

    public function readProductsUpdate($id){
        return $this->asArray()
        ->select('cat_conventions_x_products.id, cat_conventions_x_products.id_cat_conventions, insumos.name AS producto, insumos.id_category,
        cat_conventions_x_products.id_cat_products, precio_convenio')
        ->join('insumos', 'insumos.id = cat_conventions_x_products.id_cat_products ')
        ->join('cat_conventions', 'cat_conventions_x_products.id_cat_conventions = cat_conventions.id')
        ->where('cat_conventions_x_products.id', $id)
        ->findAll();
    }

    public function show($sql){
        return $this->db->query($sql)->getResult();
        return $this->asArray()
        ->select('cat_conventions_x_products.id, cat_conventions.name AS convenio, insumos.name AS producto, category.name AS categoria, cat_conventions_x_products.precio_convenio')
        ->join('insumos', 'insumos.id = cat_conventions_x_products.id_cat_products ')
        ->join('category', 'category.id = insumos.id_category')
        ->join('cat_conventions', 'cat_conventions_x_products.id_cat_conventions = cat_conventions.id')
        ->where('cat_conventions_x_products.id_cat_conventions', $id)
        ->where('insumos.deleted_at', '0000-00-00 00:00:00')
        ->findAll();
    }

    public function readProducts_x_Convenio($id){
        return $this->asArray()
        ->select('cat_conventions_x_products.id, cat_conventions.name AS convenio, insumos.name AS producto, category.name AS categoria')
        ->join('insumos', 'insumos.id = cat_conventions_x_products.id_cat_products ')
        ->join('category', 'category.id = insumos.id_category')
        ->join('cat_conventions', 'cat_conventions_x_products.id_cat_conventions = cat_conventions.id')
        ->where('cat_conventions_x_products.id_cat_conventions', $id)
        ->where('insumos.deleted_at', '0000-00-00 00:00:00')
        ->findAll();
    }

    public function validacion($id_convenio, $id_insumo){
        return $this->asArray()
        ->select('cat_conventions_x_products.id')
        ->join('insumos', 'insumos.id = cat_conventions_x_products.id_cat_products ')
        ->where('cat_conventions_x_products.id_cat_conventions', $id_convenio)
        ->where('cat_conventions_x_products.id_cat_products', $id_insumo)
        ->where('insumos.deleted_at', '0000-00-00 00:00:00')
        ->find();
    }
}
?>