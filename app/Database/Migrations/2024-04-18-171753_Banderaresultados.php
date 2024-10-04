<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Banderaresultados extends Migration
{
	public function up()
	{
		$fields = [
			'documento' => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'null' => false,
				'after' => 'unit_of_measure',
			],
			'bandera' => [
				'type'       => 'TINYINT',
				'null' => false,
				'after' => 'success',
			]
		];	
		$this->forge->addColumn('crm_results', $fields);
	}

	public function down()
	{
		//$this->forge->dropColumn('crm_results', 'precio_convenio');
	}
}
