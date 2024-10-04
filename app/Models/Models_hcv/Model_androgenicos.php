<?php

namespace App\Models\Models_hcv;

use CodeIgniter\Model;

class Model_androgenicos extends Model
{
    protected $table = 'hcv_androgenicos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['inicio_de_vida_sexual', 'numero_parejas_sexuales', 'user_id', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    
    public function readAndrogenicos($id){
        return $this->asArray()
        ->select('hcv_androgenicos.*')
        ->where('user_id', $id)
        ->orderBy('id DESC')
        ->limit(1)
        ->findAll(); 
    }
}