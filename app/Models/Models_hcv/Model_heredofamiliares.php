<?php

namespace App\Models\Models_hcv;

use CodeIgniter\Model;

class Model_heredofamiliares extends Model{
    protected $table = 'hcv_heredofamiliares';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id','rama','parentesco','id_enfermedad','user_id', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function getEnfermedades($id_paciente){
        return $this->asArray()
        ->select('hcv_heredofamiliares.id, hcv_heredofamiliares.rama, hcv_heredofamiliares.parentesco, cat_diseases.common_name')
        ->join('cat_diseases','hcv_heredofamiliares.id_enfermedad = cat_diseases.id')
        ->where('user_id', $id_paciente)
        ->findAll();
    }
}