<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdCrmResults3 extends Migration
{
	public function up()
	{
		$fields = [
			'operator' => [
				'type'       => 'VARCHAR',
                'constraint' => '20',
				'null' => false,
				'after' => 'metodo',
			],

		];

		$this->forge->addColumn('crm_results', $fields);
	}

	public function down()
	{
		//
	}
}
