<?php

namespace App\Models\HCV\Operativo;

use CodeIgniter\Model;

class Unidad_negocio extends Model {
    protected $table = 'business_unit_x_doctor';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id','id_business_unit','id_user','created_at','updated_at','deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
  
    //Unidades de negocio a las cuales pertenece un doctor
    public function get_unidades($id_user){
        return $this->asArray()
        ->select('business_unit_x_doctor.*, cat_business_unit.name as unidad_negocio, cat_business_unit.name as id')
        ->join('cat_business_unit', 'cat_business_unit.id = business_unit_x_doctor.id_business_unit')
        ->join('users', 'users.id = business_unit_x_doctor.id_user')
        ->where('business_unit_x_doctor.id_user', $id_user)
        ->where('cat_business_unit.deleted_at', null)
        ->find();
    }

    // Verificacion de que no exista unidad repetida para operativo
    public function unidadRepetida($id, $unidad){
        return $this->asArray()
        ->select('id')
        ->where('id_business_unit', $unidad)
        ->where('id_user', $id)
        ->find();
    }

}