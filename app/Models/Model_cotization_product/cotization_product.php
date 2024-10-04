<?php namespace App\Models\Model_cotization_product;

/* Desarrollador: Airam V. Vargas
Fecha de creacion: 
Fecha de Ultima Actualizacion: 27 de febrero de 2024
Desarrollardor actualizo: Airam V. Vargas
Perfil: Recepcionista
Descripcion: Sa agregaron las consultas para la busquedda  */

	use CodeIgniter\Model;

	class cotization_product extends Model {
        
        protected $table="cotization_x_products";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes = true;
		protected $allowedFields=['id','id_cat_products','id_cotization','cantidad', 'price', 'status_lab', 'status_name', 'created_at', 'updated_at', 'deleted_at'];
		protected $useTimestamps = true;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;
    
    	
        //OBTIENE TODOS LOS PRODUCTOS DE UNA SOLA COTIZACION 
        public function readCotizations($id){
            $sql = "SELECT cotization_x_products.id, insumos.name, insumos.id_product, insumos.cita, name_table, cotization_x_products.cantidad, cotization_x_products.price, 
            cotization_x_products.status_lab AS status_consulta, (SELECT description FROM cat_products WHERE insumos.name_table LIKE '%cat_products%' AND cat_products.id = 
            insumos.id_product) AS product_des, (SELECT preparation FROM cat_studies WHERE insumos.name_table LIKE '%cat_studies%' AND cat_studies.id = insumos.id_product) 
            AS study_des, (SELECT preparation FROM cat_packets WHERE insumos.name_table LIKE '%cat_packets%' AND cat_packets.id = insumos.id_product) AS packet_des, (SELECT 
            citas.status_lab FROM citas WHERE citas.id_cotization_x_product = cotization_x_products.id LIMIT 1) AS status_lab, (SELECT approved FROM appointment_schedule 
            WHERE id_cotizacion = :id:) AS consulta_status FROM cotization_x_products JOIN insumos ON insumos.id = cotization_x_products.id_cat_products WHERE id_cotization 
            = :id: AND cotization_x_products.deleted_at = '0000-00-00 00:00:00'";
            $datos = $this->db->query($sql, ['id' => $id]);
            return $datos->getResult();
        }

        //ELIMINAR TODOS LOS PRODUCTOS
        public function delete_all($id_cotization){
            $db = \Config\Database::connect();
            $builder = $db->table('cotization_x_products');
            $builder->where("id_cotization", $id_cotization);
            $builder->delete();
            $query = $builder->get();
            return $query->getResult();
        }

        public function get_total($id){
            $sql = 'SELECT SUM(price) AS total FROM cotization_x_products WHERE id_cotization = :id: AND deleted_at = "0000-00-00 00:00:00"';
            $datos = $this->db->query($sql, ['id' => $id]);
            return $datos->getResult();
        }

        public function get_cotizations($id){
            $sql = 'SELECT COUNT(*) AS total FROM cotization_x_products WHERE id_cotization = :id: AND deleted_at = "0000-00-00 00:00:00"';
            $datos = $this->db->query($sql, ['id' => $id]);
            return $datos->getResult();
        }

        public function showPendientes($id_cat_bussienes){
            $sql = "SELECT cotization.id, c_date, id_user_client, (SELECT name FROM cat_conventions WHERE cat_conventions.id = cotization.id_conventions) AS convenio, 
            (SELECT user_name FROM users WHERE users.id = cotization.id_user_client AND deleted_at = '0000-00-00 00:00:00') AS cliente, (SELECT COUNT(*) 
            FROM cotization_x_products WHERE status_lab in('200', '201', '202') AND cotization_x_products.id_cotization = cotization.id AND deleted_at = '0000-00-00 00:00:00')
            AS consultas_medicas, (SELECT COUNT(*) FROM cotization_x_products WHERE cotization_x_products.id_cotization = cotization.id AND deleted_at = 
            '0000-00-00 00:00:00' AND status_lab in('100', '106')) AS laboratorio FROM cotization WHERE deleted_at = '0000-00-00 00:00:00' AND 
            show_cotization = :show_cot: AND id_business_unit = :unit: HAVING consultas_medicas != 0 OR laboratorio != 0";
            $datos = $this->db->query($sql, ['show_cot' => 1, 'unit' => $id_cat_bussienes]);
            return $datos->getResult();
        }

        public function showPendientesCall(){
            $sql = "SELECT cotization.id, c_date, id_user_client, (SELECT name FROM cat_conventions WHERE cat_conventions.id = cotization.id_conventions) AS convenio, 
            (SELECT user_name FROM users WHERE users.id = cotization.id_user_client AND deleted_at = '0000-00-00 00:00:00') AS cliente, (SELECT COUNT(*) 
            FROM cotization_x_products WHERE status_lab in('200', '201', '202') AND cotization_x_products.id_cotization = cotization.id AND deleted_at = '0000-00-00 00:00:00')
            AS consultas_medicas, (SELECT COUNT(*) FROM cotization_x_products WHERE cotization_x_products.id_cotization = cotization.id AND deleted_at = 
            '0000-00-00 00:00:00' AND status_lab in('100', '106')) AS laboratorio FROM cotization WHERE deleted_at = '0000-00-00 00:00:00' AND 
            show_cotization = :show_cot: HAVING consultas_medicas != 0 OR laboratorio != 0";
            $datos = $this->db->query($sql, ['show_cot' => 1]);
            return $datos->getResult();
        }

        public function showLab($id){
            $sql = "SELECT cotization_x_products.id, status_lab, (SELECT user_name FROM users WHERE id_user_client = users.id) AS paciente, (SELECT name FROM insumos WHERE insumos.id = cotization_x_products.id_cat_products) AS insumo FROM 
            cotization_x_products JOIN cotization ON cotization.id = cotization_x_products.id_cotization WHERE id_cotization = :id: AND cotization_x_products.deleted_at = '0000-00-00 00:00:00' AND status_lab in('100', '106')";
            $datos = $this->db->query($sql, ['id' => $id]);
            return $datos->getResult();
        }

        public function showCitas($id){
            $sql = "SELECT cotization_x_products.id, status_lab, (SELECT user_name FROM users WHERE id_user_client = users.id) AS paciente, (SELECT name 
            FROM status_laboratory WHERE status_laboratory.id = status_lab) status_name, (SELECT name FROM insumos WHERE insumos.id = cotization_x_products.id_cat_products) 
            AS insumo FROM cotization_x_products JOIN cotization ON cotization.id = cotization_x_products.id_cotization WHERE id_cotization = :id: AND status_lab >= :status_lab: 
            AND cotization_x_products.deleted_at = '0000-00-00 00:00:00'";
            $datos = $this->db->query($sql, ['id' => $id, 'status_lab' => 200]);
            return $datos->getResult();
        }

        //Consulta que trae los datos de las muestras de laboratorio pendientes de atender
        public function showMuestras($id_cat_bussienes, $areas){
            $sql = "SELECT cotization_x_products.id, id_user_client, cotization_x_products.updated_at, (SELECT user_name FROM users WHERE users.id = 
            cotization.id_user_client) AS paciente, insumos.name AS estudio, (SELECT COUNT(*) FROM citas WHERE status_lab != :status_aut: AND status_lab != :status_acep: AND status_lab != :status_fin: AND 
            cotization_x_products.id = citas.id_cotization_x_product AND citas.deleted_at IS NULL) AS restan, (SELECT id_category_lab FROM citas JOIN 
            insumos ON insumos.id = citas.id_study JOIN cat_studies ON insumos.id_product = cat_studies.id WHERE id_cotization_x_product = 
            cotization_x_products.id AND citas.status_lab != :status_aut: AND citas.deleted_at IS NULL LIMIT 1) AS id_category_lab, (SELECT 
            category_lab.name FROM citas JOIN insumos ON insumos.id = citas.id_study JOIN cat_studies ON insumos.id_product = cat_studies.id JOIN 
            category_lab ON category_lab.id = cat_studies.id_category_lab WHERE id_cotization_x_product = cotization_x_products.id AND citas.status_lab 
            != :status_aut: AND citas.deleted_at IS NULL LIMIT 1) AS category_lab  FROM cotization_x_products JOIN cotization ON 
            cotization_x_products.id_cotization = cotization.id JOIN insumos ON insumos.id = cotization_x_products.id_cat_products WHERE show_cotization = 1
            AND status_lab = 101 AND cotization_x_products.deleted_at IS NULL AND id_business_unit = :unit:  HAVING restan != 0 AND 
            id_category_lab in($areas) ORDER BY cotization_x_products.updated_at ASC";
            $datos = $this->db->query($sql, ['status_aut' => 102, 'status_acep' => 107, 'status_fin' => 108, 'unit' => $id_cat_bussienes]);
            return $datos->getResult();
        }

        public function showRechazadas($id_cat_bussienes){
            $sql = "SELECT appointment_schedule.id, id_cita, fecha, hora, id_user_client AS id_paciente, approved, id_cita, id_doctor, appointment_schedule.id_cotizacion, 
            (SELECT id FROM cotization_x_products WHERE cotization_x_products.id_cat_products = appointment_schedule.id_insumo AND appointment_schedule.id_cotizacion = 
            cotization_x_products.id_cotization AND cotization_x_products.deleted_at = '0000-00-00 00:00:00') AS id_cotization_x_product, (SELECT name FROM consulting_room WHERE 
            consulting_room.id = id_consultorio) AS consultorio, (SELECT user_name FROM users WHERE users.id = cotization.id_user_client) AS paciente, (SELECT hcv_identity.PHONE_NUMBER 
            FROM hcv_identity WHERE hcv_identity.ID_USER = id_user_client) AS telefono, (SELECT user_name FROM users WHERE users.id = id_doctor) AS medico, (SELECT status_lab FROM 
            cotization_x_products WHERE cotization_x_products.id_cat_products = appointment_schedule.id_insumo AND appointment_schedule.id_cotizacion = cotization_x_products.id_cotization
            AND cotization_x_products.deleted_at = '0000-00-00 00:00:00') AS status_lab, (SELECT name FROM cotization_x_products JOIN status_laboratory ON cotization_x_products.status_lab = 
            status_laboratory.id WHERE cotization_x_products.status_lab = status_laboratory.id AND cotization_x_products.id_cat_products = appointment_schedule.id_insumo AND 
            appointment_schedule.id_cotizacion = cotization_x_products.id_cotization AND cotization_x_products.deleted_at = '0000-00-00 00:00:00') AS 
            status_name FROM appointment_schedule JOIN cotization ON cotization.id = appointment_schedule.id_cotizacion WHERE approved = :approved: AND 
            id_business_unit = :unit:";
            $datos = $this->db->query($sql, ['approved' => 2, 'unit' => $id_cat_bussienes]);
            return $datos->getResult();
        }

        public function showRechazadasCall() {
            $sql = "SELECT appointment_schedule.id, id_cita, fecha, hora, id_user_client AS id_paciente, approved, id_cita, id_doctor, appointment_schedule.id_cotizacion, (SELECT id FROM cotization_x_products WHERE 
            cotization_x_products.id_cat_products = appointment_schedule.id_insumo AND appointment_schedule.id_cotizacion = cotization_x_products.id_cotization
            AND cotization_x_products.deleted_at = '0000-00-00 00:00:00') AS id_cotization_x_product, (SELECT name FROM consulting_room WHERE 
            consulting_room.id = id_consultorio) AS consultorio, (SELECT user_name FROM users WHERE users.id = cotization.id_user_client) AS paciente, (SELECT user_name 
            FROM users WHERE users.id = id_doctor) AS medico, (SELECT status_lab FROM cotization_x_products WHERE cotization_x_products.id_cat_products = 
            appointment_schedule.id_insumo AND appointment_schedule.id_cotizacion = cotization_x_products.id_cotization  AND cotization_x_products.deleted_at = 
            '0000-00-00 00:00:00') AS status_lab, (SELECT name FROM cotization_x_products JOIN status_laboratory ON cotization_x_products.status_lab = 
            status_laboratory.id WHERE cotization_x_products.status_lab = status_laboratory.id AND cotization_x_products.id_cat_products = appointment_schedule.id_insumo AND 
            appointment_schedule.id_cotizacion = cotization_x_products.id_cotization AND cotization_x_products.deleted_at = '0000-00-00 00:00:00') AS status_name FROM 
            appointment_schedule JOIN cotization ON cotization.id = appointment_schedule.id_cotizacion WHERE approved = :approved:";
            $datos = $this->db->query($sql, ['approved' => 2]);
            return $datos->getResult();
        }

        public function getMuestra($id_user){
            return $this->asArray()
            ->select('insumos.name,insumos.id_product,cotization.id_user_client, citas.id AS id_cita, citas.imprimir,
            CONCAT(hcv_identity.NAME," ",hcv_identity.F_LAST_NAME , " ", hcv_identity.S_LAST_NAME) AS paciente,
            citas.status_lab,citas.id_cotization_x_product,citas.id_doctor, citas.id_study,cat_studies.id_container,
            cat_studies.n_labels,containers.name as contenedor,cat_studies.preparation, CONCAT(hcv_identity_operativo.NAME," "
            ,hcv_identity_operativo.F_LAST_NAME , " ", hcv_identity_operativo.S_LAST_NAME) AS medico')
            ->join('cotization','cotization.id = cotization_x_products.id_cotization','left')
            ->join('hcv_identity','hcv_identity.ID_USER = cotization.id_user_client','left')
            ->join('citas','citas.id_cotization_x_product = cotization_x_products.id','left')
            ->join('insumos','insumos.id = citas.id_study','left')
            ->join('cat_studies','cat_studies.id = insumos.id_product','left')
            ->join('hcv_identity_operativo','hcv_identity_operativo.user_id = citas.id_doctor','left')
            ->join('containers','containers.id = cat_studies.id_container','left')
            ->where('citas.status_lab', 107)
            ->where('citas.id_doctor',$id_user)
            ->findAll();
        }

        public function totalxDia(){
            $query = "SELECT SUM(cotization_x_products.price) as total_dia, COUNT(cotization.id) AS total_pacientes, (SELECT COUNT(id) FROM citas WHERE 
            id_cotization_x_product = cotization_x_products.id AND date(created_at)=CURDATE() AND status_lab in('102','103', '104', '105','107',
            '108', '109', '110')) AS total_pruebas FROM cotization_x_products JOIN cotization ON cotization.id=cotization_x_products.id_cotization 
            WHERE DATE(cotization.c_date) = CURDATE() AND  cotization.show_cotization = 1  AND cotization_x_products.deleted_at IS NULL";
            $result = $this->db->query($query);
            return $result->getResult();
        }

        public function VentasXweek(){
            $query = $this->db->query("SELECT SUM(cotization_x_products.price) as total_semana, (SELECT COUNT(id) as total FROM citas WHERE DATE(created_at) BETWEEN 
            DATE(date_add(NOW(), INTERVAL -7 DAY)) AND DATE(NOW()) AND status_lab in('102','103', '104', '105','107',
            '108', '109', '110')) AS total_pruebas, (SELECT COUNT(cotization.id) WHERE cotization.show_cotization = 1 and cotization.c_date 
            BETWEEN date(date_add(NOW(), INTERVAL -7 DAY)) AND date(NOW()))  AS total_pacientes  FROM cotization_x_products JOIN cotization ON 
            cotization.id = cotization_x_products.id_cotization WHERE cotization.show_cotization = 1 and cotization.c_date BETWEEN date
            (date_add(NOW(), INTERVAL -7 DAY)) AND date(NOW())  AND cotization_x_products.deleted_at IS NULL");
            return $query->getResult();	
        }

        public function VentasMonth() {
            $query = $this->db->query("SELECT SUM(cotization_x_products.price) AS total_mes, (SELECT COUNT(cotization.id) FROM cotization WHERE show_cotization = 1 AND 
            DATE_FORMAT(cotization.c_date, '%m') = DATE_FORMAT(NOW( ), '%m')) AS total_pacientes, (SELECT COUNT(citas.id) FROM citas  WHERE 
            DATE_FORMAT(created_at , '%m')=DATE_FORMAT(NOW( ), '¿%m') AND status_lab in('102','103', '104', '105','107', '108', '109', '110')) AS
            total_pruebas FROM cotization_x_products JOIN cotization ON cotization.id = cotization_x_products.id_cotization WHERE 
            cotization.show_cotization = 1 AND DATE_FORMAT(cotization.c_date, '%m') = DATE_FORMAT(NOW( ), '%m')  AND 
            cotization_x_products.deleted_at IS NULL");
            return $query->getResult();	
        }

        public function getventasYear(){
            $query = $this->db->query("SELECT SUM(cotization_x_products.price) as total_anual, (SELECT COUNT(cotization.id) FROM cotization WHERE deleted_at IS NULL AND 
            show_cotization = 1 AND DATE_FORMAT(cotization.c_date, '%Y') = DATE_FORMAT(NOW( ), '%Y')) AS pacientes_anual, (SELECT COUNT(citas.id)
            FROM citas  WHERE DATE_FORMAT(created_at , '%Y')=DATE_FORMAT(NOW( ), '%Y') and status_lab in('102','103', '104', '105','107', '108', 
            '109', '110')) AS pruebas_anual FROM cotization_x_products JOIN cotization ON cotization.id = cotization_x_products.id_cotization WHERE 
            cotization.show_cotization = 1 AND DATE_FORMAT(cotization.c_date, '%Y') = DATE_FORMAT(NOW( ), '%Y') AND 
            cotization_x_products.deleted_at IS NULL;");
            return $query->getResult();	
        }

        public function graficaPastelProductos($fecha_inicio, $fecha_final) {
            $query = $this->db->query("
                SELECT DISTINCT 
                    cotization_x_products.id_cat_products AS id_union, 
                    (SELECT COUNT(cotization_x_products.id_cat_products) 
                     FROM cotization_x_products 
                     WHERE cotization_x_products.id_cat_products = insumos.id) AS total_productos, 
                    insumos.name AS producto, 
                    (SELECT SUM(cotization_x_products.price) 
                     FROM cotization_x_products 
                     WHERE cotization_x_products.id_cat_products = insumos.id) AS total_precio 
                FROM 
                    cotization 
                JOIN 
                    cotization_x_products ON cotization_x_products.id_cotization = cotization.id 
                JOIN 
                    insumos ON insumos.id = cotization_x_products.id_cat_products 
                WHERE 
                    cotization.show_cotization = 1 
                    AND cotization_x_products.id_cat_products = insumos.id 
                    AND insumos.id_category = 1 
                    AND cotization_x_products.deleted_at IS NULL 
                    AND cotization.deleted_at IS NULL 
                    AND cotization.c_date BETWEEN ? AND ? 
                ORDER BY 
                    total_productos DESC 
                LIMIT 5", array($fecha_inicio, $fecha_final));
            
            return $query->getResult();    
        }
        

        public function graficaPastelConvenios($fecha_inicio, $fecha_final) {
            $query = $this->db->query("
                SELECT 
                    cotization.id_conventions AS id_union, 
                    SUM(cotization_x_products.price) AS total_precio, 
                    cat_conventions.name AS producto 
                FROM 
                    cotization 
                JOIN 
                    cotization_x_products ON cotization_x_products.id_cotization = cotization.id 
                JOIN 
                    cat_conventions ON cat_conventions.id = cotization.id_conventions 
                WHERE 
                    cotization.show_cotization = 1 
                    AND cotization_x_products.deleted_at IS NULL 
                    AND cotization.deleted_at IS NULL 
                    AND cotization.c_date BETWEEN ? AND ? 
                GROUP BY 
                    cotization.id_conventions 
                ORDER BY 
                    total_precio DESC", 
                    array($fecha_inicio, $fecha_final));
            
            return $query->getResult();
        }
        
            

        public function graficaPastelUnidades($fecha_inicio, $fecha_final)
        {
            $db = \Config\Database::connect();
            $sql = "SELECT 
                        cotization.id_business_unit AS id_union, 
                        SUM(cotization_x_products.price) AS total_precio, 
                        cat_business_unit.name AS producto 
                    FROM 
                        cotization 
                    JOIN 
                        cotization_x_products ON cotization_x_products.id_cotization = cotization.id 
                    JOIN 
                        cat_business_unit ON cat_business_unit.id = cotization.id_business_unit 
                    WHERE 
                        cotization.show_cotization = 1 
                        AND cotization_x_products.deleted_at IS NULL 
                        AND cotization.deleted_at IS NULL 
                        AND cotization.c_date BETWEEN ? AND ? 
                    GROUP BY 
                        cotization.id_business_unit 
                    ORDER BY 
                        total_precio DESC";
    
            $query = $db->query($sql, [$fecha_inicio, $fecha_final]);
            return $query->getResult();
        }

    }