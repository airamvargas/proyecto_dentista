<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpIndetyOp extends Migration
{
	public function up()
	{
		$fields = [
			'status_area' => ['type' => 'TEXT',
			'after' => 'id_consulting_room'],
			
		];
		$this->forge->addColumn('hcv_identity_operativo', $fields);
		
	}

	public function down()
	{
		$this->forge->dropColumn('hcv_identity_operativo', 'status_area');
	}
}
