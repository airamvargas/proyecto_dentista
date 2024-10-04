<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Incidencias extends Migration
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
            'name_doctor' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
				'null' => false,
            ],
            'id_doctor' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null' => false,
            ],
			'id_study' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
				'null' => false,
            ],
			'name_study' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
				'null' => false,
            ],

			'id_cita' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],

			'incidence' => [
                'type'       => 'TEXT',
				'null' => true,
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
        $this->forge->createTable('incidents');
	}

	public function down()
	{
		$this->forge->dropTable('incidents');
	}
}
