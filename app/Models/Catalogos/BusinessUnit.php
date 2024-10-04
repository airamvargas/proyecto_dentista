<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class BusinessUnit extends Model{
    protected $table      = 'cat_business_unit';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'description', 'start_time', 'final_hour', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getBusinessUnits(){
        return $this->asArray()
			->select('id, name, description, start_time, final_hour')
			->findAll();
    }

    public function  getBusinessUnit($id_businessUnit){
        return $this->asArray()
			->select('id, name, description, start_time, final_hour')
			->where('id', $id_businessUnit)
			->find();
    }
}

?>