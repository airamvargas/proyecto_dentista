<?php

namespace App\Models\Models_hcv;

use CodeIgniter\Model;

class Model_academic extends Model
{
    protected $table = 'hcv_cat_academic';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['KEY', 'ACADEMIC_FORMATION', 'GROUP' , 'DEGREE'];
    
    public function insert_bulk($array){
        $db      = \Config\Database::connect();
        $builder = $db->table('hcv_cat_academic');
        return $builder->insertBatch($array);
    }

    public function get_academic($especialidad){
        $query = "SELECT ID, ACADEMIC_FORMATION  FROM  hcv_cat_academic  where (DEGREE = 12 or DEGREE = 3 or DEGREE = 5 or DEGREE = 8 or DEGREE = 9 or DEGREE = 13) and ACADEMIC_FORMATION LIKE '"."%".$especialidad."%"."'";
        /* $query = "SELECT * fROM hcv_cat_academic  where (DEGREE = 12 or DEGREE = 3 or DEGREE = 5) and ACADEMIC_FORMATION LIKE '".$especialidad."' LIMIT 2 " ; */
        $query_result = $this->db->query($query);
        return $query_result->getResult();
    }
}