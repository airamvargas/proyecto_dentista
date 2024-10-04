<?php namespace App\Models;
	
	use CodeIgniter\Model;

	class Model_administrativo_visitas extends Model {
        protected $table="hcv_quotes";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=false;
		protected $allowedFields=['date_time','patient_id','doctor_id','observation','type','observation','status','cost','link','id_tipo_cita','is_paid_by_patient','is_paid_to_doctor'];
		protected $useTimestamps=false;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;

        public function visitas(int $limit,$offset) {
            $query = " SELECT hcv_quotes.`id`, hcv_quotes.`id_tipo_cita` AS id_tipo_consulta, `date_time`, `patient_id`, `doctor_id`, hcv_quotes.`type`, `observation`, `status`, `is_paid_by_patient`, `is_paid_to_doctor` , cost ,  CONCAT(`NAME` ,' ', `F_LAST_NAME` ,' ', `S_LAST_NAME`) AS full_name , 
            (SELECT CONCAT(`NAME` ,' ', `F_LAST_NAME` ,' ', `S_LAST_NAME`) AS operativo_full_name FROM hcv_identity_operativo WHERE hcv_quotes.doctor_id = hcv_identity_operativo.ID_USER limit 1) as operativo_full_name,
             (SELECT hcv_cat_medical_type.tipo_cita  from hcv_cat_medical_type where hcv_cat_medical_type.id = id_tipo_consulta) AS tipo_cita
            FROM hcv_quotes , hcv_identity WHERE hcv_quotes.patient_id = hcv_identity.ID_USER limit $limit offset $offset";
                $query_result = $this->db->query($query);
			    return $query_result->getResult();	 
        }

        public function total_visitas(){
            $query = "SELECT hcv_quotes.`id`, hcv_quotes.`id_tipo_cita` AS id_tipo_consulta, `date_time`, `patient_id`, `doctor_id`, hcv_quotes.`type`, `observation`, `status`, `is_paid_by_patient`, `is_paid_to_doctor` , cost ,  CONCAT(`NAME` ,' ', `F_LAST_NAME` ,' ', `S_LAST_NAME`) AS full_name , 
            (SELECT CONCAT(`NAME` ,' ', `F_LAST_NAME` ,' ', `S_LAST_NAME`) AS operativo_full_name FROM hcv_identity_operativo WHERE hcv_quotes.doctor_id = hcv_identity_operativo.ID_USER limit 1) as operativo_full_name,
             (SELECT hcv_cat_medical_type.tipo_cita  from hcv_cat_medical_type where hcv_cat_medical_type.id = id_tipo_consulta) AS tipo_cita
            FROM hcv_quotes , hcv_identity WHERE hcv_quotes.patient_id = hcv_identity.ID_USER";
                $query_result = $this->db->query($query);
			    return $query_result->getResult();	 
        }


        public function get_id($id){
            $Nombres = $this->db->query("SELECT DATE_FORMAT(date_time, '%Y-%m-%d') DATEONLY,
       DATE_FORMAT(date_time,'%H:%i:%s') TIMEONLY ,ID from hcv_quotes WHERE id='".$id."'");
            return $Nombres->getResult();
        }


        public function visita_update($data1,$id_user){
            $data = $this->db->table('hcv_quotes');
            $data->where('id', $id_user);
            $data->update($data1);
        }


        public function list_operativo(){
            $data = $this->db->table('users');
            $data->where('id_group', 2);
            return $data;
        }


        public function cita_update($data1,$id){
            $data = $this->db->table('hcv_quotes');
            $data->where('id', $id);
            $data->update($data1);
        }


        public function visitas2(int $limit,$offset) {
            $query = "SELECT hcv_quotes.*, hcv_identity.NAME as n_paciente ,hcv_identity.F_LAST_NAME as ap_p,hcv_identity_operativo.NAME as n_op,hcv_identity_operativo.F_LAST_NAME as ap_op,
            hcv_cat_medical_type.tipo_cita ,appointment_status.name as cita_status  FROM hcv_quotes
            left JOIN hcv_identity ON hcv_identity.ID_USER  = hcv_quotes.patient_id 
            left JOIN hcv_identity_operativo ON hcv_identity_operativo.ID_USER  = hcv_quotes.doctor_id 
            left JOIN hcv_cat_medical_type ON hcv_cat_medical_type.id  = hcv_quotes.id_tipo_cita 
            left JOIN appointment_status ON appointment_status.id  = hcv_quotes.status ORDER by hcv_quotes.id DESC
             limit $limit offset $offset";
                $query_result = $this->db->query($query);
			    return $query_result->getResult();	 
        }

        public function search_table($search_value,$limit,$offset){
            $query = "SELECT hcv_quotes.*, hcv_identity.NAME as n_paciente ,hcv_identity.F_LAST_NAME as ap_p,hcv_identity_operativo.NAME as n_op,hcv_identity_operativo.F_LAST_NAME as ap_op,
            hcv_cat_medical_type.tipo_cita ,appointment_status.name as cita_status  FROM hcv_quotes
            left JOIN hcv_identity ON hcv_identity.ID_USER  = hcv_quotes.patient_id 
            left JOIN hcv_identity_operativo ON hcv_identity_operativo.ID_USER  = hcv_quotes.doctor_id 
            left JOIN hcv_cat_medical_type ON hcv_cat_medical_type.id  = hcv_quotes.id_tipo_cita 
            left JOIN appointment_status ON appointment_status.id  = hcv_quotes.status 
            where hcv_identity.NAME like '%".$search_value."%' or hcv_quotes.date_time  like '%".$search_value."%' or hcv_quotes.id like '%".$search_value."%'   or hcv_identity.F_LAST_NAME like '%".$search_value."%'
            or hcv_cat_medical_type.tipo_cita like '%".$search_value."%' or hcv_identity_operativo.NAME like '%".$search_value."%' or hcv_identity_operativo.F_LAST_NAME like '%".$search_value."%' 
            or appointment_status.name like '%".$search_value."%' ORDER by hcv_quotes.id ASC limit $limit  offset $offset";
                $query_result = $this->db->query($query);
			    return $query_result->getResult();	 

        }

        public function count_search($search_value){
            $query = "SELECT hcv_quotes.*, hcv_identity.NAME as n_paciente ,hcv_identity.F_LAST_NAME as ap_p,hcv_identity_operativo.NAME as n_op,hcv_identity_operativo.F_LAST_NAME as ap_op,
            hcv_cat_medical_type.tipo_cita ,appointment_status.name as cita_status  FROM hcv_quotes
            left JOIN hcv_identity ON hcv_identity.ID_USER  = hcv_quotes.patient_id 
            left JOIN hcv_identity_operativo ON hcv_identity_operativo.ID_USER  = hcv_quotes.doctor_id 
            left JOIN hcv_cat_medical_type ON hcv_cat_medical_type.id  = hcv_quotes.id_tipo_cita 
            left JOIN appointment_status ON appointment_status.id  = hcv_quotes.status 
            where hcv_identity.NAME like '%".$search_value."%' or hcv_quotes.date_time  like '%".$search_value."%' or hcv_quotes.id like '%".$search_value."%'   or hcv_identity.F_LAST_NAME like '%".$search_value."%'
            or hcv_cat_medical_type.tipo_cita like '%".$search_value."%' or hcv_identity_operativo.NAME like '%".$search_value."%' or hcv_identity_operativo.F_LAST_NAME like '%".$search_value."%' 
            or appointment_status.name like '%".$search_value."%'"; //limit $limit  offset $offset";
                $query_result = $this->db->query($query);
			    return $query_result->getResult();	 

        }

        public function prueba($query){
            return $this->db->query($query)->getResult();
        }

        public function updateCitas($id_doctor,$id_paciente){

            var_dump($id_doctor);
            var_dump($id_paciente);
           // return $this->asArray()->where('doctor_id',$id_doctor)->where('patient_id',$id_paciente)->find();
         $db      = \Config\Database::connect();
            $builder = $db->table('hcv_quotes');
            $builder->set('status', 1, false);
            $builder->where('doctor_id', $id_doctor);
            $builder->where('status', 3);
            $builder->update(); 
        }

        public function getHours($fecha,$id_doctor){
            $query = "SELECT DATE_FORMAT(date_time, '%H:%i:%s') as horasOcupadas 
            FROM hcv_quotes  WHERE date_time like '%".$fecha."%' AND  doctor_id = '".$id_doctor."'";
			$query_result = $this->db->query($query);
            return $query_result->getResult();	 
        }
        
 
    }