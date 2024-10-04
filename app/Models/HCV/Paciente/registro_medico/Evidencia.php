<?php

namespace App\Models\HCV\Paciente\registro_medico;

use CodeIgniter\Model;

class Evidencia extends Model
{
    protected $table = 'hcv_photo_evidency';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name_foto', 'descripcion','patient_id','id_folio','operativo_id', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    public function showEvidencia($id_folio){
        return $this->asArray()
        ->select('hcv_photo_evidency.*, appointment_schedule.approved')
        ->join('appointment_schedule', 'appointment_schedule.id_cita = hcv_photo_evidency.id_folio')
        ->where('hcv_photo_evidency.id_folio', $id_folio)
        ->find();
    }


}