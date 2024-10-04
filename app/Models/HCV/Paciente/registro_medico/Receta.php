<?php

namespace App\Models\HCV\Paciente\registro_medico;

use CodeIgniter\Model;

class Receta extends Model
{
    protected $table = 'hcv_receta';
    protected $primaryKey = 'id';
    protected $allowedFields = ['medicamento','presentacion','cantidad','unidad','indicaciones','indicaciones_secundarias','name_pdf', 'fecha', 'hora', 'patient_id','id_folio','operativo_id'];
    protected $returnType="array";
    protected $useSoftDeletes=false;


    public function get_receta($id_cita){
        return $this->asArray()
        ->select('hcv_receta.*')
        ->where('hcv_receta.id_folio',$id_cita)
        ->find();
    }
    
}