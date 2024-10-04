<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProcedimientosCitasUpd extends Migration
{
	public function up()
	{
		$fields = [
			'created_at' => [
				'type'       => 'DATETIME',
				'after' => 'commun_name',
			],

			'updated_at' => [
				'type'       => 'DATETIME',
				'after' => 'created_at',
			],

			'deleted_at' => [
				'type'       => 'DATETIME',
				'after' => 'updated_at',
			],
		];
		$this->forge->addColumn('appointments_procedures',$fields);
		
	}

	public function down()
	{
		$array =  array('created_at','updated_at','deleted_at');
		$this->forge->dropColumn('appointments_procedures',$array);
	}
}


