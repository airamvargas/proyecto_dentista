<?php
/* 
Desarrollador: 
Fecha de creacion:
Fecha de Ultima Actualizacion: 30 de enero de 2024
Perfil: Back office
Descripcion: Pagos de orden de servicio
*/

namespace App\Models\Model_cotizacion;

use CodeIgniter\Model;

class Model_pagos extends Model
{

	protected $table = "payments";
	protected $primaryKey = "id";
	protected $returnType = "array";
	protected $useSoftDeletes = true;
	protected $allowedFields = ['id_way_to_pay', 'id_payment_type', 'id_cotization', 'id_cash_box', 'amount'];
	protected $useTimestamps = true;
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;

	public function show($id)
	{
		$sql = "SELECT payments.id, (SELECT name FROM way_to_pay WHERE way_to_pay.id = payments.id_way_to_pay) AS forma_pago, (SELECT name FROM payment_type 
		WHERE payment_type.id = payments.id_payment_type) AS tipo_pago, amount FROM payments WHERE 
		id_cotization = :id: AND payments.deleted_at = :deleted:";
		$datos = $this->db->query($sql, ['id' => $id, 'deleted' => '0000-00-00 00:00:00']);
		return $datos->getResult();
	}

	public function showPayments($id)
	{
		$sql = "SELECT SUM(amount) AS total_pagos FROM payments WHERE id_cotization = :id: AND payments.deleted_at = :deleted:";
		$datos = $this->db->query($sql, ['id' => $id, 'deleted' => '0000-00-00 00:00:00']);
		return $datos->getResult();
	}

	public function readUpdate($id)
	{
		return $this->asArray()
			->select('*')
			->where('id', $id)
			->findAll();
	}

	public function getPayments($id_box)
	{
		return $this->asArray()
			->select('payments.id_cotization as cotizacion, payments.amount,way_to_pay.name,payments.id_cash_box')
			->join('way_to_pay', 'way_to_pay.id = payments.id_way_to_pay', 'left')
			->where('id_cash_box', $id_box)
			->findAll();
	}

	public function reporteVentas($sql)
	{
		return $this->db->query($sql)->getResult();
	}

	public function adeudos($id_company)
	{
		$sql = "SELECT payments.id AS folio, cat_conventions.name AS convenio, amount AS total, payments.id_cotization AS orden_servicio, 
		payments.created_at AS fecha, (SELECT payments.amount - SUM(crm_abonos_x_pagos.monto) FROM crm_abonos_x_pagos WHERE payments.id 
		= crm_abonos_x_pagos.id_payment AND crm_abonos_x_pagos.deleted_at IS NULL) AS adeudo FROM payments LEFT JOIN cotization ON cotization.id = payments.id_cotization LEFT JOIN 
		cat_conventions ON cat_conventions.id = cotization.id_conventions WHERE cat_conventions.id_cat_company_client = :id_company: AND  
		payments.id_payment_type in(:pendiente:, :parcial:) AND payments.deleted_at IS NULL";
		$datos = $this->db->query($sql, ['id_company' => $id_company, 'pendiente' => PENDIENTE_T, 'parcial' => PARCIAL_T]);
		return $datos->getResult();
	}

	public function pagosCotizacion($id_cotizacion)
	{
		return $this->asArray()
			->select('payments.id AS folio_pago, crm_abonos_x_pagos.id, amount, way_to_pay.name AS forma_pago, payment_type.name AS tipo_pago, payments.updated_at AS fecha_pago, 
		crm_abonos_x_pagos.monto AS pagado')
			->join('way_to_pay', 'way_to_pay.id = payments.id_way_to_pay', 'left')
			->join('payment_type', 'payment_type.id = payments.id_payment_type', 'left')
			->join('crm_abonos_x_pagos', 'crm_abonos_x_pagos.id_payment = payments.id', 'left')
			->where('id_cotization', $id_cotizacion)
			->where('crm_abonos_x_pagos.deleted_at IS NULL')
			->findAll();
	}

	public function getPaymentsbox($id)
	{
		return $this->asArray()
			->select('*,payment_type.name')
			->join('payment_type', 'payment_type.id = payments.id_payment_type', 'left')
			->where('id_cash_box', $id)
			->where('payment_type.id', 3)
			->findAll();
	}

	public function reportPayments($sql)
	{
		return $this->db->query($sql)->getResult();
		
	}
}
