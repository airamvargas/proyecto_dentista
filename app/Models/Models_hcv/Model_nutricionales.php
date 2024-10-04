<?php

namespace App\Models\Models_hcv;

use CodeIgniter\Model;

class Model_nutricionales extends Model
{
    protected $table = 'hcv_nutricionales';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id','tipo_comida','num_comidas_dia','comida_en_casa','consumo_alcohol','num_copas', 'suplemento','s_descripcion','tipo_de_bebida', 'user_id','created_at','updated_at','deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function read($id){
        return $this->asArray()
        ->select('hcv_nutricionales.*')
        ->where('user_id', $id)
        ->orderBy('id DESC')
        ->limit(1)
        ->find();
    }
}