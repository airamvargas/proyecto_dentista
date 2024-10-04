<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Updaterange extends Migration
{
	public function up()
	{
		$fields = [
			'description' => [
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'after' => 'max',
			],

		];
		$this->forge->addColumn('crm_cat_age_range',$fields);
	}

	public function down()
	{
		$this->forge->dropColumn('crm_cat_age_range', 'description');
	}
}
