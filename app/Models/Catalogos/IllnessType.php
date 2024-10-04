<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class IllnessType extends Model{
    protected $table      = 'cat_illness_type';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'description', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    //
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getIllnessTypes(){
        return $this->asArray()
			->select('id, name, description')
			//->where('proveedor_id', $id_proveedor)
			->findAll();
    }

    public function  getIllnessType($id_illnessType){
        return $this->asArray()
			->select('id, name, description')
			->where('id', $id_illnessType)
			->find();
    }
}

?>

