<?php

namespace App\Models\Generales;

use CodeIgniter\Model;
class Type_notificacion extends Model{
    protected $table      = 'type_of_notification';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['tipo', 'mensaje'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}

?>