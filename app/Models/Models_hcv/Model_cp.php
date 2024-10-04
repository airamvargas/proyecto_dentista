<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_cp extends Model
{
    protected $table = 'hcv_cat_cp';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['CP', 'ASENTAMIENTO', 'TIPO', 'MUNICIPIO', 'CIUDAD', 'ESTADO', 'CLASIFICACION'];

    public function get_cp($cp){
        return $this->asArray()
        ->select('hcv_cat_cp.CP')
        ->where('hcv_cat_cp.ID',$cp)
        ->findAll();
    }

}

