<?php

namespace App\Models\models_paciente;

use CodeIgniter\Model;

class Tratamientos_x_cita extends Model
{
    protected $table = 'tratamientos_x_cita';
    protected $primaryKey = 'id';
    protected $returnType="array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_cita','id_tratamiento', 'precio', 'cantidad', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}