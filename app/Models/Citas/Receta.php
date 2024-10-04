<?php

namespace App\Models\Citas;

use CodeIgniter\Model;
class Receta extends Model{
    protected $table      = 'hcv_receta';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'medicamento','presentacion','indicaciones','indicaciones_secundarias','patient_id','id_folio','operativo_id'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getReceta($id_cita){
        return $this->asArray()->where('id_folio',$id_cita)->where('indicaciones_secundarias is NULL')->findAll();
    }

   public function getIndicacion($id_cita){
        return $this->asArray()->select('id,indicaciones_secundarias')
        ->where('id_folio',$id_cita)
        ->where('indicaciones_secundarias is NOT NULL', NULL, FALSE)
        ->findAll();

    } 

}

?>