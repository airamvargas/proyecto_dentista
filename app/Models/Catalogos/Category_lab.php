<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class Category_lab extends Model{
    protected $table      = 'category_lab';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'description', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function readCategory(){
        return $this->asArray()
		->select('id, name, description')
		->findAll();
    }

    public function readExam($id){
        return $this->asArray()
		->select('id, name, description')
        ->where('id', $id)
		->findAll();
    }

    public function readGroups(){
        return $this->asArray()
		->select('id, name, description')
		->findAll();
    }


    public function readArea(){
        return $this->asArray()
		->select('id, name, description')
        /* ->where('id !=1') */
		->findAll();
    }
   
}

?>