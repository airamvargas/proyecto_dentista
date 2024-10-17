<?php

namespace App\Models\models_paciente;

use CodeIgniter\Model;

class citas extends Model
{
    protected $table = 'citas';
    protected $primaryKey = 'id';
    protected $returnType="array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_paciente','fecha', 'observaciones', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function get_citas() {
        return $this->asArray()->select('citas.id, fecha, observaciones, pacientes.nombre, id_paciente')->join('pacientes', 'pacientes.id = citas.id_paciente')
        ->find();
    }
}