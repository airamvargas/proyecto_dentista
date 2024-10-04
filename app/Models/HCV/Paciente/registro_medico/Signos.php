<?php

namespace App\Models\HCV\Paciente\registro_medico;

use CodeIgniter\Model;

class Signos extends Model
{
	protected $table = "hcv_medical_signs";
	protected $primaryKey = "id";
	protected $returnType = "array";
	protected $useSoftDeletes = false;
	protected $allowedFields = ['id', 'FC', 'FR', 'temp', 'TA', 'TA2', 'satO2', 'mg_dl', 'peso', 'talla', 'IMC', 'patient_id','id_folio', 'operativo_id'];
	protected $useTimestamps = false;
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;


	public function get_data_user($token)
	{
		$Nombres = $this->db->query("SELECT * from users where activation_token='" . $token . "'");
		return $Nombres->getResult();
	}



	public function insert_nota($data)
	{
		$Nombres = $this->db->table('hcv_nota_general');
		$Nombres->insert($data);
	}

	public function insert_signs($data)
	{
		$Nombres = $this->db->table('medical_signs');
		$Nombres->insert($data);
	}

	public function get_signs($folio, $id){
		$Nombres = $this->db->query("SELECT * from medical_signs WHERE id_patient='" . $id . "'AND id_folio='" . $folio . "'");
		return $Nombres->getResult();
	}

	public function get_signos($folio){
		$Nombres = $this->db->query("SELECT * from medical_signs WHERE id_folio= '" . $folio . "'");
		return $Nombres->getResult();
	}

	public function update_signs($id_folio, $data)
	{
		$Nombres = $this->db->table('medical_signs');
		$Nombres->set($data);
		$Nombres->where('id_folio', $id_folio);
		$Nombres->update($data);
	}

	public function update_receta($id_folio, $data)
	{
		$Nombres = $this->db->table('hcv_receta');
		$Nombres->set($data);
		$Nombres->where('id_folio', $id_folio);
		$Nombres->update();
	}

	public function update_nota($id, $data)
	{

		$Nombres = $this->db->table('hcv_nota_general');
		$Nombres->set($data);
		$Nombres->where('id', $id);
		$Nombres->update();
	}


	public function get_notas($id, $folio)
	{
		$Nombres = $this->db->query("SELECT * from hcv_nota_general WHERE id_patient='" . $id . "'AND id_folio='" . $folio . "'");
		return $Nombres->getResult();
	}

	public function insert_history($data)
	{
		$Nombres = $this->db->table('hcv_diagnostic_history');
		$Nombres->insert($data);
	}

	public function delete_history_diag($id)
	{
		$builder = $this->db->table('hcv_diagnostic_history');
		$builder->where('id', $id);
		$builder->delete();
	}

	public function get_nutricionles($folio, $id){
		$Nombres = $this->db->query("SELECT * from hcv_nutricion WHERE id_patient='" . $id . "'AND id_folio='" . $folio . "'");
		return $Nombres->getResult();
	}


	public function insert_nutricion($data)
	{
		$Nombres = $this->db->table('hcv_nutricion');
		$Nombres->insert($data);
	}

	public function update_nutricion($id_folio, $data)
	{
		$Nombres = $this->db->table('hcv_nutricion');
		$Nombres->set($data);
		$Nombres->where('id_folio', $id_folio);
		$Nombres->update($data);
	}

	public function get_nutricion_datos($folio){
		$Nombres = $this->db->query("SELECT * from hcv_nutricion WHERE id_folio= '" . $folio . "'");
		return $Nombres->getResult();
	}


	public function insert_psicology($data)
	{
		$Nombres = $this->db->table('hcv_psicology');
		$Nombres->insert($data);
	}


	public function insert_photo($data)
	{
		$Nombres = $this->db->table('photo_evidency');
		$Nombres->insert($data);
	}

	//Recuperar evidencia de photos

	public function get_photo($id, $folio)
	{
		$Nombres = $this->db->query("SELECT * from photo_evidency WHERE id_patient='" . $id . "'AND id_folio='" . $folio . "'");
		return $Nombres->getResult();
	}

	//hcv_diagnostic_nutricional

	public function get_hcv_diagnostic_nutricional($id, $folio)
	{
		$Nombres = $this->db->query("SELECT * from hcv_diagnostic_nutricional WHERE id_patient='" . $id . "'AND id_folio='" . $folio . "'");
		return $Nombres->getResult();
	}

	public function insert_diagnostic($data)
	{
		$Nombres = $this->db->table('hcv_diagnostic_nutricional');
		$Nombres->insert($data);
	}

	public function delete_diagnostico($id)
	{
		$builder = $this->db->table('hcv_diagnostic_nutricional');
		$builder->where('id', $id);
		$builder->delete();
	}
	////////////////////////////////////

