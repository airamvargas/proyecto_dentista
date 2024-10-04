<?php

namespace App\Models\Citas;

use CodeIgniter\Model;
class Hcv_medical_signs extends Model{
    protected $table      = 'hcv_medical_signs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['FC', 'FR', 'temp', 'TA', 'TA2' ,'satO2', 'mg_dl','peso','talla','IMC','patient_id','id_folio','operativo_id'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getsings($id_cita){
        return $this->asArray()->where('id_folio',$id_cita)->find();
    
    }

}

?>