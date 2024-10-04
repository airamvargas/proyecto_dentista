<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class Insumos extends Model{
    protected $table      = 'insumos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name_table', 'id_product', 'id_category', 'name', 'cita', 'duration', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function readProductsCategoria($busqueda, $categoria){
        return $this->asObject()
        ->select('id, name')
        ->where('id_category', $categoria)
        ->like('name', $busqueda)    
        ->like("deleted_at","0000-00-00 00:00:00")
        ->findAll(100);
    }

    public function readProductsCotization($busqueda, $categoria, $convenio, $unidad) {
        $sql = "SELECT insumos.id, insumos.name, insumos.id_product, insumos.name_table, businessunit_x_products.price, (SELECT id_cat_condition_type FROM conditions_conventions JOIN 
		cat_conventions_x_products ON cat_conventions_x_products.id_cat_conventions = conditions_conventions.id_cat_conventions WHERE id_cat_company_client = :unidad: 
        AND conditions_conventions.id_cat_conventions = :convenio: AND id_category = :categoria: AND insumos.id = cat_conventions_x_products.id_cat_products AND conditions_conventions.deleted_at = 
        '0000-00-00 00:00:00' LIMIT 1) AS tipo_condicion, (SELECT value FROM conditions_conventions JOIN cat_conventions_x_products ON cat_conventions_x_products.id_cat_conventions 
        = conditions_conventions.id_cat_conventions WHERE id_cat_company_client = :unidad: AND conditions_conventions.id_cat_conventions = :convenio: AND id_category = :categoria: AND insumos.id = 
        cat_conventions_x_products.id_cat_products AND conditions_conventions.deleted_at = '0000-00-00 00:00:00' LIMIT 1) AS valor_condicion, (SELECT precio_convenio FROM cat_conventions_x_products 
        WHERE insumos.id = cat_conventions_x_products.id_cat_products AND id_cat_conventions = :convenio:) AS precio_convenio FROM insumos JOIN businessunit_x_products
        ON businessunit_x_products.id_product = insumos.id WHERE insumos.name LIKE '%" .$this->db->escapeLikeString($busqueda) . "%' AND id_category = :categoria: AND 
        businessunit_x_products.id_business_unit = :unidad: AND insumos.deleted_at = '0000-00-00 00:00:00' AND businessunit_x_products.deleted_at = '0000-00-00 00:00:00'";
        $datos = $this->db->query($sql, ['convenio' => $convenio, 'categoria' => $categoria, 'unidad' => $unidad]);
        return $datos->getResult();
    }

    public function getCategory($producto){
        return $this->asArray()->select('id_category')->where('id',$producto)->find();

    }

    public function getDuration($id){
		return $this->asArray()->select('duration')->where('id',$id)->find();

	}
}
