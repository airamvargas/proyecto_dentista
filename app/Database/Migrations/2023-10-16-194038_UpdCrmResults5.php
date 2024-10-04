<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdCrmResults5 extends Migration
{
	public function up()
	{
		$fields = [
			'agrupador' => [
				'type'       => 'VARCHAR',
				'constraint' => '250',
				'null' => true,
				'after' => 'name_analito',
			],

			

		];

		$this->forge->addColumn('crm_results', $fields);
	}

	public function down()
	{
		//
	}
}
