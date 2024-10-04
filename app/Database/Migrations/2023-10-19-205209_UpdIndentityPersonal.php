<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdIndentityPersonal extends Migration
{
	public function up()
	{
		$fields = [
			'signature' => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
				'after' => 'photo',
			],
		];	

		$this->forge->addColumn('identity_employed', $fields);
	}

	public function down()
	{
		$array =  array('signature');
		$this->forge->dropColumn('cotization',$array);
	}
}
