<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ResultsColumnsUpd extends Migration
{
	public function up()
	{
		$fields = [
			'edad' => [
				'type'       => 'VARCHAR',
                'constraint' => '11',
				'null' => false,
				'after' => 'id_responsible',
			],

			'name_paciente' => [
				'type'       => 'VARCHAR',
                'constraint' => '250',
				'null' => false,
				'after' => 'edad',
			],


			'tipo_muestra' => [
				'type'       => 'VARCHAR',
                'constraint' => '250',
				'null' => false,
				'after' => 'name_paciente'
			],

			'metodo' => [
				'type'       => 'VARCHAR',
                'constraint' => '250',
				'null' => false,
				'after' => 'tipo_muestra'

			],

			'referencia_min' => [
				'type'       => 'VARCHAR',
                'constraint' => '250',
				'null' => false,
				'after' => 'metodo'
			],

			'referencia_max' => [
				'type'       => 'VARCHAR',
                'constraint' => '250',
				'null' => false,
				'after' => 'referencia_min'
			],

			



			
		];

		$this->forge->addColumn('crm_results', $fields);
	}

	public function down()
	{
		//
	}
}
