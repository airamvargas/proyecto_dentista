<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_cat_indigenous_lenguage extends Model
{
    protected $table = 'hcv_cat_indigenous_lenguge';
    protected $primaryKey = 'ID';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['KEY', 'SCIENTIFIC_NAME' , 'DESCRIPTION'];

    /* public function readLanguage ($busqueda){
        return $this->asObject()
        ->select('ID, SCIENTIFIC_NAME')
        ->like('SCIENTIFIC_NAME', $busqueda)    
        ->findAll(100);
    } */
}