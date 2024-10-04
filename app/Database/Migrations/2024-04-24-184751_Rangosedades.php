<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rangosedades extends Migration
{
	public function up()
	{
		$fields = [
			'edad_minima' => [
				'type'       => 'INT',
				'constraint' => 11,
				'null' => true,
				'after' => 'id_age_range',
			],

			'edad_maxima' => [
				'type'       => 'INT',
				'null' => true,
				'after' => 'edad_minima',
			]
		];	
		$this->forge->addColumn('crm_ranges', $fields);
	}

	public function down()
	{
		//$this->forge->dropColumn('crm_ranges', $fields);
	}
}
