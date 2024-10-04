<?php

namespace App\Models\Citas;

use CodeIgniter\Model;
class Nota_general extends Model{
    protected $table      = 'hcv_nota_general';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'id_medico','nota','name_medico','time','date','id_patient','id_folio'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function NotaGeneral($id_cita){
        return $this->asArray()->where('id_folio',$id_cita)->find();
    }

    public function firstNote($id_paciente){
        return $this->asArray()->select('nota, DATE_FORMAT(hcv_nota_general.created_at, "%d/%m/%Y") as fecha, CONCAT(hcv_identity_operativo.NAME," ",hcv_identity_operativo.F_LAST_NAME," ",hcv_identity_operativo.S_LAST_NAME) as fullname')
        ->join('hcv_identity_operativo', 'hcv_identity_operativo.user_id = hcv_nota_general.id_medico')
        ->where('id_patient',$id_paciente)->first();
    }

}






?>