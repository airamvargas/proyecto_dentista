<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class Convenios extends Model{
    protected $table = 'cat_conventions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'name', 'id_cat_company_client', 'status',  'date_start', 'date_finish', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    //Informacion de los convenios pertenecientes a una empresa
    public function getTableConvenios(){
        return $this->asArray()
        ->select('cat_conventions.*, cat_company_client.name as empresa_cliente')
        ->join('cat_company_client','cat_conventions.id_cat_company_client = cat_company_client.id')
        ->where('cat_conventions.id !=', SIN_CONVENIO)
        ->where('cat_company_client.deleted_at', '0000-00-00 00:00:00')
		->findAll();
    }

    //Informacion de una empresa en particular para poner los datos en el modal
    public function getConvenio($id_convenio){
        return $this->asArray()
			->select('*')
			->where('id', $id_convenio)
			->find();
    }

    public function readConvenios(){
        return $this->asArray()
        ->select('id, name')
        ->orderBy('id', 'DESC', SIN_CONVENIO)
        ->findAll();
    }

    //Nombre de convenio
    public function nameConvenio($id){
        return $this->asArray()
        ->select('name')
        ->where('id', $id)
        ->find();
    }

    //Listado de convenios por cada empresa
    public function convenioEmpresa($id){
        return $this->asArray()
        ->where('id_cat_company_client', $id)
        ->findAll();
    }
}

?>