<?php namespace App\Models;
	
	use CodeIgniter\Model;

	class Evidencias extends Model {
        protected $table="photo_evidency";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=false;
		protected $allowedFields=['id', 'name_foto', 'fecha', 'hora', 'descripcion', 'id_patient', 'id_folio', 'id_medico'];
		protected $useTimestamps=false;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;

      
    }