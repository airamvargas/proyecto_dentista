<?php

namespace App\Models\Model_registro;

use CodeIgniter\Model;

class Banco extends Model
{
    protected $table = 'bank';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'banco', 'n_cta', 'clabe', 'moneda',  'user_id'];
    protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function get_table_banco($id_user){
        return $this->asArray()
        ->where('user_id',$id_user)
        ->find();        
    }
}