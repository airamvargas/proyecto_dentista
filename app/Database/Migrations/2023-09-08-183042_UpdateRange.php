<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateRange extends Migration
{
	public function up()
	{
		$fields = [
			'id_crm_gender' => [
				'type'       => 'INT',
				'after' => 'max',
			],

		];
		$this->forge->addColumn('crm_cat_age_range',$fields);
	}

	public function down()
	{
		$this->forge->dropColumn('crm_cat_age_range', 'id_crm_gender');
	}
}
