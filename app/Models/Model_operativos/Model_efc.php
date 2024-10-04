<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_efc extends Model
{
    protected $table = 'hcv_efc';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'exploracion_fisica', 'id_user'];


    public function get_efc($id_user){
        return $this->asArray()
        ->select('hcv_efc.*')
        ->where('hcv_efc.id_user',$id_user)
        ->findAll();
    }

  

}