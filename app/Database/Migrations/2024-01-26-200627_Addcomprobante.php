<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addcomprobante extends Migration
{
	public function up()
	{
		$fields = [
			'comprobante' => [
				'type'       => 'VARCHAR',
                'constraint' => '250',
				'null' => true,
				'after' => 'medio_pago',
			]
		];	

		$this->forge->addColumn('crm_abonosIndividuales', $fields);
	}

	public function down()
	{
		//$this->forge->dropColumn('crm_abonosIndividuales', 'comprobante');
	}
}
