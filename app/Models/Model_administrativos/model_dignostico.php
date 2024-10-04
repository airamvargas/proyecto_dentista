<?php namespace App\Models;
	
	use CodeIgniter\Model;

	class model_dignostico extends Model {
        protected $table="hcv_diagnostic_history";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=false;
		protected $allowedFields=['id','enfermedad','grupo','fecha','time','id_patient','id_folio','id_medico'];
		protected $useTimestamps=false;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;

        public function get_diagnostico($id_folio){
            return $this->asArray()
            ->select('hcv_diagnostic_history.id, hcv_diagnostic_history.enfermedad, DATE_FORMAT(hcv_diagnostic_history.fecha, "%d/%m/%Y") As fecha')
            ->where('hcv_diagnostic_history.id_folio',$id_folio)->findall();
        }

		public function delete_enfermedad($id)
	{
		$builder = $this->db->table('hcv_diagnostic_history');
		$builder->where('id', $id);
		$builder->delete();
	}

        
    }