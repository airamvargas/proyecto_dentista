<?php
/*
Desarrollador: Airam Vargas Lopez
Fecha Creacion: 08 - noviembre -2023
Fecha de Ultima Actualizacion: 
Perfil: Recoleccion
Descripcion: Catalogo de usuarios que pertenecen a una empresa recolectora
*/
namespace App\Models\Recolectoras;

use CodeIgniter\Model;

class Usuarios extends Model{
    protected $table = 'identity_bussiness';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_user', 'name', 'first_name', 'second_name', 'phone', 'photo', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function show($user_id){
        return $this->asArray()
        ->select("identity_bussiness.*, users.code, users.email")
        ->join('users', 'users.id = identity_bussiness.id_user')
        ->where('identity_bussiness.id_user', $user_id)
        ->findAll();
    }

}
