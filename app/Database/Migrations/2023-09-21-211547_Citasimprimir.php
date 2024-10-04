<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Citasimprimir extends Migration
{
	public function up()
	{
		{
			$fields = [
				'imprimir' => [
					'type'       => 'INT',
					'constraint' => '11',
					'after' => 'codigo',
				],
	
			];
			$this->forge->addColumn('citas',$fields);
		}
	}

	public function down()
	{
		$this->forge->dropColumn('citas', 'imprimir');
	}

}
