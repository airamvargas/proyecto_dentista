<?php

namespace App\Models\Citas;

use CodeIgniter\Model;
class Diagnostico extends Model{
    protected $table      = 'hcv_diagnostic_history';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['enfermedad', 'grupo', 'fecha', 'time', 'id_patient' ,'id_folio', 'id_medico'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getDiagnostic($id_cita){
        return $this->asArray()->where('id_folio',$id_cita)->find();
    
    }

}

?>