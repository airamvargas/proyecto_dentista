<?php

namespace App\Models\HCV\Administrativos;

use CodeIgniter\Model;

class Model_procedimientos extends Model {

	protected $table = "hcv_cat_procedimientos";
	protected $primaryKey = "id";
	protected $returnType = "array";
	protected $useSoftDeletes = false;
	protected $allowedFields = ['CATALOG_KEY', 'PRO_NOMBRE', 'PRO_CVE_EDIA', 'PRO_EDAD_IA', 'PRO_CVE_EDFA', 'PRO_EDAD_FA', 'SEX_TYPE', 'POR_NIVELA', 'PROCEDIMIENTO_TYPE', 'PRO_PRINCIPAL', 'PRO_CAPITULO', 'PRO_SECCION', 'PRO_CATEGORIA', 'PRO_SUBCATEG', 'PRO_GRUPO_LC', 'PRO_ES_CAUSES', 'PRO_NUM_CAUSES'];
	protected $useTimestamps = false;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;


	public function readProcedimientos($busqueda, $type){
        return $this->asObject()
        ->select('id, PRO_NOMBRE')  
        ->like('PRO_NOMBRE', $busqueda)
        ->where('PROCEDIMIENTO_TYPE', $type)
        ->findAll(70);
    }

	public function readProcedimientosTipo($busqueda){
        return $this->asObject()
        ->select('id, PRO_NOMBRE')  
        ->like('PRO_NOMBRE', $busqueda)
        ->findAll(50);
    }

	public function readProcedimientosOdonto(){
		return $this->asArray()
        ->select('id, PRO_NOMBRE')
		->like('PRO_NOMBRE', 'dental')
        ->findAll();
	}

	public function readProcedimientosPsico(){
		return $this->asArray()
        ->select('id, PRO_NOMBRE')
		->like('PRO_NOMBRE', 'psico')
        ->findAll();
	}
}
