<?php

namespace App\Models\Models_hcv;

use CodeIgniter\Model;

class Model_alergias extends Model
{
    protected $table = 'hcv_alergias';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_cat_alergia','name','user_id', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';


    public function showAlergias($id){
        return $this->asArray()
        ->select('hcv_alergias.*')
        ->where('user_id', $id)
        ->orderBy('id', 'DESC')
        ->findAll();
    }

    


    
    
}