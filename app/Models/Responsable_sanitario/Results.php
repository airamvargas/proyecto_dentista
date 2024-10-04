<?php

namespace App\Models\Responsable_sanitario;

use CodeIgniter\Model;

class Results extends Model
{
    protected $table = 'crm_results';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_cita','id_study','name_study','question_type','agrupador','unit_of_measure','id_analito','name_analito', 'answer_analito', 'id_responsible','edad','name_paciente','sex','tipo_muestra','metodo', 'operator', 'created_at','referencia_min','referencia_max','success', 'documento', 'bandera', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function get_results($id_cita){
        return $this->asArray()
        ->where('id_cita',$id_cita)
        ->findAll();
    }

}