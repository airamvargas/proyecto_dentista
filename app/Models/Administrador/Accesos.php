<?php

namespace App\Models\Administrador;
use CodeIgniter\Model;

class Accesos extends Model
{
    protected $table      = 'access';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_group', 'id_module'];

}

