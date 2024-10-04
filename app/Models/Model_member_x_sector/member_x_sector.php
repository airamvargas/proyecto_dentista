<?php namespace App\Models;
	
	use CodeIgniter\Model;

	class Member_x_sector extends Model {

		protected $table="membresia_x_sector";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=false;
		protected $allowedFields=['id','id_hcv_cat_sector','id_hcv_cat_membresia','precio','id_tipo_cita'];
		protected $useTimestamps=false;
		protected $createdField='created_at';
		protected $updatedField='updated_at';
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;


		public function get_table_m_s(){
			$db      = \Config\Database::connect();
        $builder = $db->table('membresia_x_sector');
        $builder->select('membresia_x_sector.id , hcv_cat_membresia.name,hcv_cat_sector.name as nombre_sector,membresia_x_sector.precio,hcv_cat_medical_type.tipo_cita');
        $builder->join('hcv_cat_sector', 'hcv_cat_sector.id=membresia_x_sector.id_hcv_cat_sector');
        $builder->join('hcv_cat_membresia', 'hcv_cat_membresia.id=membresia_x_sector.id_hcv_cat_membresia');
		$builder->join('hcv_cat_medical_type', 'hcv_cat_medical_type.id = membresia_x_sector.id_tipo_cita');
        $data = $builder->get()->getResultArray();
        return $data;
		}



		public function verify($id_sector,$id_membresia){
			$db      = \Config\Database::connect();
        $builder = $db->table('membresia_x_sector');
        $builder->select('membresia_x_sector.id , hcv_cat_membresia.name,hcv_cat_sector.description,membresia_x_sector.precio');
        $builder->join('hcv_cat_sector', 'hcv_cat_sector.id=membresia_x_sector.id_hcv_cat_sector');
        $builder->join('hcv_cat_membresia', 'hcv_cat_membresia.id=membresia_x_sector.id_hcv_cat_membresia');
        $builder->where('membresia_x_sector.id_hcv_cat_sector',$id_sector);
        $builder->where('membresia_x_sector.id_hcv_cat_membresia',$id_membresia);
        $data = $builder->get()->getResultArray();
        return $data;
		}

	

	}