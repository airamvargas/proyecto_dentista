<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addabonospagos extends Migration
{
	public function up()
	{
		$fields = [
			'cerrado' => [
				'type'       => 'TINYINT',
				'null' => false,
				'after' => 'monto',
			]
		];	

		$this->forge->addColumn('crm_abonos_x_pagos', $fields);
	}

	public function down()
	{
		////$this->forge->dropColumn('crm_abonos_x_pagos', 'cerrado');
	}
}
