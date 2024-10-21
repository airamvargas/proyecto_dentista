<?php

namespace App\Models\models_paciente;

use CodeIgniter\Model;

class citas extends Model
{
    protected $table = 'citas';
    protected $primaryKey = 'id';
    protected $returnType="array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_paciente','fecha', 'observaciones', 'status_cita', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function get_citas() {
        return $this->asArray()->select('citas.id, fecha, observaciones, pacientes.nombre AS paciente, id_paciente')->join('pacientes', 'pacientes.id = citas.id_paciente')
        ->where('status_cita != 2')->find();
    }

    public function read_cita($id_cita) {
        return $this->asArray()->select('citas.id, fecha, observaciones, id_paciente')->where('citas.id', $id_cita)
        ->find();
    }

    public function horas_disp($fecha) {
        return $this
        ->select('DATE_FORMAT(fecha, "%T") AS horas')
        ->where('fecha LIKE "%'.$fecha.'%"')
        ->find();
        
    }
}