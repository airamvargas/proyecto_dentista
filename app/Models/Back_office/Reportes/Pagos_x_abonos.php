<?php
/* 
Desarrollador: Airam Vargas
Fecha de creacion: 21 de diciembre de 2023
Fecha de Ultima Actualizacion: 30 de enero de 2024
Perfil: Back office
Descripcion: Pagos de adeudos por abonos de las empresas
*/

namespace App\Models\Back_office\Reportes;

use CodeIgniter\Model;

class Pagos_x_abonos extends Model {

	protected $table = "crm_abonos_x_pagos";
	protected $primaryKey = "id";
	protected $returnType = "array";
	protected $useSoftDeletes = true;
	protected $allowedFields = ['id_abono', 'id_payment', 'monto', 'cerrada', 'created_at', 'updated_at', 'deleted_at'];
	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deleteddField = 'deleted_at';
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;

	public function pagados($id_abono){
		return $this->asArray()
        ->select('crm_abonos_x_pagos.id, id_abono, payments.id AS folio, cat_conventions.name AS convenio, payments.amount AS Pago, crm_abonos_x_pagos.monto AS monto_pagado, 
		crm_abonos_x_pagos.created_at AS fecha, payments.id_cotization AS Orden_servicio, cerrada')
		->join('payments', 'payments.id = crm_abonos_x_pagos.id_payment')
		->join('cotization','cotization.id = payments.id_cotization','left')
		->join('cat_conventions','cat_conventions.id = cotization.id_conventions')
        ->where('id_abono', $id_abono)
        ->findAll();
	}
}
