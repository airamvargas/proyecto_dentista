<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_nota_general extends Model
{
    protected $table = 'hcv_nota_general';
    protected $primaryKey = 'id';
    protected $allowedFields = ['presentacion','id_medico','nota','name_medico','id_patient','id_folio'];
    protected $returnType="array";
    protected $useSoftDeletes=false;


    public function get_nota($id_paciente, $id_medico){
        return $this->asArray()
        ->select('hcv_nota_general.*,hcv_identity_operativo.*')
        ->join('hcv_identity_operativo', 'hcv_identity_operativo.ID_USER = hcv_nota_general.id_medico')
        ->where('hcv_identity_operativo.ID_USER',$id_medico)
        ->where('hcv_nota_general.id_patient',$id_paciente)->first();
    }

    public function get_nota_general($id_folio){
        return $this->asArray()
        ->select('hcv_nota_general.date,hcv_nota_general.nota,hcv_identity_operativo.NAME,hcv_identity_operativo.F_LAST_NAME')
        ->join('hcv_identity_operativo', 'hcv_identity_operativo.ID_USER = hcv_nota_general.id_medico')
        ->where('hcv_nota_general.id_folio',$id_folio)->first();
    }
          
}