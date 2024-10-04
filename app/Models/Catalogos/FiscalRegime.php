<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class FiscalRegime extends Model{
    protected $table      = 'cat_fiscal_regime';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['code', 'name', 'description', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    //
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function get_fiscal_regime(){
        return $this->asArray()
			->select('id, name, code, description')
			//->where('proveedor_id', $id_proveedor)
			->findAll();
    }

    public function  getFiscalRegime($id_fiscalRegime){
        return $this->asArray()
			->select('id, name, code, description')
			->where('id', $id_fiscalRegime)
			->find();
    }


    

}

?>