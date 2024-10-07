<?php

namespace App\Models\models_paciente;

use CodeIgniter\Model;

class Pacientes extends Model
{
    protected $table = 'pacientes';
    protected $primaryKey = 'id';
    protected $returnType="array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['nombre','sex', 'f_nacimiento', 'lugar_nac', 'tel_casa', 'tel_cel', 'direccion', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function readPacientes($busqueda){
        return $this->asArray()
        ->select('id, nombre, sex, f_nacimiento, lugar_nac, tel_casa, tel_cel, direccion')
        ->like('pacientes.nombre', $busqueda)
        ->find();
    }

    public function readPaciente($id){
        return $this->asArray()
        ->select('nombre, sex, f_nacimiento, lugar_nac, tel_casa, tel_cel, direccion')
        ->where('pacientes.id', $id)
        ->find();
    }
}