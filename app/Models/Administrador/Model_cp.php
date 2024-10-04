<?php

namespace App\Models\Administrador;

use CodeIgniter\Model;

class Model_cp extends Model{
    protected $table      = 'hcv_cat_cp';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['CP','ASENTAMIENTO','TIPO','MUNICIPIO','CIUDAD', 'ESTADO', 'CLASIFICACION'];
    protected $useTimestamps = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getCp($search, $limit, $offset){
        return $this->asArray()
        ->like('CP',$search)
        ->orderBy('ID', 'CP')
        ->findAll($limit , $offset);
    }

}
?>