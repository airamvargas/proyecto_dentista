<?php

namespace App\Models\Models_hcv;

use CodeIgniter\Model;

class Model_personales_patologicos extends Model
{
    protected $table = 'hcv_personales_patologicos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['transfusion','desc_transfusion','fractura_esguince_luxacion','desc_fractura','consumo_sustancias','cantidad_consumo','user_id','created_at','updated_at','deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';


    public function readPatologicos($id){
        return $this->asArray()
        ->select('hcv_personales_patologicos.*')
        ->where('user_id', $id)
        ->orderBy('id', 'DESC')
        ->limit(1)
        ->find();
    }
}
