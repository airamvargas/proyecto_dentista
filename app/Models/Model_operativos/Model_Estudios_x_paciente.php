<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Estudios_x_paciente extends Model
{
    protected $table = 'estudios_x_paciente';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','id_paciente','id_estudios', 'precio'];
    protected $returnType="array";
    protected $useSoftDeletes=false;

    public function get_estudios($id_paciente){
      
            return $this->asArray()
            ->select('estudios_x_paciente.id, hcv_cat_estudios.nombre, hcv_cat_estudios.Precio')
            ->join('hcv_cat_estudios', 'hcv_cat_estudios.id = estudios_x_paciente.id_estudios', 'hcv_cat_estudios.Precio = estudios_x_paciente.precio')
            ->where('estudios_x_paciente.id_paciente',$id_paciente)
            ->orderBy('Id', 'DESC')
            ->findAll();
    }
}