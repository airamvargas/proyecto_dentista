<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Abonostotales extends Migration
{
	public function up()
	{
		$this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
				'null' => false,
            ],
            'id_company' => [
                'type'       => 'INT',
                'constraint' => 11,
				'null' => false,
            ],
			'total_abonos' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
				'null' => false,
            ],
			'total_residuo' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
				'null' => false,
            ],
			'created_at' => [
				'type'       => 'DATETIME',
			],

			'updated_at' => [
				'type'       => 'DATETIME',
			],

			'deleted_at' => [
				'type'       => 'DATETIME',
			],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('crm_abonosTotales');
	}

	public function down()
	{
		//this->forge->dropTable('crm_abonosTotales');
	}
}
