<?php

namespace App\Models\HCV\Operativo;

use CodeIgniter\Model;

class Ficha_Identificacion extends Model {
    protected $table = 'hcv_identity_operativo';
    protected $primaryKey = 'ID';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['ID','NAME','F_LAST_NAME','S_LAST_NAME','BIRTHDATE', 'DESC_PERSONAL', 'signature', 'id_cat_business_unit', 'id_consulting_room', 'status_area', 'entry_time', 'departure_time','CAT_CP_ID', 'delegacion', 'estado', 'colonia', 'STREET_NUMBER','disciplina_id','especialidad_id','NUMBER_PROFESSIONAL_CERTIFICATE','NUMBER_SPECIALTY_CERTIFICATE','FILE_INE','FILE_USER','PHONE_NUMBER','LATITUD','LONGITUD','user_id','created_at','updated_at','deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function total($id_user){
        return $this->asArray()->where('user_id',$id_user)->findAll();
    }

    // Datos a imprimir en la tabla general de medicos
    public function get_medicos(){
        return $this->asArray()
        ->select('hcv_identity_operativo.ID as id,concat(hcv_identity_operativo.NAME, " " ,hcv_identity_operativo.F_LAST_NAME, " " ,hcv_identity_operativo.S_LAST_NAME)as nombre, hcv_identity_operativo.FILE_USER as foto, hcv_identity_operativo.PHONE_NUMBER, hcv_identity_operativo.entry_time as entrada, hcv_identity_operativo.departure_time as salida, groups.name as nombre_grupo, users.email as correo')
        ->join('users', 'users.id = hcv_identity_operativo.user_id')
        ->join('groups', 'groups.id = users.id_group')
        //->join('hcv_specialtytype', 'hcv_specialtytype.id = hcv_identity_operativo.disciplina_id')
        ->findAll();
    }

    public function get_operativos($unidad,$diciplina){
        $sql = 'SELECT concat(hcv_identity_operativo.NAME, " " ,hcv_identity_operativo.F_LAST_NAME, " " ,hcv_identity_operativo.S_LAST_NAME)as nombre, hcv_identity_operativo.user_id
        from hcv_identity_operativo
          join business_unit_x_doctor on business_unit_x_doctor.id_user = hcv_identity_operativo.user_id
        where business_unit_x_doctor.id_business_unit = :unidad:
        and  hcv_identity_operativo.disciplina_id = :diciplina: and business_unit_x_doctor.deleted_at IS NULL';
        $query = $this->db->query($sql, ['unidad' => $unidad, 'diciplina' => $diciplina]);
        return $query->getResult();
    }

    // Datos de la ficha de identificacion de un medico
    public function get_medico($id){
        return $this->asArray()
        ->select('hcv_identity_operativo.*,  users.*, hcv_cat_academic.ACADEMIC_FORMATION as nom_especialidad, concat(hcv_cat_cp.CP, ", ", hcv_cat_cp.ASENTAMIENTO) as CP')
        ->join('users', 'users.id = hcv_identity_operativo.user_id')
        ->join('hcv_cat_cp', 'hcv_cat_cp.ID = hcv_identity_operativo.CAT_CP_ID')
        ->join('hcv_cat_academic', 'hcv_cat_academic.ID = hcv_identity_operativo.especialidad_id')
        ->where('hcv_identity_operativo.ID', $id)
        ->find();
    }

    public function getHorario($id_user){
        return $this->asArray()
        ->select('entry_time,departure_time')->where('user_id',$id_user)->find();
    }

    public function MedicoDisponibles($unidad,$diciplina){
        return $this->asArray()
        ->select('concat(hcv_identity_operativo.NAME, " " ,hcv_identity_operativo.F_LAST_NAME, " " ,hcv_identity_operativo.S_LAST_NAME)as nombre, hcv_identity_operativo.user_id')
        ->join('business_unit_x_doctor','business_unit_x_doctor.id_user = hcv_identity_operativo.user_id')
        ->join('cat_business_unit','cat_business_unit.id = business_unit_x_doctor.id_business_unit')
        ->where('business_unit_x_doctor.id_business_unit',$unidad)
        ->where('hcv_identity_operativo.disciplina_id',$diciplina)
        ->where('hcv_identity_operativo.entry_time >=','cat_business_unit.start_time')
        ->findAll();
    }

