<?php

namespace App\Models\Medical_consultation;

use CodeIgniter\Model;

class Medical_consultation_setup extends Model {
    protected $table = 'medical_consultation_setup';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name_table','id_product', 'id_discipline', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    //Nombre de las disciplina guardadas en el catalogo
    public function get_speciality(){
        return $this->asArray()
        ->select('*')
        ->findAll();
    }
}