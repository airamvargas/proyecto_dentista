<?php
/* 
Desarrollador: Airam Vargas
Fecha de creacion: 24 de noviembre de 2023
Fecha de Ultima Actualizacion:
Perfil: Back office
Descripcion: Abonos totales de las empresas
*/

namespace App\Models\Back_office\Reportes;

use CodeIgniter\Model;

class AbonosIndividuales extends Model {

	protected $table = "crm_abonosIndividuales";
	protected $primaryKey = "id";
	protected $returnType = "array";
	protected $useSoftDeletes = true;
	protected $allowedFields = ['id_company', 'abono', 'concepto', 'c_fecha', 'medio_pago', 'comprobante', 'created_at', 'updated_at', 'deleted_at'];
	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deleteddField = 'deleted_at';
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;

	public function getAbonos($id_company){
		$sql = "SELECT crm_abonosIndividuales.*, cat_company_client.name AS empresa, (SELECT SUM(monto) FROM crm_abonos_x_pagos WHERE id_abono = 
		crm_abonosIndividuales.id AND crm_abonos_x_pagos.deleted_at IS NULL) AS saldo_utilizado FROM crm_abonosIndividuales JOIN cat_company_client ON 
		cat_company_client.id = crm_abonosIndividuales.id_company WHERE id_company = :id_company: AND crm_abonosIndividuales.deleted_at IS NULL";
        $datos = $this->db->query($sql, ['id_company' => $id_company]);
        return $datos->getResult();
	}

	public function getIndividual($id_abono){
		return $this->asArray()
		->select('crm_abonosIndividuales.*, cat_company_client.name AS empresa')
		->join('cat_company_client', 'cat_company_client.id = crm_abonosIndividuales.id_company')
		->where('crm_abonosIndividuales.id', $id_abono)
		->find();
	}
}
