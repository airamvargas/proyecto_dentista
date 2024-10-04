<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Ipays extends Model
{
    protected $table = 'hcv_ipays';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'interrogatorio', 'id_user'];


    public function get_ipays($id_user){
        return $this->asArray()
        ->select('hcv_ipays.*')
        ->where('hcv_ipays.id_user',$id_user)
        ->findAll();
    }

  

}