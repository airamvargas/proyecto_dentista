<?php

namespace App\Models\Administrador;

use CodeIgniter\Model;

class Model_financial extends Model{
    protected $table      = 'financial_statements';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['year', 'month', 'id_bussiness', 'eeff', 'pdf'];
    protected $useTimestamps = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function get_statements(){
        return $this->asArray()
        ->select('financial_statements.id, year, month, id_bussiness, business.business_name, eeff, pdf')
        ->join('business','business.id = financial_statements.id_bussiness')
		->findAll();
    }

    public function get_statements_update($id){
        return $this->asArray()
        ->select('financial_statements.id, year, month, id_bussiness, business.business_name, eeff, pdf')
        ->join('business','business.id = financial_statements.id_bussiness')
        ->where('financial_statements.id', $id)
		->findAll();
    }

    public function get_id_statement($id){
        return $this->asObject()
        ->select('pdf')
        ->where('id', $id)
        ->first();
    }


}

?>
