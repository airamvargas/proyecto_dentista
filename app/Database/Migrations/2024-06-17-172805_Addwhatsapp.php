<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addwhatsapp extends Migration
{
	public function up()
	{
		$fields = [
			'whatsapp' => [
				'type'       => 'VARCHAR',
				'constraint' => 15,
				'null' => true,
				'after' => 'email',
			],
		];	
		$this->forge->addColumn('company_data', $fields);
	}

	public function down()
	{
		//
	}
}
