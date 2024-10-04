<?php

namespace App\Models\Models_hcv;

use CodeIgniter\Model;

class Model_servicios extends Model
{
    protected $table = 'hcv_servicios';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType="array";
    protected $useSoftDeletes=true;
    protected $allowedFields = ['id','servicio','user_id','created_at','updated_at','deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    


    public function get_servicios($id){
        return $this->asArray()
        ->select('hcv_servicios.*')
        ->where('hcv_servicios.user_id', $id)
        ->orderBy('id', 'DESC')
        ->findAll();
    }

    


    
    
}