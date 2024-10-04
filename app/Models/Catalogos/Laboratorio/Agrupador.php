<?php
/* 
Desarrollador: Jesus Esteban Sanchez Alcantara
Fecha Creacion: 11-septiembre-2023
Fecha de última Actualizacion: 11-septiembre-2023
Perfil: Administracion
Descripcion: Catalogo de agrupadores para los analitos
*/ 
namespace App\Models\Catalogos\Laboratorio;

use CodeIgniter\Model;

class Agrupador extends Model{
    protected $table = 'crm_grouper';
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

    // Consulta para mostrar en el datatable los agrupadores registradas
    public function readAgrupador(){
        return $this->asArray()
        ->findAll();
    }

    // Consulta para obtener los datos a imprimir en el modal de editar
    public function getAgrupador($id_agrupador){
        return $this->asArray()
			->select('id, name, description')
			->where('id', $id_agrupador)
			->find();
    }
}
