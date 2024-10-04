<?php

namespace App\Models\Administrador;

use CodeIgniter\Model;

class Modal_category_product extends Model{
    protected $table      = 'category_product';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function read(){
        return $this->asArray()
        ->select('*')
        ->findAll();
    }

}

?>
