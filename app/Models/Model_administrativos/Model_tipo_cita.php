<?php namespace App\Models;
	
	use CodeIgniter\Model;

	class Model_tipo_cita extends Model {

		protected $table="hcv_cat_medical_type";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=true;
		protected $allowedFields=['id','tipo_cita','precio'];
		protected $useTimestamps=false;
		protected $createdField='created_at';
		protected $updatedField='updated_at';
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;


        public function get_tipo_citas(){
        	 return $this->asArray()
            ->select('*')
            ->findAll();
        }

		public function get_data($id){
			return $this->asArray()
		   ->select('*')
		   ->where('id',$id)
		   ->findAll();
	   }

		

        

	}