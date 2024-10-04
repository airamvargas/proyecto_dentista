<?php

namespace App\Models;

use CodeIgniter\Model;

class Citas extends Model
{
    protected $table = 'hcv.doctors_x_patients';
    protected $primaryKey = 'id';
    protected $returnType="array";
    protected $allowedFields = ['id', 'patients_id', 'doctor_id'];

    public function getDoctor(){
        $id = $this->getId();
        if(count($id) > 0){
            $id = $id[0]->id;
            $query = "SELECT * FROM `hcv.doctors_x_patients` WHERE `patients_id` = ".$id;
            $data = $this->db->query($query);
	        return $data->getResult();
        }else{
            return [];
        }
    }

    /* public function getDoctorIdentity($id_doctor){
        $query = "SELECT `ID`, `ID_USER`, CONCAT(`NAME`,' ', `F_LAST_NAME`,' ', `S_LAST_NAME`) AS full_name FROM `hcv.identity_operativo` WHERE `ID_USER`=".$id_doctor." AND `DISCIPLINE` = 'Medicina' ";
        //echo $query;
        $data = $this->db->query($query);
	    return $data->getResult();
    } */

    public function getId(){
        $session = session();
        $email = $session->get('email');
        $query ="SELECT `id` FROM `users` WHERE `email`='".$email."'";
        $data = $this->db->query($query);
	    return $data->getResult();
    }

    /* public function get_data_doctor($id_paciente){
        return $this->asArray()
        ->select('hcv.doctors_x_patients.*,hcv.identity_operativo.*')
        ->join('hcv.identity_operativo', 'hcv.identity_operativo.ID_USER = hcv.doctors_x_patients.doctor_id')
        ->where('hcv.doctors_x_patients.patients_id', $id_paciente)
        ->where('hcv.identity_operativo.DISCIPLINE', "Medicina")
        ->find();

        
    } */
}