<?php

namespace App\Models\HCV\Operativo\Nota_medica;

use CodeIgniter\Model;

class Nota_odontologia extends Model {

    protected $table = 'hcv_odontologia';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['marcha', 'mov_anormales', 'facies', 'complexion', 'posicion', 'cuidado_personal', 'cara', 'craneo', 'cuello', 'nariz', 'oidos', 'ojos', 'lesion', 'localizacion', 'forma', 'color', 'superficie', 'bordes', 'consistencia', 'base', 'tiempo_evolucion', 'cepillado', 'hilo_dental', 'enjuague', 'succion', 'deglucion_atipica', 'respirador_bucal', 'alteraciones', 'dolor', 'dificultad_incapacidad', 'ruidos', 'desviacion', 'edema', 'id_patient', 'id_folio', 'id_medico', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Obtener los datos de distintas consultas de un paciente
    public function getOdontologia($id_patient){
        return $this->asArray()
        ->select('*')
        ->where('id_patient', $id_patient)
        ->findAll();
    }
    
}