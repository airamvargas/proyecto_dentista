<?php namespace App\Models\Model_cat_files;
	
	use CodeIgniter\Model;

	class Cat_files extends Model {
        
        protected $table="cat_files";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=false;
		protected $allowedFields=['name_file','type_id','business_id'];
		protected $useTimestamps=false;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;
    
    	 
    }

