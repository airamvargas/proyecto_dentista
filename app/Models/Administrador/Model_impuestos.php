<?php

namespace App\Models\Administrador;

use CodeIgniter\Model;

class Model_impuestos extends Model{
    protected $table      = 'impuestos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['year', 'mounth', 'id_bussines', 'eeff', 'pdf'];
    protected $useTimestamps = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function get_statements(){
        return $this->asArray()
        ->select('impuestos.id, year, mounth, id_bussines, business.business_name, eeff, pdf')
        ->join('business','business.id = impuestos.id_bussines')
		->findAll();
    }

    public function get_statements_update($id){
        return $this->asArray()
        ->select('impuestos.id, year, mounth, id_bussines, business.business_name, eeff, pdf')
        ->join('business','business.id = impuestos.id_bussines')
        ->where('impuestos.id', $id)
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