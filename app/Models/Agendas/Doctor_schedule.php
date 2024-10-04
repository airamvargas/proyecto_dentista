<?php

namespace App\Models\Agendas;

use CodeIgniter\Model;

class Doctor_schedule extends Model{
    protected $table      = 'doctor_schedule';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_doctor', 'date_appointment', 'time_appointment','id_cita'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getHours($fecha,$id_medico){
        return $this->asArray()
        ->select('time_appointment')
        ->where('id_doctor',$id_medico)
        ->like('date_appointment',$fecha)
        ->findAll();

    }

}


?>