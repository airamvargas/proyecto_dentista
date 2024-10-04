<?php

namespace App\Models\Administrador;

use CodeIgniter\Model;

class Imagenes_avance extends Model{
    protected $table      = 'imagenes_avance';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_cotization_x_product','id_cat_imagen','foto'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}

?>
