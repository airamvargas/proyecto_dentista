<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class Payment_type extends Model
{
    protected $table      = 'payment_type';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'description','id_payment_form'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = false;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function redWayToPay(){
        //returns all the payment method data
        return $this->asArray()
        ->select('payment_type.*, way_to_pay.name as forma_pago')
        ->join('way_to_pay', 'way_to_pay.id = payment_type.id_payment_form')
        ->where('payment_type.id != ', PAGO_GLOBAL_T)
        ->where('payment_type.id != ', PARCIAL_T)
        ->orderBy('id', 'DESC')
        ->findAll();
    }
    
    public function readType($id){
        //returns all the payment method data
        return $this->asArray()
        ->select('payment_type.*, way_to_pay.name as forma_pago')
        ->join('way_to_pay', 'way_to_pay.id = payment_type.id_payment_form')
        ->where('id_payment_form', $id)
        ->findAll();
    }

    public function getWayToPay($id){
        //retun one value the what to pay
        return $this->asArray()
        ->where('id', $id)
        ->find();
    }
    
}