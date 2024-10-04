<?php

namespace App\Models\Models_hcv;

use CodeIgniter\Model;

class Model_psicologicos extends Model
{
    protected $table = 'hcv_psicologicos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['ha_tenido_intervenciones', 'ha_tenido_tratamiento_previo', 'actualmente_continua_tratamiento', 'desc_tratamiento', 'considera_atencion_psicologia','user_id','created_at','updated_at','deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function readPsicologicos($id){
        return $this->asArray()
        ->select('hcv_psicologicos.*')
        ->where('user_id',$id)
        ->orderBy('id DESC')
        ->limit(1)
        ->find(); 
    }
}