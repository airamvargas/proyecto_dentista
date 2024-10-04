<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdCrmRanges extends Migration
{
	public function up()
	{
		$fields = [
			'operator' => [
				'type'       => 'VARCHAR',
                'constraint' => '11',
				'null' => true,
				'after' => 'id_age_range',
			],
		];	

		$this->forge->addColumn('crm_ranges', $fields);

		
	}

	public function down()
	{
		$this->forge->dropColumn('crm_ranges', 'operator');
	}
}
