<?php

namespace App\Models\Model_operativos;

use CodeIgniter\Model;

class Model_estados extends Model
{
    protected $table = 'hcv_cat_states';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['id', 'code', 'state'];
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function get_estados(){
        return $this->asArray()
        ->select('hcv_cat_states.*')
        ->findAll();
    }

}