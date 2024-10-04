<?php

namespace App\Models\Catalogos\Laboratorio;

use CodeIgniter\Model;

class Consulting_room extends Model{
    protected $table      = 'consulting_room';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_business_unit', 'name', 'description','start_time','end_time'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getConsultingroom(){
        return $this->asArray()
        ->select('consulting_room.*,cat_business_unit.name as unidad ')
        ->join('cat_business_unit','cat_business_unit.id = consulting_room.id_business_unit')
		->findAll();
    }

    public function getConsulting($id){
        return $this->asArray()->where('id',$id)->find();
    }

    public function getConsultorios($unidad){
        return $this->asArray()
        ->select('consulting_room.id, consulting_room.name as consultorio')
        ->where('id_business_unit', $unidad)
		->findAll();
    }

    public function officesAvailable($unidad,$fecha,$hora){
        $sql = "SELECT consulting_room.id as id_consultorio, consulting_room.name as consultorio, 
        (SELECT distinct time_appointment  FROM office_schedule WHERE  office_schedule.id_consulting = id_consultorio and office_schedule.time_appointment = :actual:
            and office_schedule.date_appointment =  :fecha: )  AS hora
        from consulting_room  where consulting_room.id_business_unit = :unidad: and  consulting_room.deleted_at is null  having hora is null";
        $query = $this->db->query($sql, ['actual' => $hora, 'fecha' =>$fecha, 'unidad' => $unidad]);
        return $query->getResult();

    }

    public function officesAvailableup($unidad,$fecha,$hora){
        $sql = "SELECT consulting_room.id as id_consultorio, consulting_room.name as consultorio, 
        (SELECT distinct time_appointment  FROM office_schedule WHERE  office_schedule.id_consulting = id_consultorio and office_schedule.time_appointment = :actual:
            and office_schedule.date_appointment =  :fecha: )  AS hora
        from consulting_room  where consulting_room.id_business_unit = :unidad: and  consulting_room.deleted_at is null  having hora is null or hora = :actual:";
        $query = $this->db->query($sql, ['actual' => $hora, 'fecha' =>$fecha, 'unidad' => $unidad]);
        return $query->getResult();

    }


    public function readRooms($id_unit){
        return $this->asArray()
        ->select('consulting_room.*')
        ->where('id_business_unit', $id_unit)
		->findAll();
    }
}
