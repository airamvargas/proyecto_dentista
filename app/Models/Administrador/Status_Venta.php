<?php

namespace App\Models\Administrador;

use CodeIgniter\Model;

class Status_Venta extends Model{
    protected $table      = 'status_venta';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_cotozation_x_product','status'];
    protected $useTimestamps = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}





?>
