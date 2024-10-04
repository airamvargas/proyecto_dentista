<?php namespace App\Models;
	
	use CodeIgniter\Model;

	class Member extends Model {

		protected $table="hcv_cat_membresia";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=false;
		protected $allowedFields=['id','name','description'];
		protected $useTimestamps=false;
		protected $createdField='created_at';
		protected $updatedField='updated_at';
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;


		public function get_tipo_membresias(){
			return $this->asArray()
		   ->select('*')
		   ->findAll();
	   }
	

	}