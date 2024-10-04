<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdCrmResults2 extends Migration
{
	public function up()
	{
		$fields = [
			'sex' => [
				'type'       => 'VARCHAR',
                'constraint' => '20',
				'null' => false,
				'after' => 'name_paciente',
			],

			'success' => [
				'type'       => 'BOOLEAN',
				'null' => false,
				'after' => 'referencia_max',
			],	
		];

		$this->forge->addColumn('crm_results', $fields);
	}

	public function down()
	{
		//
	}
}
