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

class AbonosTotales extends Model {

	protected $table = "crm_abonosTotales";
	protected $primaryKey = "id";
	protected $returnType = "array";
	protected $useSoftDeletes = true;
	protected $allowedFields = ['id_company', 'total_abonos', 'total_residuo', 'created_at', 'updated_at', 'deleted_at'];
	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deleteddField = 'deleted_at';
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;

	public function getCompany(){
		$sql = "SELECT id_company, total_abonos, total_residuo, cat_company_client.name AS empresa, (SELECT SUM(amount) FROM payments JOIN cotization
		ON cotization.id = payments.id_cotization JOIN cat_conventions ON cat_conventions.id = cotization.id_conventions WHERE 
		crm_abonosTotales.id_company = cat_conventions.id_cat_company_client AND payments.deleted_at IS NULL AND id_payment_type 
		in(".PENDIENTE_T."," .PAGO_GLOBAL_T.")) AS adeudo_total, (SELECT SUM(amount) FROM payments JOIN cotization ON cotization.id = payments.id_cotization JOIN 
		cat_conventions ON cat_conventions.id = cotization.id_conventions WHERE id_payment_type = :type_payment: AND crm_abonosTotales.id_company = 
		cat_conventions.id_cat_company_client AND payments.deleted_at IS NULL) AS adeudo_pagado FROM crm_abonosTotales JOIN 
		cat_company_client ON cat_company_client.id = crm_abonosTotales.id_company WHERE crm_abonosTotales.deleted_at IS NULL";
        $datos = $this->db->query($sql, ['type_payment' => PAGO_GLOBAL_T]); // En la base de produccion es el tipo = 6
        return $datos->getResult();
	}
}
