<?php namespace App\Models\Model_user;

	use CodeIgniter\Model;

	class Table_user extends Model {

		protected $table="users";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes = true;
		protected $allowedFields=['id', 'id_group','c_date','user_name', 'email','password', 'activation_token', 'about', 'photo', 'telefono', 'created_at','updated_at','deleted_at','active', 'business_id'];
		protected $useTimestamps = true;
		protected $createdField  = 'created_at';
		protected $updatedField  = 'updated_at';
		protected $deletedField  = 'deleted_at';
		protected $validationRules    = [];
		protected $validationMessages = [];
		protected $skipValidation     = false;


		public function findCount($email){
			$db=\Config\Database::connect();
            $builder = $db->table('users');
           $builder->select('count(*)');
           $builder->where('email',$email);
           $query3 = $builder->countAllResults();
           return $query3;
		}

		public function get_table_usuarios(){
			return $this->asArray()
            ->select('users.id, users.photo, users.user_name, users.email, users.about')
            ->findAll();
		}

		public function get_id(){
			return $this->asArray()
            ->select('users.id')
            ->findAll();
		}

		public function get_phone($id_vendor){
			return $this->asArray()
            ->select('users.telefono,users.email, user_name, business.logo,groups.name')
			->join('business', 'business.id = users.business_id')
			->join('groups','groups.id = users.id_group')
			->where('users.id', $id_vendor)
            ->findAll();
		}

		public function borra($id){
			$db=\Config\Database::connect();
			$data = $this->db->table('users');
			$data->where('id', $id);
			$data->delete();
		}

		public function get_users(){
			return $this->asArray()
            ->select('users.id, users.user_name')
			->where('id_group >', 2)
			->where('id_group <', 11)
            ->findAll();
		}

		public function get_datos($id_user) {
			return $this->asArray()
			->select('c_date, email, business_id')
			->where('id', $id_user)
			->findAll();
		}

	}