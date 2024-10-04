<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_religion extends Model
{
    protected $table = 'hcv_cat_religion';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['CLAVE_CREDO', 'CREDO','CLAVE_GRUPO','GRUPO','CLAVE_DENOMINACION'
    ,'DENOMINACION','CLAVE_RELIGION','RELIGION'];


    public function get_religion(){
        return $this->asArray()
        ->select('hcv_cat_religion.*')
        ->limit(10)
        ->findAll();
    }

    public function readReligion($religion){
        $query = "SELECT * FROM  hcv_cat_religion where RELIGION LIKE '"."%".$religion."%"."' LIMIT 10";
        $query_result = $this->db->query($query);
        return $query_result->getResult();	
    }

  

}