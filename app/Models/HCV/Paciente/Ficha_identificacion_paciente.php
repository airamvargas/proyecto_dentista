<?php

namespace App\Models\HCV\Paciente;

use CodeIgniter\Model;

class Ficha_identificacion_paciente extends Model
{
    protected $table = 'hcv_identity';
    protected $primaryKey = 'ID';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['ID', 'ID_USER', 'id_cat_business_unit', 'CURP', 'NAME', 'F_LAST_NAME', 'S_LAST_NAME', 'PHONE_NUMBER', 'BIRTHDATE', 'ID_CAT_NATIONALITY', 'BIRTHPLACE', 'ID_CAT_GENDER_IDENTITY', 'ID_ZIP_CODE', 'ID_CAT_STATE_OF_RESIDENCE', 'ID_CAT_MUNICIPALITY', 'ID_CAT_TOWN', 'street_other', 'ID_CAT_ACADEMIC', 'JOB', 'ID_CAT_MARITAL_STATUS', 'ID_CAT_RELIGION', 'ANSWER_INDIGENOUS_COMUNITY', 'ANSWER_INDIGENOUS_LENGUAGE', 'ID_CAT_INDIGENOUS_LENGUAGE', 'PATH', 'SEX', 'other_gender', 'verified', 'type', 'LATITUD', 'LONGITUD', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function total($id_user)
    {
        return $this->asArray()->where('id_user', $id_user)->findAll();
    }

    public function get_id($id_user)
    {
        return $this->asObject()->select('ID, PATH')->where('ID_USER', $id_user)->first();
    }

    // Datos a imprimir en la tabla general de pacientes
    public function get_pacientes($sql){
        return $this->db->query($sql)->getResult();
    }

    // Datos de la ficha de identificacion de un paciente
    public function get_paciente($id){
        return $this->asArray()
        ->select('hcv_identity.*,  users.*, groups.*, hcv_cat_academic.ACADEMIC_FORMATION as formacion, concat(hcv_cat_cp.CP, ", ", hcv_cat_cp.ASENTAMIENTO) as CP, hcv_cat_religion.RELIGION as religion, hcv_cat_indigenous_lenguge.SCIENTIFIC_NAME as lengua')
        ->join('users', 'users.id = hcv_identity.ID_USER')
        ->join('groups', 'groups.id = users.id_group')
        ->join('hcv_cat_cp', 'hcv_cat_cp.ID = hcv_identity.ID_ZIP_CODE', 'left')
        ->join('hcv_cat_academic', 'hcv_cat_academic.ID = hcv_identity.ID_CAT_ACADEMIC', 'left')
        ->join('hcv_cat_religion', 'hcv_cat_religion.ID = hcv_identity.ID_CAT_RELIGION', 'left')
        ->join('hcv_cat_indigenous_lenguge', 'hcv_cat_indigenous_lenguge.ID = hcv_identity.ID_CAT_INDIGENOUS_LENGUAGE', 'left')
        ->where('hcv_identity.ID', $id)
        ->find();
    }

    // Se obtienen los datos a mostrar en la nota medica del paciente
    public function getDatos($paciente_id){
        return $this->asArray()
        ->select('PATH, NAME, F_LAST_NAME, S_LAST_NAME, BIRTHDATE, SEX')
        ->where('ID_USER', $paciente_id)
        ->find();
    }

    public function patient_id($id_user){
        return $this->asArray()
        ->select('*')
        ->where('ID_USER', $id_user)
        ->findAll();
    }
    
}
