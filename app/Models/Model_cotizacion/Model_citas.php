<?php namespace App\Models\Model_cotizacion;

use CodeIgniter\Model;

class Model_citas extends Model {

	protected $table="citas";
	protected $primaryKey="id";
	protected $returnType="array";
	protected $useSoftDeletes=true;
	protected $allowedFields=['id_cotization_x_product','id_recolector','id_capturista','id_responsable', 'id_study', 'fecha', 'hora','id_doctor', 'id_user', 'id_consultorio', 'status_lab', 'status_name', 'id_business_unit', 'codigo', 'imprimir', 'created_at', 'updated_at', 'deleted_at'];
	protected $useTimestamps=true;
	protected $validationRules=[];
	protected $validationMessages=[];
	protected $skipValidation=false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


	public function getStudy($id){
		return $this->asArray()->select('id_study')->where('id',$id)->find();
	}

	public function getConsulta($id_cita){
		return $this->asArray()->select('medical_consultation_setup.id_discipline')
		->join('insumos','insumos.id = citas.id_study','left')
		->join('medical_consultation_setup','medical_consultation_setup.id_product = insumos.id_product','left')
		->where('citas.id',$id_cita)->find();
	}

	public function showStudies($id_cotization_x_prod, $areas){
		$sql = "SELECT citas.id, id_cotization_x_product, id_study, insumos.name AS estudio, (SELECT preparation FROM cat_studies WHERE cat_studies.id = 
		insumos.id_product) AS preparacion, (SELECT id_category_lab FROM cat_studies JOIN category_lab ON category_lab.id = cat_studies.id_category_lab 
		WHERE insumos.id_product = cat_studies.id) AS lab_category FROM citas JOIN insumos ON insumos.id = citas.id_study WHERE 
		id_cotization_x_product = :id: AND status_lab != :status_lab: AND status_lab != :status_acep: AND status_lab != :status_fin: HAVING lab_category in($areas)";
		$datos = $this->db->query($sql, ['id' => $id_cotization_x_prod, 'status_lab' => 102, 'status_acep' => 107, 'status_fin' => 108]);
		return $datos->getResult();
	}

	public function studiesCount($id_cotization_x_prod, $status_lab){
		$sql = "SELECT COUNT(status_lab) AS restan FROM citas WHERE id_cotization_x_product = :id: AND status_lab != :status_lab: AND deleted_at IS NULL";
		$datos = $this->db->query($sql, ['id' => $id_cotization_x_prod, 'status_lab' => $status_lab]);
		return $datos->getResult();
	}

	//data de tomar de muestras preguntas
	public function getStudies($ids){
		return $this->asArray()->select('insumos.name,insumos.id')
		->join('insumos','insumos.id = citas.id_study','left')
		->whereIn('citas.id',$ids)->find();
	}

	// OBTENER DATOS PARA LA ETIQUETA
	public function getDatosL($id_cita) {
		return $this->asArray()
            ->select(' citas.id, id_cotization_x_product, id_study, citas.id_business_unit, CONCAT(hcv_identity.NAME," ",hcv_identity.F_LAST_NAME , " ", 
			hcv_identity.S_LAST_NAME) AS paciente, BIRTHDATE, SEX, insumos.name AS estudio, containers.name AS contenedor, sample_types.name AS tipo_muestra,
			n_labels, citas.imprimir')
            ->join('cotization_x_products','cotization_x_products.id = id_cotization_x_product','left')
            ->join('cotization','cotization.id = cotization_x_products.id_cotization','left')
            ->join('hcv_identity',' hcv_identity.ID_USER = cotization.id_user_client','left')
            ->join('insumos','insumos.id = citas.id_study','left')
            ->join('cat_studies','cat_studies.id = insumos.id_product','left')
            ->join('containers','containers.id = cat_studies.id_container','left')
			->join('sample_types','sample_types.id = cat_studies.id_muestra','left')
            ->where('citas.id', $id_cita)
            ->findAll();
	}

	public function getDatosStudy($id_cita){
		return $this->asArray()
		->select('citas.status_lab,insumos.name AS producto, id_study, id_responsable, cotization.medic_referido')
		->join('insumos', 'insumos.id = citas.id_study')
		->join('cotization_x_products', 'cotization_x_products.id = citas.id_cotization_x_product')
		->join('cotization', 'cotization.id = id_cotization ')
		->where('citas.id', $id_cita)
		->find();
	}

	public function getTotalPen($user_id){
		return $this->asArray()
		->selectCount('id_study')
		->where('citas.id_doctor', $user_id)
		->where('status_lab', 107)
		->find();
	}

	//muestras del responsable sanitario 
	public function getMuestras(){
		$sql = "SELECT citas.id, id_cotization_x_product, citas.id_study, citas.id_business_unit, CONCAT(hcv_identity.NAME,'',hcv_identity.F_LAST_NAME, ' ', hcv_identity.S_LAST_NAME) AS 
		paciente, BIRTHDATE, hcv_identity.SEX, insumos.name AS estudio, containers.name AS contenedor, sample_types.name AS tipo_muestra, n_labels, citas.imprimir, cat_business_unit.name
		as unidad_negocio,citas.status_lab,citas.codigo, citas.updated_at as fecha, cotization.id_user_client as id_paciente, (SELECT crm_results.bandera FROM crm_results WHERE 
		crm_results.id_cita = citas.id AND crm_results.deleted_at IS NULL LIMIT 1) AS bandera, (SELECT crm_results.documento FROM crm_results WHERE crm_results.id_cita = citas.id AND 
		crm_results.deleted_at IS NULL LIMIT 1) AS documento FROM citas LEFT JOIN cotization_x_products ON cotization_x_products.id = id_cotization_x_product LEFT JOIN cotization ON 
		cotization.id = cotization_x_products.id_cotization LEFT JOIN hcv_identity ON hcv_identity.ID_USER = cotization.id_user_client LEFT JOIN insumos ON insumos.id = citas.id_study 
		LEFT JOIN cat_studies ON cat_studies.id = insumos.id_product LEFT JOIN containers ON containers.id = cat_studies.id_container LEFT JOIN sample_types ON sample_types.id = 
		cat_studies.id_muestra LEFT JOIN cat_business_unit ON cat_business_unit.id = citas.id_business_unit WHERE  citas.status_lab = 104 OR citas.status_lab = 109 OR citas.status_lab 
		= 110";
		$datos = $this->db->query($sql);
		return $datos->getResult();
		/*return $this->asArray()
		->select('citas.id, id_cotization_x_product, citas.id_study, citas.id_business_unit, CONCAT(hcv_identity.NAME," ",hcv_identity.F_LAST_NAME , " ", 
		hcv_identity.S_LAST_NAME) AS paciente, BIRTHDATE, hcv_identity.SEX, insumos.name AS estudio, containers.name AS contenedor, sample_types.name AS tipo_muestra,
		n_labels, citas.imprimir,cat_business_unit.name as unidad_negocio,citas.status_lab,citas.codigo, citas.updated_at as fecha, cotization.id_user_client as id_paciente, crm_results.bandera, crm_results.documento')
		->table('crm_results')->select('crm_results.bandera, crm_results.documento')->where('citas.id = crm_results.id_cita')->fromSubquery()
		->join('cotization_x_products','cotization_x_products.id = id_cotization_x_product','left')
		->join('cotization','cotization.id = cotization_x_products.id_cotization','left')
		->join('hcv_identity',' hcv_identity.ID_USER = cotization.id_user_client','left')
		->join('insumos','insumos.id = citas.id_study','left')
		->join('cat_studies','cat_studies.id = insumos.id_product','left')
		->join('containers','containers.id = cat_studies.id_container','left')
		->join('sample_types','sample_types.id = cat_studies.id_muestra','left')
		->join('cat_business_unit','cat_business_unit.id = citas.id_business_unit','left')
		->join('crm_results', 'crm_results.id_cita = citas.id', 'left')
		->where('citas.status_lab', 104)
		->orWhere('citas.status_lab', 109)
		->orWhere('citas.status_lab', 110)
		->where('crm_results.deleted_at IS NULL')
		->findAll();*/
	}

	public function showRecolectadas() {
		$sql = "SELECT citas.id, id_study, codigo, citas.updated_at AS fecha, id_user_client, (SELECT name FROM cat_business_unit WHERE cat_business_unit.id = citas.id_business_unit) 
		AS unidad, (SELECT insumos.name FROM insumos WHERE insumos.id = citas.id_study) AS estudio, (SELECT user_name FROM users WHERE users.id = 
		cotization.id_user_client) AS paciente, citas.status_lab FROM citas JOIN cotization_x_products ON cotization_x_products.id = citas.id_cotization_x_product JOIN 
		cotization ON cotization.id = cotization_x_products.id_cotization WHERE citas.deleted_at IS NULL AND citas.status_lab = :status_lab: OR citas.status_lab = 104";
		$datos = $this->db->query($sql, ['status_lab' => 109]);
		return $datos->getResult();
	}

	public function datosAnalitos($id_cita){
		return $this->asArray()
		->select('citas.id, cotization.id_user_client, BIRTHDATE, CONCAT(hcv_identity.NAME, " ", F_LAST_NAME," ", S_LAST_NAME) AS paciente, SEX, citas.id_study, 
		insumos.id_product, insumos.name AS estudio ')
		->join('insumos','insumos.id = citas.id_study','left')
		->join('cotization_x_products','cotization_x_products.id = id_cotization_x_product','left')
		->join('cotization','cotization.id = cotization_x_products.id_cotization','left')
		->join('hcv_identity',' hcv_identity.ID_USER = cotization.id_user_client','left')
		->where('citas.id', $id_cita)
		->findAll();
	}

	public function showResultados($id_cotizacion) {
		$sql = "SELECT citas.id, insumos.name AS producto, citas.updated_at AS fecha, (SELECT crm_results.bandera FROM crm_results WHERE citas.id = 
		crm_results.id_cita LIMIT 1) AS bandera, (SELECT crm_results.documento FROM crm_results WHERE citas.id = crm_results.id_cita LIMIT 1) AS 
		documento FROM citas LEFT JOIN insumos ON insumos.id = citas.id_study LEFT JOIN cotization_x_products ON cotization_x_products.id = 
		id_cotization_x_product LEFT JOIN cotization ON cotization.id = cotization_x_products.id_cotization WHERE cotization.id = :cotizacion: AND 
		citas.status_lab = :status_lab:";
		$datos = $this->db->query($sql, ['cotizacion' => $id_cotizacion, 'status_lab' => 110]);
		return $datos->getResult();
	}
	
	public function reportePacientes($sql){
		return $this->db->query($sql)->getResult();
	}

	public function productosPaciente($id_user){
		$query = 'SELECT insumos.name AS producto, citas.created_at, fecha, (SELECT user_name FROM users WHERE users.id = citas.id_doctor) AS medico, (SELECT price 
		FROM cotization_x_products WHERE citas.id_cotization_x_product = cotization_x_products.id) AS price, (SELECT status_laboratory.name FROM 
		status_laboratory WHERE status_laboratory.id = citas.status_lab) AS estatus, (SELECT approved FROM appointment_schedule WHERE citas.id = 
		appointment_schedule.id_cita) AS approved FROM citas JOIN insumos ON insumos.id = citas.id_study JOIN cotization_x_products ON 
		citas.id_cotization_x_product = cotization_x_products.id WHERE citas.id_user = :id_usuario: AND cotization_x_products.deleted_at IS NULL';
		$result = $this->db->query($query, ['id_usuario' => $id_user]);
		return $result->getResult();
	}
}