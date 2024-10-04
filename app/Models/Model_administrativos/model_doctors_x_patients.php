<?php namespace App\Models;
	
	use CodeIgniter\Model;

	class model_doctors_x_patients extends Model {
        protected $table="hcv_doctors_x_patients";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=false;
		protected $allowedFields=['id','patients_id','doctor_id'];
		protected $useTimestamps=false;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;


        
		public function update_p($data1,$id,$id_principal){
			$data = $this->db->table('hcv_doctors_x_patients');
            $data->where('id', $id_principal);
            $data->update($data1);
		}
        
    }