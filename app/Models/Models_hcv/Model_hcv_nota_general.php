<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_hcv_nota_general extends Model
{
    protected $table = 'hcv_nota_general';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','id_medico','nota','name_medico','time','date','id_patient','id_folio'];
    protected $returnType="array";
    protected $useSoftDeletes=true;
    protected $deletedField  = 'deleted_at';
}