    public function getDoctor($fecha,$hora,$diciplina,$unidad){
        $sql = "SELECT CONCAT(NAME,' ',F_LAST_NAME,' ', S_LAST_NAME) as medico, user_id as usuario, entry_time as timeinico, departure_time as tiempofin, disciplina_id,
        (select distinct doctor_schedule.time_appointment from doctor_schedule where doctor_schedule.time_appointment = :actual: and doctor_schedule.date_appointment = :fecha: and id_doctor = usuario limit 1) as hora,
        (select id_business_unit from business_unit_x_doctor where id_user=usuario and id_business_unit = :unidad: limit 1 ) id_unidad
        from hcv_identity_operativo having id_unidad = :unidad: and disciplina_id = :diciplina: and  hora is null  and :actual: >= entry_time  and  :actual: < departure_time";
        $query = $this->db->query($sql, ['actual' => $hora, 'fecha' =>$fecha, 'unidad' => $unidad , 'diciplina' => $diciplina]);
        return $query->getResult();
    }

    public function getDoctorhours($fecha,$hora,$diciplina,$unidad){
        $sql = "SELECT  CONCAT(NAME,' ',F_LAST_NAME,' ', S_LAST_NAME) as medico, user_id as usuario, entry_time as timeinico, departure_time as tiempofin, disciplina_id,
        (select distinct doctor_schedule.time_appointment from doctor_schedule where doctor_schedule.time_appointment = :actual: and doctor_schedule.date_appointment = :fecha: and id_doctor = usuario limit 1) as hora,
        (select id_business_unit from business_unit_x_doctor where id_user=usuario and id_business_unit = :unidad: limit 1) id_unidad
        from hcv_identity_operativo having id_unidad = :unidad: and disciplina_id = :diciplina: and  hora is null  and :actual: >= entry_time  and  :actual: < departure_time  or hora = :actual:";
        $query = $this->db->query($sql, ['actual' => $hora, 'fecha' =>$fecha, 'unidad' => $unidad , 'diciplina' => $diciplina]);
        return $query->getResult();
    }

    public function unidades($id){
        return $this->asArray()
        ->select('user_id')->where('ID', $id)->find();
    }

    public function getName($id_user){
        return $this->asArray()
        ->select('concat(hcv_identity_operativo.NAME, " " ,hcv_identity_operativo.F_LAST_NAME, " " ,hcv_identity_operativo.S_LAST_NAME)as nombre')
        ->where('user_id',$id_user)->find();
    }

    public function confirm_ingreso($user_id){
        return $this->asArray()
        ->select('status_area')
        ->where('user_id', $user_id)
        ->find();
    }

    //imagenes de los medicos
    public function getImage($id_user){
        return $this->asArray()
        ->select('FILE_USER')
        ->where('user_id', $id_user)
        ->find();

    }

    public function geUser($id){
        return $this->asArray()
        ->select('hcv_identity_operativo.*, users.code, users.email, users.id_group, concat(hcv_cat_cp.CP, " - ", hcv_cat_cp.ASENTAMIENTO) as CP, hcv_cat_academic.ACADEMIC_FORMATION as formacion')
        ->join('users', 'users.id = hcv_identity_operativo.user_id')
        ->join('hcv_cat_cp', 'hcv_cat_cp.ID = hcv_identity_operativo.CAT_CP_ID', 'left')
        ->join('hcv_cat_academic', 'hcv_cat_academic.ID = hcv_identity_operativo.especialidad_id', 'left')
        ->where('user_id',$id)->find();
    }

    public function firma($id){
        return $this->asArray()
        ->where('hcv_identity_operativo.user_id', $id)
        ->findAll();
    }

    public function confirm_firma($user_id){
        return $this->asArray()
        ->selectCount('signature')
        ->where('user_id', $user_id)
        ->find();
    }
}