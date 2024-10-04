<?php namespace App\Models;
	
	use CodeIgniter\Model;

	class Model_procedimientos extends Model {

		protected $table="hcv_cat_procedimientos";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=false;
		protected $allowedFields=['id','CATALOG_KEY','PRO_NOMBRE','PRO_CVE_EDIA','PRO_EDAD_IA','PRO_CVE_EDFA','PRO_EDAD_FA','CLAVE_RELIGION','SEX_TYPE','POR_NIVELA','PROCEDIMIENTO_TYPE','PRO_PRINCIPAL','PRO_CAPITULO','PRO_SECCION','PRO_CATEGORIA','PRO_SUBCATEG','PRO_GRUPO_LC','PRO_ES_CAUSES','PRO_NUM_CAUSES'];
		protected $useTimestamps=false;
		protected $createdField='created_at';
		protected $updatedField='updated_at';
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;



		public function insert_bulk($array){
            $db = \Config\Database::connect();
            $builder = $db->table('hcv_cat_procedimientos');
            return $builder->insertBatch($array);
        }
	}