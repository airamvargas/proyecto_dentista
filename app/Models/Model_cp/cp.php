<?php namespace App\Models;

	use CodeIgniter\Model;

	class Cp extends Model {

        protected $table="hcv_cat_cp_custom";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=false;
		protected $allowedFields=['id','id_hcv_cat_cp','id_hcv_cat_sector'];
		protected $useTimestamps=false;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;


		public function get_cp_all(){
			$Nombres = $this->db->query("SELECT * from hcv_cat_cp");
			return $Nombres->getResult();
		}
	}