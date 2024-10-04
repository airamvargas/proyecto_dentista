<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_medico_x_paciente extends Model
{
    protected $table = 'hcv_doctors_x_patients';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['id','patients_id','doctor_id'];
    protected $returnType="array";
    protected $useSoftDeletes=false;

    public function get_data($id){
        return $this->asArray()
        ->select('hcv_doctors_x_patients.*,hcv_identity.NAME,hcv_identity.F_LAST_NAME,hcv_identity.verified, hcv_identity.type as tipo')
        ->join('hcv_identity', 'hcv_identity.ID_USER = hcv_doctors_x_patients.patients_id')
       /*  ->join('hcv_cat_membresia', 'hcv_cat_membresia.id = hcv_identity.id_cat_membresia')
        ->join('hcv_cat_cp_custom', 'hcv_cat_cp_custom.id_hcv_cat_cp = hcv_identity.ID_ZIP_CODE')
        ->join('hcv_cat_sector', 'hcv_cat_sector.id = hcv_cat_cp_custom.id_hcv_cat_sector') */
        ->where('hcv_doctors_x_patients.doctor_id',$id)
       // ->orderBy('ID', 'DESC')
        ->findAll();
    }

    public function get_id_doc($id_paciente){
        return $this->asArray()
        ->select('hcv_doctors_x_patients.doctor_id')
        ->where('hcv_doctors_x_patients.patients_id',$id_paciente)->first();
    }

    public function get_data_medico($id_paciente,$cita){
        return $this->asArray()
        ->select('hcv_doctors_x_patients.doctor_id,hcv_identity_operativo.DISCIPLINE')
        ->join('hcv_identity_operativo', 'hcv_identity_operativo.ID_USER = hcv_doctors_x_patients.doctor_id')
        ->where('hcv_doctors_x_patients.patients_id',$id_paciente)
        ->where('hcv_identity_operativo.DISCIPLINE',$cita)
       // ->orderBy('ID', 'DESC')
        ->findAll();

    }

   


}