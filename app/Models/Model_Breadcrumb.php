<?php 
    namespace App\Models;
	use CodeIgniter\Model;
	class Model_Breadcrumb extends Model {

        public function obtener_parent($name){
            $db = \Config\Database::connect();
            $builder = $db->table('modules');
            $builder->select('parent,controller');
            $query = $builder->getWhere(['controller'=>$name]);
            return $query->getResult();

        }

		
	}

?>    