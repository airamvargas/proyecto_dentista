<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdCitas extends Migration
{
	public function up()
	{
		$fields = [
			'id_recolector' => [
				'type'       => 'INT',
                'constraint' => 11,
				'null' => false,
				'after' => 'imprimir',
			],

			'id_capturista' => [
				'type'       => 'INT',
                'constraint' => 11,
				'null' => false,
				'after' => 'id_recolector',
			],

			'id_responsable' => [
				'type'       => 'INT',
                'constraint' => 11,
				'null' => false,
				'after' => 'id_capturista',
			],

		];

		$this->forge->addColumn('citas', $fields);
	}

	public function down()
	{
		$array =  array('id_recolector','id_capturista','id_responsable');
		$this->forge->dropColumn('cotization',$array);
	}
}
