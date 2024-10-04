<?php

namespace App\Models\Models_hcv;

use CodeIgniter\Model;

class Model_ets extends Model
{
    protected $table = 'hcv_ets';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['enfermedad','user_id','created_at','updated_at','deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function readEts($id){
        return $this->asArray()
        ->select('hcv_ets.*')
        ->where('user_id', $id)
        ->findAll();
    }
}