<?php namespace App\Models;
	
	use CodeIgniter\Model;

	class Model_mini_c10 extends Model {

		protected $table="hcv_cie10_mini";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=false;
		protected $allowedFields=['id','nombre_comun','cie10_id','categoria'];
		protected $useTimestamps=false;
		protected $createdField='created_at';
		protected $updatedField='updated_at';
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;


        public function get_minic10(){
            return $this->asArray()
            ->select('hcv_cie10_mini.*,hcv_cie10.CATALOG_KEY,hcv_cie10.NOMBRE')
            ->join('hcv_cie10', 'hcv_cie10.ID = hcv_cie10_mini.cie10_id')
			->where('deleted_at', null)
            ->findAll();
        }

        public function get_procedimiento(){
        	 return $this->asArray()
            ->select('*')
            ->where('categoria','Procedimiento')
			->where('deleted_at', null)
            ->findAll();
        }

        

	}