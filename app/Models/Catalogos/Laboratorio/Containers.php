<?php

// Desarrollador: Airam Vargas
// Fecha de creacion: 16 - agosto - 2023
// Fecha de Ultima Actualizacion:
// Perfil: Administrador
// Descripcion: Catálogo de contenedores para muestras

namespace App\Models\Catalogos\Laboratorio;

use CodeIgniter\Model;

class Containers extends Model{
    protected $table      = 'containers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'description', 'measure', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function showContainers(){
        return $this->asArray()
        ->findAll();
    }
    
    public function readContainer($id){
        return $this->asArray()
        ->where('id', $id)
        ->findAll();
    } 

}
