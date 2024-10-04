<?php
/*
Desarrollador: Airam Valeria Vargas López
Fecha Creacion: 07 - 09 - 2023
Fecha de Ultima Actualizacion: 
Perfil: Administracion
Descripcion: Catalogo de métodos que pueden utilizarse
*/
namespace App\Models\Catalogos\Laboratorio;

use CodeIgniter\Model;

class Cat_methods extends Model{

    protected $table = 'crm_cat_methods';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'description', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function showMethods(){
        return $this->asArray()
        ->findAll();
    }

    public function readMethod($id){
        return $this->asArray()
        ->where('id', $id)
        ->findAll();
    }

    public function getMethods(){
        return $this->asArray()
        ->findAll();
    }
}