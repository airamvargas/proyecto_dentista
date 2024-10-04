<?php namespace App\Models\Model_cat_files;
	
	use CodeIgniter\Model;

	class Model_files_cotization extends Model {
        
        protected $table="cat_files_clients";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=true;
		protected $allowedFields=['name','created_at','updated_at', 'deleted_at'];
		protected $useTimestamps=true;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;
    
        public function get_type(){
            return $this->asArray()
            ->select('*')
            ->findAll();
        }

        public function get_docs($id_cotization){
            return $this->asArray()
            ->select('documentacion_clientes.name_file, cat_files_clients.name AS type_file, documentacion_clientes.id')
            ->join('documentacion_clientes', 'cat_files_clients.id = documentacion_clientes.id_cat_files_clientes')
            ->join('cotization_x_products', 'cotization_x_products.id = documentacion_clientes.cotization_product_id')
            ->where('cotization_product_id', $id_cotization)
            ->findAll();
        }
    	 
    }
?>  