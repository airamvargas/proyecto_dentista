<?php

namespace App\Models\Models_hcv;

use CodeIgniter\Model;

class Model_ginecoobstetrico extends Model
{
    protected $table = 'hcv_ginecoobstetrico';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['menarca','inicio_de_vida_sexual','tipo_de_ciclo','numero_de_embarazos','numero_de_partos','numero_de_cesareas','numeros_de_abortos','ha_dado_lactancia','edad_inicio_menopausia','numeros_parejas_sexuales', 'user_id','created_at','updated_at','deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function readGine($id){
        return $this->asArray()
        ->select('hcv_ginecoobstetrico.*')
        ->where('user_id',$id)
        ->orderBy('id DESC')
        ->limit(1)
        ->find(); 
    }
}