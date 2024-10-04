<?php

namespace App\Models\Tomador_muestra;

use CodeIgniter\Model;

class Preanaliticos extends Model{
    protected $table      = 'crm_preanalytical';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['question','answer','name_medico','name_study', 'id_doctor', 'id_study','id_cita', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

   
}

?>