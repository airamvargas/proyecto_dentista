<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ResultsUpd extends Migration
{
	public function up()
	{
		$fields = [
			'id_analito' => [
				'type'       => 'INT',
                'constraint' => 11,
				'null' => false,
				'after' => 'id_study',
			],

			
		];

		$this->forge->addColumn('crm_results', $fields);
	}

	public function down()
	{
		$this->forge->dropColumn('crm_results', 'id_analito');
	}
}
