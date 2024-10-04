<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdOperativo extends Migration
{
	public function up()
	{
		$fields = [
			'signature' => [
				'type'       => 'VARCHAR',
				'constraint' => '500',
				'null' => true,
				'after' => 'LONGITUD',
			],
		];	

		$this->forge->addColumn('hcv_identity_operativo', $fields);
	}

	public function down()
	{
		//
	}
}


