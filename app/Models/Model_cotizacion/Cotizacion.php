<?php namespace App\Models\Model_cotizacion;

	use CodeIgniter\Model;

	class Cotizacion extends Model {

		protected $table="cotization";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=true;
		protected $allowedFields=['id','id_user_vendor','id_business_unit', 'name_unit', 'id_user_client','c_date', 'id_conventions', "show_cotization", "status_lab", "status_name",
        "id_company_data","name_conpany","tel_conpany","address","logo","rfc","email", "whatsapp", "medic_referido", "tel_medic", "correo", "codigo_qr", "created_at", "updated_at", "deleted_at"];
		protected $useTimestamps=true;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        public function readCotizations(){
            $sql = "SELECT cotization.id, cotization.c_date, id_user_client, id_conventions, (SELECT name FROM cat_conventions WHERE cat_conventions.id = cotization.id_conventions) 
            AS convenio, (SELECT user_name FROM users WHERE users.id = cotization.id_user_vendor) AS vendedor, (SELECT user_name 
            FROM users WHERE users.id = cotization.id_user_client AND deleted_at = '0000-00-00 00:00:00') AS cliente, (SELECT SUM(cantidad) FROM 
            cotization_x_products WHERE id_cotization = cotization.id AND deleted_at = '0000-00-00 00:00:00') AS productos, (SELECT SUM(price) FROM 
            cotization_x_products WHERE id_cotization = cotization.id AND deleted_at = '0000-00-00 00:00:00') AS total FROM cotization WHERE deleted_at 
            = '0000-00-00 00:00:00' AND show_cotization = 0 ORDER BY cotization.id DESC";
            $datos = $this->db->query($sql);
            return $datos->getResult();
        }

        public function readCotizationsUsers($user_id){
            $sql = "SELECT cotization.id, cotization.c_date, id_user_client, id_conventions, (SELECT name FROM cat_conventions WHERE cat_conventions.id = cotization.id_conventions) 
            AS convenio, (SELECT user_name FROM users WHERE users.id = cotization.id_user_vendor) AS vendedor, (SELECT user_name 
            FROM users WHERE users.id = cotization.id_user_client AND deleted_at = '0000-00-00 00:00:00') AS cliente, (SELECT SUM(cantidad) FROM 
            cotization_x_products WHERE id_cotization = cotization.id AND deleted_at = '0000-00-00 00:00:00') AS productos, (SELECT SUM(price) FROM 
            cotization_x_products WHERE id_cotization = cotization.id AND deleted_at = '0000-00-00 00:00:00') AS total FROM cotization WHERE 
            id_user_vendor = :usuario: AND show_cotization = 0 AND deleted_at = '0000-00-00 00:00:00' ORDER BY cotization.id DESC";
            $datos = $this->db->query($sql, ['usuario' => $user_id]);
            return $datos->getResult();
        }

        public function getCitas($id_cotizacion){
            return $this->asArray()
            ->select('insumos.name as producto, insumos.cita,insumos.id_category,hcv_identity_operativo.NAME,hcv_identity_operativo.F_LAST_NAME,consulting_room.name as consultorio,citas.id,citas.fecha, cat_studies.preparation, cat_products.description')
            ->join('cotization_x_products','cotization_x_products.id_cotization = cotization.id','left')
            ->join('citas','citas.id_cotization_x_product = cotization_x_products.id')
            ->join('insumos','insumos.id = citas.id_study')
            ->join('hcv_identity_operativo','hcv_identity_operativo.user_id = citas.id_doctor','left')
            ->join('consulting_room','consulting_room.id = citas.id_consultorio','left')
            ->join('cat_studies','cat_studies.id = insumos.id_product','left')
            ->join('cat_products','cat_products.id = insumos.id_product','left')
            ->where('cotization.id',$id_cotizacion)
            ->findAll();
            
        }

        public function getUunit($id_cotizacion){
            return $this->asArray()
            ->select('id_business_unit,cat_business_unit.start_time,cat_business_unit.final_hour')
            ->join('cat_business_unit','cat_business_unit.id = cotization.id_business_unit','left')
            ->where('cotization.id', $id_cotizacion)->find();
        }

        public function confirm_cotization($id, $user_id){
            $sql = "SELECT COUNT(*) AS total FROM cotization WHERE id = :id: AND id_user_vendor = :usuario: AND show_cotization = 0 AND deleted_at = '0000-00-00 00:00:00'";
            $datos = $this->db->query($sql, ['id' => $id, 'usuario' => $user_id]);
            return $datos->getResult();
        }

        public function readCliente($id_cotizacion){
            $sql = "SELECT cotization.c_date, cotization.codigo_qr, (SELECT user_name FROM users WHERE users.id = cotization.id_user_vendor) AS atendio, (SELECT user_name FROM users WHERE
            users.id = cotization.id_user_client) AS cliente, (SELECT email FROM users WHERE users.id = cotization.id_user_client) AS email_cliente, (SELECT
            PHONE_NUMBER FROM hcv_identity WHERE hcv_identity.id_user = cotization.id_user_client) AS telefono, (SELECT cat_business_unit.name FROM 
            cat_business_unit WHERE cat_business_unit.id = id_business_unit) AS unidad FROM cotization WHERE cotization.id = :id: AND cotization.deleted_at = '0000-00-00 00:00:00'";
            $datos = $this->db->query($sql, ['id' => $id_cotizacion]);
            return $datos->getResult();
        }

        public function validateCitas($id_cotizacion){
            return $this->asArray()
            ->select('insumos.name as producto, insumos.cita,insumos.id_category,hcv_identity_operativo.NAME,hcv_identity_operativo.F_LAST_NAME,consulting_room.name as consultorio,citas.id,citas.fecha,cat_studies.preparation')
            ->join('cotization_x_products','cotization_x_products.id_cotization = cotization.id','left')
            ->join('citas','citas.id_cotization_x_product = cotization_x_products.id')
            ->join('insumos','insumos.id = citas.id_study')
            ->join('hcv_identity_operativo','hcv_identity_operativo.user_id = citas.id_doctor','left')
            ->join('consulting_room','consulting_room.id = citas.id_consultorio','left')
            ->join('cat_studies','cat_studies.id = insumos.id_product','left')
            ->where('cotization.id',$id_cotizacion)
            ->where('insumos.cita',1)
            ->where('citas.fecha',null)
            ->findAll();
        }

        public function getCompany($id){
            return $this->asArray()
            ->select("name_conpany as name ,tel_conpany as tel,address,logo,rfc,email, whatsapp")
            ->where('id',$id)->findAll();
        }

        public function getDatos($id_cotizacion){
            return $this->asArray()
            ->select('cotization.id, cotization.name_unit, cotization.name_conpany, cotization.tel_conpany, cotization.address, cotization.logo, cotization.rfc, cotization.email, CONCAT(identity_employed.name, " ", identity_employed.first_name, " ",identity_employed.second_name)
            AS recepcionista, users.user_name AS paciente, codigo_qr, cotization.updated_at AS fecha')
            ->join('identity_employed','identity_employed.id_user = cotization.id_user_vendor','left')
            ->join('users','users.id = cotization.id_user_client','left')
            ->where('cotization.id',$id_cotizacion)
            ->findAll();
        }

        public function reporteProductos($sql){
            return $this->db->query($sql)->getResult();
        }

        public function showResultadosLab($unidad, $orden_servicio, $fecha, $nombre){
            $sql = "SELECT citas.id AS id_cita, cotization.id AS orden_servicio, (SELECT user_name FROM users WHERE users.id = id_user_client) AS paciente, c_date AS fecha, 
            citas.status_lab, (SELECT name FROM status_laboratory WHERE status_laboratory.id = citas.status_lab) AS status_name, (SELECT crm_results.bandera FROM crm_results 
            WHERE citas.id = crm_results.id_cita LIMIT 1) AS bandera, (SELECT crm_results.documento FROM crm_results WHERE citas.id = crm_results.id_cita LIMIT 1) AS documento 
            FROM citas LEFT JOIN cotization_x_products ON cotization_x_products.id = id_cotization_x_product LEFT JOIN cotization ON cotization.id = cotization_x_products.id_cotization
            WHERE cotization.id_business_unit = 1 AND citas.status_lab < 200 AND show_cotization = 1 AND cotization.deleted_at IS NULL AND citas.deleted_at IS NULL AND 
            cotization_x_products.deleted_at IS NULL HAVING paciente LIKE '%" .$this->db->escapeLikeString($nombre) . "%' AND fecha LIKE '%" .$this->db->escapeLikeString($fecha) . "%'
            AND orden_servicio = :orden:";
            $datos = $this->db->query($sql, ['status_lab' => 200, 'unidad' => $unidad, 'orden' => $orden_servicio]);
            return $datos->getResult();
        }
    }
