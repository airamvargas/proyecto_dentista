<?php

namespace App\Models\HCV\Operativo\Nota_medica;

use CodeIgniter\Model;

class Nota_psicologia extends Model {

    protected $table = 'hcv_psicology';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['tecnica', 'tipo_abordaje', 'estado_emocional', 'objectivo_consulta', 'nota', 'id_patient', 'id_folio', 'id_medico'];
    protected $useTimestamps = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function fisrtNote($id_paciente){
        return $this->asArray()->select('nota, DATE_FORMAT(hcv_psicology.created_at, "%d/%m/%Y") as fecha,  CONCAT(hcv_identity_operativo.NAME," ",hcv_identity_operativo.F_LAST_NAME," ",hcv_identity_operativo.S_LAST_NAME) as fullname')
        ->join('hcv_identity_operativo', 'hcv_identity_operativo.user_id = hcv_psicology.id_medico')
        ->where('id_patient',$id_paciente)->first();
    }



}
