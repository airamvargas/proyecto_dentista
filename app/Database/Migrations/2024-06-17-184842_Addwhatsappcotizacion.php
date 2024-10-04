<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addwhatsappcotizacion extends Migration
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
		$this->forge->addColumn('cotization', $fields);
	}

	public function down()
	{
		//
	}
}
