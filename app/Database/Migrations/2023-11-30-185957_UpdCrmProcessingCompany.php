<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdCrmProcessingCompany extends Migration
{
	public function up()
	{
		$fields = [
			'id_user' => [
				'type'       => 'INT',
                'constraint' => 11,
				'null' => true,
				'after' => 'type',
			],
			'tel' => [
				'type'       => 'VARCHAR',
                'constraint' => 15,
				'null' => true,
				'after' => 'name',
			],

		];

		$this->forge->addColumn('crm_processing_company', $fields);
	}

	public function down()
	{
		$array =  array('id_user, tel');
		$this->forge->dropColumn('crm_processing_company',$array);
	}
}