	public function insert_dosis($pres, $medic, $indica, $id_patient, $id_folio, $id_medico, $fecha, $time)
	{

		$data = [
			"medicamento" => $medic,
			"presentacion" => $pres,
			"cantidad" => 1,
			"unidad" => 1,
			"indicaciones" => $indica,
			//"indicaciones_secundarias"=>$indica_secu,
			"fecha" => $fecha,
			"hora" => $time,
			"id_patient" => $id_patient,
			"id_folio" => $id_folio,
			"id_medico" => $id_medico


		];

		$Nombres = $this->db->table('hcv_receta');
		$Nombres->insert($data);
	}

	public function get_data_pdf($id_folio)
	{
		$Nombres = $this->db->query("SELECT * from hcv_receta where id_folio='" . $id_folio . "'");
		return $Nombres->getResult();
	}



	/*Nutricional diagnostic*/

	public function hcv_cat_diagnostic()
	{
		$Nombres = $this->db->query("SELECT * from hcv_cat_nutritional_diagnostic");
		return $Nombres->getResult();
	}

	//funcion que nos ayuda a investigar el inner de la tabla de nutricion diagnostico
	public function get_hcv_inner_diagnostic($id_patient, $id_folio)
	{
		$Nombres = $this->db->query("SELECT hdn.id AS id ,hcnd.name AS nombre1,hctnd.name AS nombre2,indice.name AS nombre3,indice2.name AS nombre4 from  hcv_cat_nutritional_diagnostic as hcnd inner join 
				hcv_diagnostic_nutricional as hdn on hcnd.id=hdn.tipo 
				inner join hcv_cat_type_nutricional_diagnostic as hctnd on
				hctnd.id=hdn.balance
				inner join hcv_cat_diagnostic_indice as indice on
				indice.id=hdn.grasa
				inner join hcv_cat_diagnostic_indice2 as indice2 on
				indice2.id=hdn.ingesta
				where hdn.id_patient='" . $id_patient . "' AND hdn.id_folio='" . $id_folio . "' group by hdn.id");
		return $Nombres->getResult();
	}


	public function get_type_n($id)
	{
		$Nombres = $this->db->query("SELECT * from hcv_cat_type_nutricional_diagnostic WHERE hcv_diagnostic_nutricional_id='" . $id . "'");
		return $Nombres->getResult();
	}


	public function get_type_n_i($id)
	{
		$Nombres = $this->db->query("SELECT * from hcv_cat_diagnostic_indice WHERE hcv_diagnostic_type_id='" . $id . "'");
		return $Nombres->getResult();
	}

	public function get_type_n_i2($id)
	{
		$Nombres = $this->db->query("SELECT * from hcv_cat_diagnostic_indice2 WHERE hcv_diagnostic_indice_id='" . $id . "'");
		return $Nombres->getResult();
	}


	public function get_hcv_identity($id)
	{
		$Nombres = $this->db->query("SELECT * from hcv_identity WHERE ID_USER='" . $id . "'");
		return $Nombres->getResult();
	}

	public function get_ingesta($id)
	{
		$Nombres = $this->db->query("SELECT name from hcv_cat_diagnostic_indice2 WHERE id='" . $id . "'");
		return $Nombres->getResult();
	}

	public function get_alimentacion($id)
	{
		$Nombres = $this->db->query("SELECT name from hcv_cat_diagnostic_indice WHERE id='" . $id . "'");
		return $Nombres->getResult();
	}


	/*Recuperar todo olo de historial clinico*/
	public function get_medical_sign($id, $folio)
	{
		$Nombres = $this->db->query("SELECT * from medical_signs WHERE id_patient='" . $id . "' AND id_folio='" . $folio . "'");
		return $Nombres->getResult();
	}


	public function get_historic_diagnostic_sign($id, $folio)
	{
		$Nombres = $this->db->query("SELECT * from hcv_diagnostic_history WHERE id_patient='" . $id . "' AND id_folio='" . $folio . "'");
		return $Nombres->getResult();
	}

	public function get_notas_historia_diagnostic($id, $folio)
	{
		$Nombres = $this->db->query("SELECT * from hcv_nota_general where id_patient='" . $id . "'AND id_folio='" . $folio . "'");
		return $Nombres->getResult();
	}

	public function get_hcv_nutricion($id, $folio)
	{
		$Nombres = $this->db->query("SELECT * from hcv_nutricion where id_patient='" . $id . "'AND id_folio='" . $folio . "'");
		return $Nombres->getResult();
	}

	public function get_hcv_psicology($id, $folio)
	{
		$Nombres = $this->db->query("SELECT * from hcv_psicology where id_patient='" . $id . "'AND id_folio='" . $folio . "'");
		return $Nombres->getResult();
	}


	public function get_photo_2($id, $folio)
	{
		$Nombres = $this->db->query("SELECT * from photo_evidency WHERE id_patient='" . $id . "'AND id_folio='" . $folio . "'");
		return $Nombres->getResult();
	}

	/*Recuperar la hitoria de diagnostico nutricional*/

	public function get_diagnostic_nutricional($id, $folio)
	{
		$Nombres = $this->db->query("SELECT * from hcv_diagnostic_nutricional WHERE id_patient='" . $id . "'AND id_folio='" . $folio . "'");
		return $Nombres->getResult();
	}

	public function get_tipo($id)
	{
		$Nombres = $this->db->query("SELECT name from hcv_cat_nutritional_diagnostic WHERE id='" . $id . "'");
		return $Nombres->getResult();
	}


	public function get_tipo_tipo($id)
	{
		$Nombres = $this->db->query("SELECT name from hcv_cat_type_nutricional_diagnostic WHERE id='" . $id . "'");
		return $Nombres->getResult();
	}

	public function get_tipo_indice1($id)
	{
		$Nombres = $this->db->query("SELECT name from hcv_cat_diagnostic_indice WHERE id='" . $id . "'");
		return $Nombres->getResult();
	}

	public function get_tipo_indice2($id)
	{
		$Nombres = $this->db->query("SELECT name from hcv_cat_diagnostic_indice2 WHERE id='" . $id . "'");
		return $Nombres->getResult();
	}

	
	/*Aqui termmian*/


	/*Receta*/
	public function get_receta_hcv($id, $folio)
	{
		$Nombres = $this->db->query("SELECT * from hcv_receta WHERE id_patient='" . $id . "'AND id_folio='" . $folio . "'");
		return $Nombres->getResult();
	}

	public function get_doctor($id)
	{
		$Nombres = $this->db->query("SELECT * from hcv_identity_operativo WHERE id_user='" . $id . "'");
		return $Nombres->getResult();
	}

	public function get_paciente($id)
	{
		$Nombres = $this->db->query("SELECT * from hcv_identity WHERE ID_USER='" . $id . "'");
		return $Nombres->getResult();
	}

	public function get_paciente_send($id)
	{
		$Nombres = $this->db->query("SELECT * from users WHERE id='" . $id . "'");
		return $Nombres->getResult();
	}

	/*FIN*/
	/*Para verificar si existen los datos en la base */
	public function get_nutricion_ver($id, $folio)
	{
		$Nombres = $this->db->query("SELECT * from hcv_nutricion WHERE id_patient='" . $id . "'AND id_folio='" . $folio . "'");
		return $Nombres->getResult();
	}

	public function get_psicology_ver($id, $folio)
	{
		$Nombres = $this->db->query("SELECT * from hcv_psicology WHERE id_patient='" . $id . "'AND id_folio='" . $folio . "'");
		return $Nombres->getResult();
	}

	public function get_name_doctor($id)
	{
		$Nombres = $this->db->query("SELECT user_name from users WHERE id='" . $id . "'");
		return $Nombres->getResult();
	}

	/*FINNNN*/


	/*Recuperar la especialidad del medico*/

	public function get_role_medico($id)
	{
		$Nombres = $this->db->query("SELECT discipline from hcv_identity_operativo WHERE id_user='" . $id . "'");
		return $Nombres->getResult();
	}


	public function delete_evidencia_db($id)
	{
		$builder = $this->db->table('photo_evidency');
		$builder->where('id', $id);
		$builder->delete();
	}

	
	public function get_medicamento($id_cita)
	{
		$builder = $this->db->table('hcv_receta');
		$builder->select('*');
		$query = $builder->getWhere(['id_folio' => $id_cita]);
        return $query->getResult();
	}

	public function delete_medicamento($id)
	{
		$builder = $this->db->table('hcv_receta');
		$builder->where('id', $id);
		$builder->delete();
	}

	public function get_nota_general($id_cita)
	{
		return $this->asArray()
		->select('medical_signs.id,hcv_nota_general.id as id_general,hcv_diagnostic_history.id as id_historico,hcv_receta.id as id_receta')
		->join('hcv_nota_general', 'hcv_nota_general.id_folio = medical_signs.id_folio')
		->join('hcv_diagnostic_history', 'hcv_diagnostic_history.id_folio = hcv_nota_general.id_folio')
		->join('hcv_receta', 'hcv_receta.id_folio = hcv_diagnostic_history.id_folio')
		->where('medical_signs.id_folio', $id_cita)
		->findAll();
	
	}

	public function get_psicologia($id_cita){
		$db = \Config\Database::connect();
        $builder = $db->table('hcv_psicology');
        $builder->select('*');
        $query = $builder->getWhere(['id_folio' => $id_cita]);
        return $query->getResult();
	}

	public function get_nutricion($id_cita){
		$db = \Config\Database::connect();
        $builder = $db->table('hcv_nutricion');
        $builder->select('hcv_nutricion.*,hcv_diagnostic_nutricional.*');
		$builder->join('hcv_diagnostic_nutricional','hcv_diagnostic_nutricional.id_folio = hcv_nutricion.id_folio');
		$builder->where('hcv_nutricion.id_folio', $id_cita);
		$query = $builder->get();
        return $query->getResult();


	}

	public function get_signos_vitales($id_cita){
        return $this->asArray()
        ->select('hcv_nutricion.*')
        ->where('medical_signs.id_folio',$id_cita)
        ->find();
    }




	// Obtener los datos clinicos de signos medicos para registro medico
    public function getDatosSignos($id_patient){
        return $this->asArray()
        ->select('*')
        ->where('patient_id', $id_patient)
        ->findAll();
    }
}