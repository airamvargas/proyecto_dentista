<?php

namespace App\Models\HCV\Operativo;

use CodeIgniter\Model;

class Tomador_areas extends Model {
    protected $table = 'categorylab_x_user';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id','id_user', 'id_category_lab','created_at','updated_at','deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
  
    //Areas a las cuales pertenece un tomador de muestra
    public function get_areas($id_user){
        return $this->asArray()
        ->select('categorylab_x_user.*, category_lab.name as area')
        ->join('category_lab', 'category_lab.id = categorylab_x_user.id_category_lab')
        ->join('users', 'users.id = categorylab_x_user.id_user')
        ->where('categorylab_x_user.id_user', $id_user)
        ->find();
    }

    // Verificacion de que no exista area repetida para tomador
    public function areaRepetida($id, $area){
        return $this->asArray()
        ->select('id')
        ->where('id_category_lab', $area)
        ->where('id_user', $id)
        ->find();
    }

    //Areas a las cuales pertenece un tomador de muestra
    public function readAreas($id_user){
        return $this->asArray()
        ->select('id_category_lab')
        ->where('categorylab_x_user.id_user', $id_user)
        ->find();
    }
}