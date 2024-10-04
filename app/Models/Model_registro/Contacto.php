<?php

namespace App\Models\Model_registro;

use CodeIgniter\Model;

class Contacto extends Model
{
    protected $table = 'contact';
    protected $primaryKey = 'id_razon';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_razon', 'contrato', 'telefono', 'celular', 'calle', 'exterior', 'interior', 'colonia', 'cp', 'ciudad', 'estado', 'user_id'];
    protected $useTimestamps = false;
    
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    

    public function get_datos($id_user){
        return $this->asArray()
        ->where('user_id',$id_user)
        ->find();        
    }
}