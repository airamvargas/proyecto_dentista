<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class CondicionesConvenios extends Model{
    protected $table = 'conditions_conventions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'id_cat_conventions', 'id_cat_company_client', 'id_category', 'id_service', 'id_cat_condition_type', 'value', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    //Informacion de los convenios pertenecientes a una empresa
    public function getCondicionesConvenios(){
        return $this->asArray()
        ->select('conditions_conventions.*, cat_conventions.name as nombre_convenio, cat_business_unit.name as unidad_negocio, category.name as nombre_producto, cat_condition_type.name as nombre_condicion')
        ->join('cat_conventions','conditions_conventions.id_cat_conventions = cat_conventions.id')
        ->join('cat_business_unit','conditions_conventions.id_cat_company_client = cat_business_unit.id')
        ->join('category','conditions_conventions.id_category = category.id')
        /* ->join(' ','conditions_conventions.id_service = category.id') */
        ->join('cat_condition_type','conditions_conventions.id_cat_condition_type = cat_condition_type.id')
        ->where('cat_conventions.deleted_at', '0000-00-00 00:00:00')
		->findAll();
    }

    //Informacion de una empresa en particular para poner los datos en el modal
    public function getCondicionConvenio($id_convenio){
        return $this->asArray()
			->select('*')
			->where('id', $id_convenio)
			->find();
    }

    public function readCondiciones(){
        return $this->asArray()
        ->select('id, name')
        ->findAll();
    }

    public function getCondicionesIndividual($id){
        return $this->asArray()
        ->select('conditions_conventions.*, cat_conventions.name as nombre_convenio, cat_business_unit.name as unidad_negocio, category.name as nombre_producto, cat_condition_type.name as nombre_condicion')
        ->join('cat_conventions','conditions_conventions.id_cat_conventions = cat_conventions.id')
        ->join('cat_business_unit','conditions_conventions.id_cat_company_client = cat_business_unit.id')
        ->join('category','conditions_conventions.id_category = category.id')
        /* ->join(' ','conditions_conventions.id_service = category.id') */
        ->join('cat_condition_type','conditions_conventions.id_cat_condition_type = cat_condition_type.id')
        ->where('id_cat_conventions', $id['id'])
		->findAll();
    }

    //Condiciones de un unico convenio
    public function condicionIndividual($id){
        return $this->asArray()
        ->select('conditions_conventions.*, cat_conventions.name as nombre_convenio, cat_business_unit.name as unidad_negocio, category.name as nombre_producto, cat_condition_type.name as nombre_condicion')
        ->join('cat_conventions','conditions_conventions.id_cat_conventions = cat_conventions.id')
        ->join('cat_business_unit','conditions_conventions.id_cat_company_client = cat_business_unit.id')
        ->join('category','conditions_conventions.id_category = category.id')
        ->join('cat_condition_type','conditions_conventions.id_cat_condition_type = cat_condition_type.id')
        ->where('id_cat_conventions', $id)
        ->findAll();
    }

}

?>