<?php

namespace App\Models\HCV\Paciente\registro_medico;

use CodeIgniter\Model;

class Psicologia extends Model
{
    protected $table = 'hcv_psicology';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = false;
    protected $allowedFields = ['tecnica', 'tipo_abordaje','estado_emocional','objetivo_consulta','nota','id_patient','id_folio','operativo_id'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function get_psicologia($id_cita){
        return $this->asArray()
        ->select('hcv_psicology.*,,hcv_identity_operativo.NAME,hcv_identity_operativo.F_LAST_NAME,hcv_identity_operativo.S_LAST_NAME')
        ->join('hcv_identity_operativo', 'hcv_identity_operativo.ID_USER = hcv_psicology.id_medico')
        ->where('hcv_psicology.id_folio',$id_cita)
        ->find();
    }

    // Obtener los datos clinicos de psicologia para registro medico
    public function getDatosPsicologia($id_patient){
        return $this->asArray()
        ->select('*')
        ->where('id_patient', $id_patient)
        ->findAll();
    }
    
}