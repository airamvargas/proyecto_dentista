<?php namespace App\Models;
	
	use CodeIgniter\Model;

	class Model_Vehiculos extends Model {
        
        protected $table="vehicles";
		protected $primaryKey="id";
		protected $useAutoIncrement = true;
		protected $returnType="array";
		protected $useSoftDeletes=true;
		protected $allowedFields=['id','name','size','price_km','price_send','created_at','updated_at','deleted_at','c_date','id_user','latitude','length'];
		protected $useTimestamps=true;
		protected $createdField  = 'created_at';
		protected $updatedField  = 'updated_at';
		protected $deletedField  = 'deleted_at';

		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;

		//Datos de vehiculos

		public function get_vehiculos(){
			return $this->asArray()
			->select('vehicles.*')
			->where('deleted_at',null)
			->findAll();
		}

	

    }

