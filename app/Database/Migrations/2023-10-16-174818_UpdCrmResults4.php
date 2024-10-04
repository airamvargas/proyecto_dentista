<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdCrmResults4 extends Migration
{
	public function up()
	{
		$fields = [
			'question_type' => [
				'type'       => 'TINYINT',
				'null' => false,
				'after' => 'metodo',
			],

			'name_study' => [
				'type'       => 'VARCHAR',
				'constraint' => '250',
				'null' => false,
				'after' => 'id_study',
			],

			'unit_of_measure' => [
				'type'       => 'VARCHAR',
				'constraint' => '250',
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
