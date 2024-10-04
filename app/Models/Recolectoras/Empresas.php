<?php
/*
Desarrollador: Jesús Esteban Sánchez Alcántara
Fecha Creacion: 11 - octubre -2023
Fecha de Ultima Actualizacion: 
Perfil: Recoleccion
Descripcion: Catalogo de empresas recolectoras
*/
namespace App\Models\Recolectoras;

use CodeIgniter\Model;

class Empresas extends Model{
    protected $table = 'crm_processing_company';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'description', 'type','tel','id_user', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Consulta para mostrar en el datatable las empresas recolectoras registradas
    public function readEmpresas(){
        return $this->asArray()
        ->findAll();
    }

    // Consulta para obtener los datos a imprimir en el modal de editar
    public function getCompany($id_company){
        return $this->asArray()
			->select('crm_processing_company.id, crm_processing_company.name, crm_processing_company.description, crm_processing_company.type, users.email')
            ->join('users', 'users.id = crm_processing_company.id_user')
			->where('crm_processing_company.id', $id_company)
			->find();
    }
}
