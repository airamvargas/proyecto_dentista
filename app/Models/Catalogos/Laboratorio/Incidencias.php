<?php

namespace App\Models\Catalogos\Laboratorio;

use CodeIgniter\Model;

class Incidencias extends Model{
    protected $table      = 'incidents';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name_doctor', 'id_doctor', 'id_study', 'name_study', 'id_cita', 'incidence', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

}
