<?php

namespace App\Models\Administrador;

use CodeIgniter\Model;

class Groups extends Model
{
    protected $table      = 'groups';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name','description',"active","hierarchy","c_date"];

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

    public function read(){
        //returns all the payment method data
        return $this->asArray()->orderBy('id', 'DESC')
        ->findAll();
    }
    

    public function getData($id){
        //retun one value the what to pay
        return $this->asArray()
        ->where('id', $id)
        ->find();
    }

    public function getName($id){
        return $this->asObject()
        ->select("name")
        ->where('id', $id)
        ->find();
        
    }

    

   
    
}