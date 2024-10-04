<?php

namespace App\Models\HCV\Operativo;

use CodeIgniter\Model;

class Cedula extends Model {
    protected $table = 'hcv_cedulas_operativo';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id','num_cedula', 'especialidad_id', 'user_id', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    //Numero de cedula y especialidad del operativo
    public function get_cedulas($id){
        return $this->asArray()
        ->select('hcv_cedulas_operativo.*')
        ->join('hcv_cat_academic', 'hcv_cat_academic.ID = hcv_cedulas_operativo.especialidad_id')
        ->join('users', 'user.id = hcv_cedulas_operativo.user_id')
        ->where('user_id', $id)
        ->findAll();
    }
       

}