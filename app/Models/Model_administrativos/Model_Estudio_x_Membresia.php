<?php namespace App\Models;
	
	use CodeIgniter\Model;

	class Model_Estudio_x_Membresia extends Model {
        protected $table="membresia_x_estudios";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=true;
		protected $allowedFields=['id','sector_id','membresia_id','tipo_cita_id', 'estudios_id', 'precio', 'deleted_at'];
		protected $useTimestamps=false;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;


        
		public function get_table_e_m(){
			$db = \Config\Database::connect();
			$builder = $db->table('membresia_x_estudios');
			$builder->select('membresia_x_estudios.id, hcv_cat_estudios.nombre, hcv_cat_estudios.preparacion, hcv_cat_medical_type.tipo_cita, hcv_cat_sector.description, hcv_cat_membresia.name, membresia_x_estudios.precio ');
			$builder->join('hcv_cat_estudios', 'hcv_cat_estudios.id = membresia_x_estudios.estudios_id');
			$builder->join('hcv_cat_medical_type', 'hcv_cat_medical_type.id = membresia_x_estudios.tipo_cita_id');
			$builder->join('hcv_cat_sector', 'hcv_cat_sector.id = membresia_x_estudios.sector_id');
			$builder->join('hcv_cat_membresia', 'hcv_cat_membresia.id = membresia_x_estudios.membresia_id');
			$builder->where('membresia_x_estudios.deleted_at', '0000-00-00 00:00:00');
			$data = $builder->get()->getResultArray();
			return $data;
		}

		public function get_estudios_HCV($clave){
            return $this->asArray()
            ->select('hcv_cat_estudios.id AS id_estudio, hcv_cat_estudios.nombre, hcv_cat_estudios.preparacion, membresia_x_estudios.id AS id_membresia_x_estudio, membresia_x_estudios.sector_id, membresia_x_estudios.membresia_id, membresia_x_estudios.precio')
			->join('hcv_cat_estudios', 'hcv_cat_estudios.id = membresia_x_estudios.estudios_id')
			->join('hcv_cat_sector', 'hcv_cat_sector.id = membresia_x_estudios.sector_id')
			->join('hcv_cat_membresia', 'hcv_cat_membresia.id = membresia_x_estudios.membresia_id')
            ->where('membresia_x_estudios.id',$clave)
            ->find();
        }

    }