<?php namespace App\Models;
	
	use CodeIgniter\Model;

	class model_religiones extends Model {
        protected $table="hcv_cat_religion";
		protected $primaryKey="ID";
		protected $returnType="array";
		protected $useSoftDeletes=false;
		protected $allowedFields=['CLAVE_CREDO','CREDO','CLAVE_GRUPO','GRUPO','CLAVE_DENOMINACION','DENOMINACION','CLAVE_RELIGION','RELIGION'];
		protected $useTimestamps=false;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;

        public function get_religion(){
            return $this->asArray()
            ->select('hcv_cat_religion.*')
            ->findAll();
        }

        public function insert_bulk($array){
            $db = \Config\Database::connect();
            $builder = $db->table('hcv_cat_religion');
            return $builder->insertBatch($array);
        }

        public function get_religion_name($clave){
            return $this->asArray()
            ->select('hcv_cat_religion.RELIGION')
            ->where('ID',$clave)
            ->find();
        }

        

        
    }