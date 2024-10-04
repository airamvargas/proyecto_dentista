<?php namespace App\Models;
	
	use CodeIgniter\Model;

	class Model_administrativo_operativo extends Model {
        protected $table="users";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=false;
		protected $allowedFields=['id', 'id_group', 'c_date', 'user_name', 'email', 'password', 'activation_token', 'about', 'profile_image', 'created_at', 'updated_at', 'deleted_at', 'active'];
		protected $useTimestamps=false;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;

        public function findAll(int $limit = 0, int $offset = 0) {
            if($limit > 0){
                $query = "SELECT id, id_group, c_date, user_name, email, about, profile_image, created_at, updated_at, deleted_at, active FROM users LIMIT $limit OFFSET $offset";
            }else{
                $query = "SELECT users.id, id_group, c_date, user_name, email, about, profile_image, created_at, updated_at, deleted_at, active , CONCAT(`NAME` ,' ', `F_LAST_NAME` ,' ', `S_LAST_NAME`) AS full_name , DISCIPLINE ,
                (SELECT COUNT(*) AS servicios_relaizados FROM hcv_quotes WHERE doctor_id = users.id) as servicios_relaizados,
                (SELECT COUNT(*) AS notas_pendientes FROM hcv_quotes WHERE doctor_id = users.id and status = 3) as notas_pendientes,
                (SELECT COUNT(*) AS visitas_pagar FROM hcv_quotes WHERE doctor_id = users.id and is_paid_to_doctor = 0) as visitas_pagar
                FROM users , hcv_identity_operativo WHERE users.id = hcv_identity_operativo.ID_USER";
            }
            $query_result = $this->db->query($query);
			return $query_result->getResult();	
        }

        public function findOne($id) {
            $query = "SELECT users.id, id_group, c_date, user_name, email, about, profile_image, created_at, updated_at, deleted_at, active , CONCAT(`NAME` ,' ', `F_LAST_NAME` ,' ', `S_LAST_NAME`) AS full_name , DISCIPLINE ,
                (SELECT COUNT(*) AS servicios_relaizados FROM hcv_quotes WHERE doctor_id = users.id) as servicios_relaizados
                FROM users , hcv_identity_operativo WHERE users.id = hcv_identity_operativo.ID_USER and users.id=$id";
            $query_result = $this->db->query($query);
			return $query_result->getResult();	
        }


        public function get_id($id){
            $Nombres = $this->db->query("SELECT * from hcv_identity_operativo WHERE id_user='".$id."'");
            return $Nombres->getResult();
        }

        public function operativo_update($data1,$id){
            $data = $this->db->table('hcv_identity_operativo');
            $data->where('ID_USER', $id);
            $data->update($data1);
        }

        public function get_cp($id){
            $data = $this->db->table('hcv_cat_cp');
            $data->select('*');
            $data->where('ID', $id);
            $query = $data->get();
            return $query->getResult();
        }
    }