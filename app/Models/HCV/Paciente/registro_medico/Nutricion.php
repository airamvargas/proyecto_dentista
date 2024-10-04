<?php

namespace App\Models\HCV\Paciente\registro_medico;

use CodeIgniter\Model;

class Nutricion extends Model
{
    protected $table = 'hcv_nutricion';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'nota', 'cintura','cadera','pantorrilla','masa_muscular','grasa_corporal', 'grasa_visceral' ,'agua_corporal','tasa_metabolica','edad_metabolica', 'peso', 'talla', 'imc', 'patient_id','id_folio','operativo_id', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
        
    // Se verifica si hay una nota de nutricion con ese id de la cita
    public function notaNutricion($id_folio){
        return $this->asArray()
        ->selectCount('id_folio')
        ->where('id_folio', $id_folio)
        ->findAll();
    }   

    //Obtener el id de la nota de nutricion de acuerdo al id de la cita
    public function getIdNota($id_folio){
        return $this->asArray()
        ->select('id')
        ->where('id_folio', $id_folio)
        ->find();
    }

    // Obtener todos los datos de la nota de nutricion de acuerdo al id de la cita
    public function getNota($id_folio){
        return $this->asArray()
        ->select('*')
        ->where('id_folio', $id_folio)
        ->find();
    }

    // Obtener los datos de distintas consultas de un paciente
    public function getDatosClinicos($id_patient){
        return $this->asArray()
        ->select('*')
        ->where('patient_id', $id_patient)
        ->findAll();
    }

    //primera nota medica de nutricion
    public function firstNote($id_paciente){
        return $this->asArray()->select('nota, DATE_FORMAT(hcv_nota_general.created_at, "%d/%m/%Y") as fecha, CONCAT(hcv_identity_operativo.NAME," ",hcv_identity_operativo.F_LAST_NAME," ",hcv_identity_operativo.S_LAST_NAME) as fullname')
        ->join('hcv_identity_operativo', 'hcv_identity_operativo.user_id = hcv_nutricion.operativo_id')
        ->where('id_patient',$id_paciente)->first();
    }
    
}