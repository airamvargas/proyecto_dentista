<?php

namespace App\Models\Models_hcv;

use CodeIgniter\Model;

class NoPatologicos extends Model
{
    protected $table = 'hcv_personales_no_patologicos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true; 
    protected $returnType="array";
    protected $useSoftDeletes=true;
    protected $allowedFields = ['user_id','talla','peso','tatuajes','piercing', 'tuberculosis', 'humo_lena','casa_propia','user_id','created_at','updated_at','deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';


    public function readNoPat($id){
        return $this->asArray()
        ->select('hcv_personales_no_patologicos.*')
        ->where('user_id',$id)
        ->orderBy('id DESC')
        ->limit(1)
        ->find(); 
    }
}