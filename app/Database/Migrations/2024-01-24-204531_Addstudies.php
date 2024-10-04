<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addstudies extends Migration
{
	public function up()
	{
		$fields = [
			'dias_entrega' => [
				'type'       => 'VARCHAR',
                'constraint' => '255',
				'null' => true,
				'after' => 'n_labels',
			],
			'dias_proceso' => [
				'type'       => 'VARCHAR',
                'constraint' => '255',
				'null' => true,
				'after' => 'dias_entrega',
			],
			'tiempo_entrega' => [
				'type'       => 'VARCHAR',
                'constraint' => '255',
				'null' => true,
				'after' => 'dias_proceso',
			],
			'costo_proceso' => [
				'type'       => 'DECIMAL',
                'constraint' => '10,2',
				'null' => true,
				'after' => 'tiempo_entrega',
			],
		];	

		$this->forge->addColumn('cat_studies', $fields);
	}

	public function down()
	{
		//$this->forge->dropColumn('cat_studies', 'operator');
	}
}
