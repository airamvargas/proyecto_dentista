<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class QrCotizacion extends Migration
{
	public function up()
	{
		$fields = [
			'codigo_qr' => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'after' => 'correo',
			],

		];
		$this->forge->addColumn('cotization', $fields);
	}

	public function down()
	{
		$this->forge->dropColumn('cotization', 'codigo_qr');
	}
}
