<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_marital_status extends Model
{
    protected $table = 'hcv_cat_marital_status';
    protected $primaryKey = 'ID';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['NAME', 'DESCRIPTION'];
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}