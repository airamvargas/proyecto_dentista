<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_diagnostic_nutricional extends Model
{
    protected $table = 'hcv_diagnostic_nutricional';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','tipo','balance','grasa','ingesta', 'id_patient', 'id_folio','id_medico'];
    protected $returnType="array";
    protected $useSoftDeletes=false;

  
 }