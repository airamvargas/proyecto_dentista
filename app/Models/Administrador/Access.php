<?php

namespace App\Models\Administrador;

use App\Models\modules as ModelsModules;
use CodeIgniter\Model;

class Access extends Model
{
    protected $table      = 'access';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_group', 'id_module','is_cat',"create_a","read_a","update_a","delete_a"];

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = false;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function validateAcess($id_group,$id_module){
        //valida si ya existe el modulo en base
        return $this->asObject()
        ->selectCount('id_group')
        ->where('id_group',$id_group)
        ->where('id_module',$id_module)
        ->first();
    }

    public function read($id_group,$id_module){
        //regresa los datos para actualizar el dato de acess
        return $this->asArray()
        ->where('id_group',$id_group)
        ->where('id_module',$id_module)
        ->find();
    }

    public function updateAcess($data,$id_group,$id_module){
        //Actualizacion
        $db      = \Config\Database::connect();
        $this->builder()
        ->where('id_group', $id_group)
        ->where('id_module',$id_module)
        ->update($data);
        return $affected_rows = $db->affectedRows();
    }

    public function deleteAcess($id_group,$id_module){
        //Eliminación
        $db      = \Config\Database::connect();
        $this->builder()
        ->where('id_group', $id_group)
        ->where('id_module',$id_module)
        ->delete();
        return $affected_rows = $db->affectedRows();

    }

    

}