<?php

namespace App\Models\Administrador;

use CodeIgniter\Model;

class Model_statements extends Model{
    protected $table      = 'account_statements';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['year', 'month', 'id_business', 'bank', 'moneda', 'pdf'];
    protected $useTimestamps = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function get_statements(){
        return $this->asArray()
        ->select('account_statements.id, year, month, id_business, business.business_name, bank, moneda, cat_currency.name, pdf')
        ->join('business','business.id = account_statements.id_business')
        ->join('cat_currency','cat_currency.id = account_statements.moneda')
		->findAll();
    }

    public function get_statements_update($id){
        return $this->asArray()
        ->select('account_statements.id, year, month, id_business, business.business_name, bank, moneda, cat_currency.name, pdf')
        ->join('business','business.id = account_statements.id_business')
        ->join('cat_currency','cat_currency.id = account_statements.moneda')
        ->where('account_statements.id', $id)
		->findAll();
    }

    public function get_id_statement($id){
        return $this->asObject()
        ->select('pdf')
        ->where('account_statements.id', $id)
        ->findAll();
    }


}

?>
