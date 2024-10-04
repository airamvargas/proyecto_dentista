<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_citas extends Model
{
    protected $table = 'hcv_quotes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'date_time', 'patient_id', 'doctor_id','type', 'observation', 'status','tipo_consulta','link','cost','id_tipo_cita','is_paid_by_patient','is_paid_to_doctor'];


    public function get_citas($id_paciente){
        return $this->asArray()
        ->select('hcv_quotes.*,hcv_identity.NAME,hcv_identity.F_LAST_NAME,hcv_identity.S_LAST_NAME,hcv_cat_medical_type.tipo_cita')
        ->join('hcv_identity', 'hcv_identity.ID_USER = hcv_quotes.patient_id')
        ->join('hcv_cat_medical_type', 'hcv_cat_medical_type.id = hcv_quotes.id_tipo_cita')
        ->where('hcv_quotes.patient_id',$id_paciente)
        ->orderBy('Id', 'DESC')
        ->findAll();
    }

    public function get_quotes($id_medico){
        return $this->asArray()
        ->select('hcv_quotes.patient_id,hcv_quotes.date_time,hcv_identity.NAME,hcv_identity.F_LAST_NAME,hcv_identity.S_LAST_NAME')
        ->join('hcv_identity', 'hcv_identity.ID_USER = hcv_quotes.patient_id')
       /*->select('DATE_FORMAT(hcv_quotes.date_time, "%Y-%m-%d") As Fecha, 
        DATE_FORMAT(hcv_quotes.date_time,"%H:%i:%s") AS Hora')*/
        ->where('hcv_quotes.doctor_id',$id_medico)
        ->findAll(); 

    }

    public function get_citas_doctor($id_medico){
       // var_dump($id_medico);
        return $this->asArray()
        ->select('hcv_quotes.patient_id,hcv_quotes.date_time,hcv_identity_operativo.ID_USER AS id_medico,hcv_identity_operativo.NAME AS nombre_medico,hcv_identity_operativo.F_LAST_NAME as ap,hcv_identity_operativo.S_LAST_NAME as am ,hcv_quotes.date_time,hcv_identity.NAME,hcv_identity.F_LAST_NAME,hcv_identity.S_LAST_NAME,hcv_identity_operativo.DISCIPLINE')
        ->join('hcv_identity_operativo', 'hcv_identity_operativo.ID_USER = "'.$id_medico.'"')
        ->join('hcv_identity', 'hcv_identity.ID_USER = hcv_quotes.patient_id')
       /*->select('DATE_FORMAT(hcv_quotes.date_time, "%Y-%m-%d") As Fecha, 
        DATE_FORMAT(hcv_quotes.date_time,"%H:%i:%s") AS Hora')*/
        ->where('hcv_quotes.doctor_id',$id_medico)
        ->findAll(); 

    }

    public function primera_cita($id){
        return $this->asArray()
        ->selectMin('id')
        ->where('hcv_quotes.patient_id',$id)
        ->find();

    }

    public function get_citas_operativo($id_paciente,$id_doctor){
        return $this->asArray()
        ->select('hcv_quotes.*,hcv_identity.NAME,hcv_identity.F_LAST_NAME,hcv_identity.S_LAST_NAME,hcv_cat_medical_type.tipo_cita')
        ->join('hcv_identity', 'hcv_identity.ID_USER = hcv_quotes.patient_id')
        ->join('hcv_cat_medical_type', 'hcv_cat_medical_type.id = hcv_quotes.id_tipo_cita')
        ->where('hcv_quotes.patient_id',$id_paciente)
        ->where('hcv_quotes.doctor_id',$id_doctor)
        ->orderBy('Id', 'DESC')
        ->findAll();
    }

    public function get_citas_precio($id_cita){
        return $this->asArray()
        ->select('hcv_quotes.id,hcv_quotes.cost')
        ->where('hcv_quotes.id',$id_cita)
        ->find();
    }

  



}