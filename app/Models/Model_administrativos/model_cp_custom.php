<?php namespace App\Models;
	
	use CodeIgniter\Model;

	class model_cp_custom extends Model {
        protected $table="hcv_cat_cp_custom";
		protected $primaryKey="ID";
		protected $returnType="array";
		protected $useSoftDeletes=false;
		protected $allowedFields=['id_hcv_cat_cp','id_hcv_cat_sector'];
		protected $useTimestamps=false;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;

        public function get_membresia($id_codigo){
            return $this->asArray()
            ->select('hcv_cat_cp_custom.*,hcv_cat_sector.name,hcv_cat_membresia.name,hcv_cat_membresia.id as id_membresia')
            ->join('hcv_cat_sector', 'hcv_cat_sector.id = hcv_cat_cp_custom.id_hcv_cat_sector')
           /*  ->join('hcv_cat_cp', 'hcv_cat_cp.'.$id_codigo.' = hcv_cat_cp_custom.id_hcv_cat_cp') */
           // ->join('hcv_cat_sector', 'hcv_cat_sector.id = hcv_cat_cp_custom.id_hcv_cat_sector')
            ->join('membresia_x_sector', 'membresia_x_sector.id_hcv_cat_sector = hcv_cat_cp_custom.id_hcv_cat_sector')
            ->join('hcv_cat_membresia', 'hcv_cat_membresia.id = membresia_x_sector.id_hcv_cat_membresia')
            ->where('hcv_cat_cp_custom.id_hcv_cat_cp',$id_codigo)
            ->findAll();

            
        }

        public function get_membresia2($id_codigo){
            return $this->asArray()
            ->select('hcv_cat_cp_custom.*,hcv_cat_sector.name as sector,hcv_cat_membresia.name,hcv_cat_membresia.id as id_membresia')
            ->join('hcv_cat_sector', 'hcv_cat_sector.id = hcv_cat_cp_custom.id_hcv_cat_sector')
           /*  ->join('hcv_cat_cp', 'hcv_cat_cp.'.$id_codigo.' = hcv_cat_cp_custom.id_hcv_cat_cp') */
           // ->join('hcv_cat_sector', 'hcv_cat_sector.id = hcv_cat_cp_custom.id_hcv_cat_sector')
            ->join('membresia_x_sector', 'membresia_x_sector.id_hcv_cat_sector = hcv_cat_cp_custom.id_hcv_cat_sector')
            ->join('hcv_cat_membresia', 'hcv_cat_membresia.id = membresia_x_sector.id_hcv_cat_membresia')
            ->where('hcv_cat_cp_custom.id_hcv_cat_cp',$id_codigo)
            ->findAll();

            
        }

        

        
    }