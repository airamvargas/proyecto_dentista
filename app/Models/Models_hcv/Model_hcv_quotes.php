<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_hcv_quotes extends Model
{
    protected $table = 'hcv_quotes';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['id','date_time','patient_id','doctor_id','observation','Tipo_de_ciclo','status','link','tipo_consulta','id_tipo_cita','cost'];
    protected $returnType="array";
    protected $useSoftDeletes=false;

    

    public function get_citas($id){
        return $this->asArray()
        ->select('hcv_quotes.*,users.user_name, DATE_FORMAT(hcv_quotes.date_time, "%d/%m/%Y") As Fecha, 
        DATE_FORMAT(hcv_quotes.date_time,"%H:%i:%s") AS Hora,hcv_cat_medical_type.tipo_cita')
        ->join('users', 'users.id = hcv_quotes.patient_id')
        //->join('hcv_doctors_x_patients', 'hcv_doctors_x_patients.patients_id = hcv_quotes.patient_id')
        ->join('hcv_cat_medical_type', 'hcv_cat_medical_type.id = hcv_quotes.id_tipo_cita')
        //->where('hcv_doctors_x_patients.doctor_id',$id)
        ->where('hcv_quotes.doctor_id',$id)
        ->where('hcv_quotes.status',1)
        ->orderBy('hcv_quotes.date_time', 'DESC')
        ->findAll();
    }

    public function get_citas_doc($id){
        return $this->asArray()
        ->select('hcv_quotes.*,users.user_name, DATE_FORMAT(hcv_quotes.date_time, "%d/%m/%Y") As Fecha, 
        DATE_FORMAT(hcv_quotes.date_time,"%H:%i:%s") AS Hora, hcv_identity.NAME,hcv_identity.F_LAST_NAME,hcv_cat_medical_type.tipo_cita')
        ->join('users', 'users.id = hcv_quotes.patient_id')
        ->join('hcv_identity', 'hcv_identity.ID_USER = hcv_quotes.patient_id')
        ->join('hcv_cat_medical_type', 'hcv_cat_medical_type.id = hcv_quotes.id_tipo_cita')
        ->where('hcv_quotes.status',3)
        ->where('doctor_id',$id)
        ->orderBy('hcv_quotes.date_time', 'DESC')
        ->findAll();
        /*return $this->asArray()
        ->select('hcv_quotes.*,users.user_name, DATE_FORMAT(hcv_quotes.date_time, "%d/%m/%Y") As Fecha, 
        DATE_FORMAT(hcv_quotes.date_time,"%H:%i:%s") AS Hora ,hcv_identity.NAME,hcv_identity.F_LAST_NAME,hcv_cat_medical_type.tipo_cita')
        ->join('users', 'users.id = hcv_quotes.patient_id')
        ->join('hcv_doctors_x_patients', 'hcv_doctors_x_patients.patients_id = hcv_quotes.patient_id')
        ->join('hcv_identity', 'hcv_identity.ID_USER = hcv_quotes.patient_id')
        ->join('hcv_cat_medical_type', 'hcv_cat_medical_type.id = hcv_quotes.id_tipo_cita')
        ->where('hcv_doctors_x_patients.doctor_id',$id)
        ->where('hcv_quotes.status',3)
        ->orderBy('ID', 'DESC')
        ->findAll();*/
    }

    public function get_fecha_cita($id){
        $query = "SET lc_time_names = 'es_ES'";
        $check_sql = "SELECT DATE_FORMAT(hcv_quotes.date_time,'%d-%b-%Y') AS fecha FROM hcv_quotes WHERE `id`=".$id." ";
        $data = $this->db->query($check_sql);
	    return $data->getResult();


    }

}