<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class Empresas extends Model{
    protected $table = 'cat_company_client';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'name', 'rfc', 'trade_name' , 'id_cat_fiscal_regime', 'email', 'tel_contac', 'fiscal_address', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    //Informacion de todas las empresas con su regimen fiscal para poner en la tabla
    public function getTableEmpresas(){
        return $this->asArray()
        ->select('cat_company_client.*,cat_fiscal_regime.name as regimen_fiscal')
        ->join('cat_fiscal_regime','cat_company_client.id_cat_fiscal_regime = cat_fiscal_regime.id')
        ->where('cat_company_client.id !=', SIN_EMPRESA)
        ->findAll();
    }
 
    //Informacion de una empresa en particular para poner los datos en el modal
    public function getEmpresa($id_emp){
        return $this->asArray()
			->select('*')
			->where('id', $id_emp)
			->find();
    }

    //Nombre de una empresa para ponerlo en el title y enviar id
    public function nameEmpresa($id){
        return $this->asArray()
        ->select('name')
        ->where('id', $id)
        ->find();
    }
}
?>