<?php
/*
Desarrollador: Jesus Esteban Sanchez Alcantara
Fecha Creacion: 16-agosto-2023
Fecha de Ultima Actualizacion: 21-agosto-2023
Perfil: Administracion
Descripcion: Catalogo de muestras
*/
namespace App\Models\Catalogos\Laboratorio;

use CodeIgniter\Model;

class Muestras extends Model{
    protected $table = 'sample_types';
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

    // Consulta para mostrar en el datatable las muestras registradas
    public function readMuestras(){
        return $this->asArray()
        ->findAll();
    }

    // Consulta para obtener los datos a imprimir en el modal de editar
    public function getMuestra($id_muestra){
        return $this->asArray()
			->select('id, name, description')
			->where('id', $id_muestra)
			->find();
    }
}
