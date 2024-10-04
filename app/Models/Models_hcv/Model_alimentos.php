<?php

namespace App\Models\Models_hcv;

use CodeIgniter\Model;

class Model_alimentos extends Model
{
    protected $table = 'hcv_alimentos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id','alimento','cantidad', 'user_id','created_at','updated_at','deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';


    public function readAliments($id_paciente){
        return $this->asArray()
        ->select('hcv_alimentos.*')
        ->where('user_id', $id_paciente)
        ->orderBy('id', 'DESC')
        ->findAll();
    }

    


    
    
}