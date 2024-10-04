<?php

namespace App\Models\Resultados;

use CodeIgniter\Model;

class Crm_results extends Model{
    protected $table      = 'crm_results';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_cita', 'id_study', 'name_analito', 'answer_analito', 'id_responsible', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

   
}

?>