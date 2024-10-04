<?php

namespace App\Models\HCV\Administrativos;

use CodeIgniter\Model;

class Model_mini_procedimiento extends Model {

	protected $table = "hcv_procedimientos_mini";
	protected $primaryKey = "id";
	protected $returnType = "array";
	protected $useSoftDeletes = true;
	protected $allowedFields = ['id_cat_procedimientos', 'common_name', 'categoria', 'created_at', 'updated_at', 'deleted_at'];
	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deleteddField = 'deleted_at';
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;


	public function readProcedimientos(){
		return $this->asArray()
        ->select('*')
        ->findAll();
	}

	public function readProcedimiento($id){
		return $this->asArray()
        ->select('hcv_procedimientos_mini.*, PRO_NOMBRE')
		->join('hcv_cat_procedimientos', 'hcv_cat_procedimientos.id = hcv_procedimientos_mini.id_cat_procedimientos')
		->where('hcv_procedimientos_mini.id', $id)
        ->find();
	}

	public function readProcedimientosSel(){
		return $this->asArray()
        ->select('id, common_name')
        ->findAll();
	}	

	
}
