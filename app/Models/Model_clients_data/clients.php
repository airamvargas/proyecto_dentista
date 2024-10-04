<?php namespace App\Models;
	
use CodeIgniter\Model;

	class Clients extends Model {
        
        protected $table="clients_data";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=false;
		protected $allowedFields=['id','empresa','name','email','razon_social', 'rfc','phone', 'date_create', 'domicilio_fiscal', 'domocilio_entrega', 'id_user'];
		protected $useTimestamps=true;
		protected $createdField  = 'created_at';
    	protected $updatedField  = 'updated_at';
    	protected $deletedField  = 'deleted_at';
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;
    
    

    	public function max(){
    		$db      = \Config\Database::connect();
    		$builder = $db->table('users');
    		$builder->selectMax('id');
    		$query = $builder->get();
    		return $query->getResultArray();

    	} 

		public function get_id($id_user){
			return $this->asArray()
			->select('id')
			->where('id_user', $id_user)
			->first();
		}
    
    }