<?php

namespace App\Models\Agendas;

use CodeIgniter\Model;

class Office_schedule extends Model{
    protected $table      = 'office_schedule';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_consulting ', 'date_appointment', 'time_appointment','id_cita'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function searchConsulting($id_consultorio,$fecha){
        return $this->asArray()
        ->select('id')
        ->where('id_consulting',$id_consultorio)
        ->where('date_appointment',$fecha)
		->findAll();
    }

    public function getHours($fecha,$id_consultorio){
        return $this->asArray()
        ->selectMax('time_appointment')
        ->where('date_appointment',$fecha)
        ->where('id_consulting',$id_consultorio)
        ->find();

    }

  

   

}


?>