<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class C10 extends Model
{
    protected $table      = 'hcv_cie10';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['ID', 'CONSECUTIVO','LETRA','CATALOG_KEY','NOMBRE','CODIGOX','LSEX','LINF'];

   

   public function getENFERMEDAD($busqueda){
    return $this->asObject()
        ->select('ID, NOMBRE,')
        ->like('NOMBRE', $busqueda)    
        ->findAll(100);
   }
    
}