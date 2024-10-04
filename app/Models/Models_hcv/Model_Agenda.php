<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Agenda extends Model
{
    protected $table = 'hcv_quotes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['date_time', 'patient_id', 'doctor_id', 'observation', 'status'];

    public function insert_bulk($array)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('hcv_cie10');
        return $builder->insertBatch($array);
    }
    public function getagenda($id){
        $db      = \Config\Database::connect();
        $builder = $db->table('hcv_quotes');
        $builder->select('date_time');
        $builder->where('id',$id);
        $query = $builder->get();
        return $query->getResult();

    }
    
    public function getfecha($id,$id_doctor){
        $db      = \Config\Database::connect();
        $builder = $db->table('hcv_quotes');
        $builder->select('date_time');
    
        $builder->where('doctor_id',$id_doctor);
        $query = $builder->get();
        return $query->getResult();

    }
    public function getEvents($start)
{
    return $this->db->table($this->table)->where('start ≥', $start)
    ->get()->getResult();
}  



    public function get_doctor($id){
        $db      = \Config\Database::connect();
        $builder = $db->table('hcv_doctors_x_patients');
        $builder->select('id,doctor_id');
        $builder->where('patients_id',$id);
        $query = $builder->get();
        return $query->getResult();
    }

    public function get_max_id_quotes(){
        $db      = \Config\Database::connect();
        $builder = $db->table('hcv_quotes');
        $builder->select('MAX(id) as id');

        $query = $builder->get();
        return $query->getResult();
    }
}