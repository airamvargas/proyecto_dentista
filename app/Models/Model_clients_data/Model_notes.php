<?php namespace App\Models;
	
	use CodeIgniter\Model;

	class Model_notes extends Model {
        
        protected $table="clients_notas";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=true;
		protected $allowedFields=['id_cotizacion_x_product', 'nota', 'created_at', 'updated_at', 'deleted_at'];
		protected $useTimestamps=true;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;

        public function get_id($id){
            return $this->asArray()
            ->select('id, nota')
            ->where('id_cotizacion_x_product', $id)
            ->findAll();
        }
    
    }
?>  