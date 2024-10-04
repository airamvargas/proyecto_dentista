<?php

namespace App\Models\Model_registro;

use CodeIgniter\Model;

class Generales extends Model
{
    protected $table = 'generales';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'razon_social', 'commercial_name', 'rfc', 'product', 'web', 'user_id'];
    protected $useTimestamps = false;
    
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function get_datos($id_user){
        return $this->asArray()
        ->where('user_id',$id_user)
        ->find();        
    }

    public function get_proveedor_user($id_user){
        return $this->asArray()
		->select('generales.razon_social, generales.commercial_name, users.id, users.user_name, users.email, users.password, users.token')
		->join('users', 'users.id = generales.user_id')
		->where('generales.user_id',$id_user)->findall();
    }
}