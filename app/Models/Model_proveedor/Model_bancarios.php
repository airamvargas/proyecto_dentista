<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_bancarios extends Model
{

    protected $table      = 'proveedoresmx_bancarios';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_user', 'banco', 'numero_cuenta', 'clabe', 'moneda', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function get_datos($id_user) {
        return $this->asArray()
        ->select('*')
        ->where('id_user', $id_user)
        ->findAll();
    }

}