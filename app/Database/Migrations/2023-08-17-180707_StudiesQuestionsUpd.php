<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StudiesQuestionsUpd extends Migration
{
	public function up()
	{
		$fields = [
			'type' => [
				'name' => 'type_name',
				'type'           => 'VARCHAR',
				'constraint'     => 500,
				
			],
		];
		$this->forge->modifyColumn('questions', $fields);

		$campos = [
			'type' => [
				'type' => 'TINYINT'
			],
		];
		$this->forge->addColumn('questions', $campos);


	}

	public function down()
	{
		$fields = [
			'type' => [
				'name' => 'type',
				'null' => false,
			],
		];
		$this->forge->modifyColumn('questions', $fields);
		$array =  array('type');
		$this->forge->dropColumn('appointments_procedures',$array);

		
	}
}
