<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class ChronicDesseases extends Model{
    protected $table      = 'cat_chronic_conditions';
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

    public function getChronicDesseases(){
        return $this->asArray()
			->select('id, name, description')
			//->where('proveedor_id', $id_proveedor)
			->findAll();
    }

    public function  getChronicDesseas($id_chronicDessease){
        return $this->asArray()
			->select('id, name, description')
			->where('id', $id_chronicDessease)
			->find();
    }

}

?>