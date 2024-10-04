<?php namespace App\Models;
	
	use CodeIgniter\Model;

	class Model_Estudios extends Model {
        protected $table="hcv_cat_estudios";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=false;
		protected $allowedFields=['id','nombre','preparacion','Precio'];
		protected $useTimestamps=false;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;


        
		public function get_estudios(){
            return $this->asArray()
            ->select('hcv_cat_estudios.id, hcv_cat_estudios.nombre, hcv_cat_estudios.preparacion, hcv_cat_estudios.Precio')
            ->findAll();
		}

		public function get_estudio($id){
            return $this->asArray()
            ->select('hcv_cat_estudios.*')
			->where('hcv_cat_estudios.id',$id)
            ->findAll();
			
		}
    }