<?php namespace App\Models;

use CodeIgniter\Model;

class Model_condiciones extends Model {

	protected $table="condiciones_pago";
	protected $primaryKey="id";
	protected $returnType="array";
	protected $useSoftDeletes=true;
	protected $allowedFields=['id', 'id_cotizacion_producto', 'dias_fabricacion', 'dias_entrega', 'costo_china'];
	protected $useTimestamps=false;
	protected $validationRules=[];
	protected $validationMessages=[];
	protected $skipValidation=false;




}