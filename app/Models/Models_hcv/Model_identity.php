<?php

namespace App\Models\Models_hcv;

use CodeIgniter\Model;

class Model_identity extends Model
{
    protected $table = 'hcv_identity';
    protected $primaryKey = 'ID';
    protected $returnType="array";
    protected $useAutoIncrement = true;
    protected $allowedFields = ['ID', 'ID_USER', 'id_cat_business_unit', 'CURP', 'NAME', 'F_LAST_NAME', 'S_LAST_NAME', 'PHONE_NUMBER', 'BIRTHDATE', 'ID_CAT_NATIONALITY', 'BIRTHPLACE', 'ID_CAT_GENDER_IDENTITY', 'ID_ZIP_CODE', 'ID_CAT_STATE_OF_RESIDENCE', 'ID_CAT_MUNICIPALITY', 'ID_CAT_TOWN', 'street_other', 'ID_CAT_ACADEMIC', 'JOB', 'ID_CAT_MARITAL_STATUS', 'ID_CAT_RELIGION', 'ANSWER_INDIGENOUS_COMUNITY', 'ANSWER_INDIGENOUS_LENGUAGE', 'ID_CAT_INDIGENOUS_LENGUAGE', 'ID_CAT_TUTOR','ANSWER_OTHER_TUTOR', 'COUNTRY', 'PATH', 'SEX', 'other_gender', 'verified', 'membresia', 'id_cat_membresia', 'vigencia_membresia', 'type', 'LATITUD', 'LONGITUD', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function total($id_user){
        return $this->asArray()->where('id_user',$id_user)->findAll();
    }

    public function get_id($id_user){
        return $this->asObject()->select('ID, PATH')->where('ID_USER',$id_user)->first();
    }

    public function getFullJoin($limit = 10 , $offset = 0){
        $fullJoinQuery = "SELECT hcv_identity.* , hcv_cat_marital_status.name as MARITAL_STATUS FROM hcv_identity , hcv_cat_marital_status WHERE hcv_identity.ID_CAT_MARITAL_STATUS = hcv_cat_marital_status.id LIMIT $limit OFFSET $offset";
        $result = $this->db->query($fullJoinQuery);
        return $result->getResult();
    }

    public function getIdentityfull($id){
        $fullJoinQuery = "SELECT hcv_identity.* , hcv_cat_marital_status.name as MARITAL_STATUS FROM hcv_identity , hcv_cat_marital_status WHERE hcv_identity.ID_CAT_MARITAL_STATUS = hcv_cat_marital_status.id and hcv_identity.id = $id";
        $result = $this->db->query($fullJoinQuery);
        return $result->getResult();
    }

    public function get_datos($id){
        return $this->asArray()
        ->select('hcv_identity.*')
        ->join('users', 'users.id = hcv_identity.ID_USER')
        ->where('hcv_identity.ID_USER',$id)
        ->findAll();
    }

    public function readPatient($user_id){
        return $this->asArray()
        ->select('hcv_identity.*, hcv_cat_academic.ACADEMIC_FORMATION as nom_especialidad, concat(hcv_cat_cp.CP, " - ", hcv_cat_cp.ASENTAMIENTO) as CP, hcv_cat_religion.RELIGION as religion, hcv_cat_indigenous_lenguge.SCIENTIFIC_NAME as lengua')
        ->join('hcv_cat_cp', 'hcv_cat_cp.ID = hcv_identity.ID_ZIP_CODE', 'left')
        ->join('hcv_cat_academic', 'hcv_cat_academic.ID = hcv_identity.ID_CAT_ACADEMIC', 'left')
        ->join('hcv_cat_religion', 'hcv_cat_religion.ID = hcv_identity.ID_CAT_RELIGION', 'left')
        ->join('hcv_cat_indigenous_lenguge', 'hcv_cat_indigenous_lenguge.ID = hcv_identity.ID_CAT_INDIGENOUS_LENGUAGE', 'left')
        ->where('hcv_identity.ID_USER', $user_id)
        ->find();
    }

    //imagen del header del paciente 
    public function getImage($id_user){
        return $this->asArray()
        ->select('PATH')
        ->where('hcv_identity.ID_USER',$id_user)
        ->findAll();
    }

}

