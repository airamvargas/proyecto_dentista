<?php

namespace App\Models\Models_hcv;

use CodeIgniter\Model;

class Model_enfermedades_base extends Model
{
    protected $table = 'hcv_enfermedades_base';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_cat_disease', 'enfermedad', 'grupo', 'user_id', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';


    public function show($id){
        return $this->asArray()
        ->select('hcv_enfermedades_base.*')
        ->where('user_id', $id)
        ->orderBy('id', 'DESC')
        ->findAll();
    }

    


    
    
}