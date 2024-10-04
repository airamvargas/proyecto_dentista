<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Contenedores extends Migration
{
	public function up()
	{
		$fields = [
			'created_at' => [
				'type'       => 'DATETIME',
			],

			'updated_at' => [
				'type'       => 'DATETIME',
			],

			'deleted_at' => [
				'type'       => 'DATETIME',
			],
		];

		$this->forge->addColumn('containers', $fields);
	}

	public function down()
	{
		$array =  array('created_at','updated_at','deleted_at');
		$this->forge->dropColumn('containers',$array);
	}
}
