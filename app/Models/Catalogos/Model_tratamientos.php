<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class Model_tratamientos extends Model
{
    protected $table = 'tratamientos';
    protected $primaryKey = 'id';
    protected $returnType="array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['nombre','precio', 'observaciones', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function readProcedimientos(){
        return $this->asArray()
        ->select('*')
        ->find();
    }

    public function readProcedimientoUp($id){
        return $this->asArray()
        ->select('*')
        ->where('tratamientos.id', $id)
        ->find();
    }

    public function readTratamiento($busqueda){
        return $this->asArray()
        ->select('id, nombre, precio, observaciones')
        ->like('tratamientos.nombre', $busqueda)
        ->find();
    }
}