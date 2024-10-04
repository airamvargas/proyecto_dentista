<?php
/* 
Desarrollador: Jesus Esteban Sanchez Alcantara
Fecha Creacion: 8-septiembre-2023
Fecha de Ultima Actualizacion: 8-septiembre-2023
Perfil: Administracion
Descripcion: Catalogo de unidades de medicion 
*/ 
namespace App\Models\Catalogos\Laboratorio;

use CodeIgniter\Model;

class Unidades_medicion extends Model{
    protected $table = 'crm_cat_measurement_units';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'prefix', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Consulta para mostrar en el datatable las unidades registradas
    public function readUnidades(){
        return $this->asArray()
        ->findAll();
    }

    // Consulta para obtener los datos a imprimir en el modal de editar
    public function getUnidad($id_unidad){
        return $this->asArray()
			->select('id, name, prefix')
			->where('id', $id_unidad)
			->find();
    }
}
