<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdCitasUser extends Migration
{
	public function up()
	{
		$fields = [
			'id_user' => [
				'type'       => 'INT',
                'constraint' => 11,
				'null' => true,
				'after' => 'id_doctor',
			],

		];

		$this->forge->addColumn('citas', $fields);
	}

	public function down()
	{
		$array =  array('id_user');
		$this->forge->dropColumn('citas',$array);
	}
}
