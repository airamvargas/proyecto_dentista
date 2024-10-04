<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdNotificacion extends Migration
{
	public function up()
	{
		$fields = [
			'sub_mensaje' => [
				'type'       => 'VARCHAR',
				'constraint' => '500',
				'null' => true,
				'after' => 'id_user_receptor',
			],

			'url' => [
				'type'       => 'VARCHAR',
				'constraint' => '500',
				'null' => true,
				'after' => 'sub_mensaje',
			],
		];	

		$this->forge->addColumn('notifications', $fields);
	}

	public function down()
	{
		//
	}
}
