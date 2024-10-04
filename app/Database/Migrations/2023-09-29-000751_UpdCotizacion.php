<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdCotizacion extends Migration
{
	public function up()
	{
		$fields = [
			'medic_referido' => [
				'type'       => 'VARCHAR',
				'constraint' => '250',
				'after' => 'email',
			],

			'tel_medic' => [
				'type'       => 'VARCHAR',
				'constraint' => '12',
				'after' => 'medic_referido',
			],

			'correo' => [
				'type'       => 'VARCHAR',
				'constraint' => '250',
				'after' => 'tel_medic',
			],

		];
		$this->forge->addColumn('cotization',$fields);
	}

	public function down()
	{
		$array =  array('medic_referido','tel_medic','correo');
		$this->forge->dropColumn('cotization',$array);
	}
}
