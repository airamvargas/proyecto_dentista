<?php namespace App\Models\Administrador;
	
	use CodeIgniter\Model;

	class Model_docs_cotization extends Model {
        
        protected $table="documentacion_clientes";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=true;
		protected $allowedFields=['cotization_product_id', 'id_cat_files_clientes', 'name_file', 'created_at', 'updated_at', 'deleted_at'];
		protected $useTimestamps=true;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;

        public function get_file($id){
			return $this->asArray()
            ->select('name_file')
			->where('id', $id)
            ->findAll();
		}
    }
?>  