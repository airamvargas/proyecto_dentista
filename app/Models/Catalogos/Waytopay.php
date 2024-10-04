<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class Waytopay extends Model
{
    protected $table      = 'way_to_pay';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'description'];

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
        return $this->asArray()->orderBy('id', 'DESC')
        ->where('id !=', PAGO_GLOBAL_F) //EN produccion != 
        ->where('id !=', PARCIAL_F)
        ->findAll();
    }

    public function getWayToPay($id){
        //retun one value the what to pay
        return $this->asArray()
        ->where('id', $id)
        ->find();
    }
}
?>