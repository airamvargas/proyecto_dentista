<?php namespace App\Models;

	use CodeIgniter\Model;

	class Model_moneda extends Model {

		protected $table="cat_currency";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=false;
		protected $allowedFields=['name'];
		protected $useTimestamps=false;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;

        public function get_moneda(){
            return $this->asArray()->findall();
        }
    }

    