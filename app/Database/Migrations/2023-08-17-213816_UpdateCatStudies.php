<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateCatStudies extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();
		$fields = [
			'id_container' => [
				'type'       => 'INT',
				'constraint'     => 11,
				'after' => 'preparation'
			],

			'id_muestra' => [
				'type'       => 'INT',
				'constraint'     => 11,
				'after' => 'id_container'
			],

			'sample_volume' => [
				'type'       => 'VARCHAR',
				'constraint'     => 20,
				'after' => 'id_muestra'
			],
		];

	
		$this->forge->addColumn('cat_studies', $fields);
		//$this->forge->addForeignKey('id_muestra', 'sample_types', 'id');
	    //$this->forge->addForeignKey('id_container', 'containers', 'id'); 
		$this->db->enableForeignKeyChecks();

		
		
	}

	public function down()
	{
		$array =  array('id_container','id_muestra','sample_volume');
		$this->forge->dropColumn('cat_studies',$array);
	}
}
