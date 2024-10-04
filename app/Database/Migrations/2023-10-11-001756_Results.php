<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Results extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();
		$this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
				'null' => false,
            ],

            'id_cita' => [
                'type'       => 'INT',
                'constraint' => 11,
				'null' => false,
            ],

			'id_study' => [
                'type'       => 'INT',
                'constraint' => 11,
				'null' => false,
            ],

			'name_analito' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
				'null' => false,
            ],

			'answer_analito' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
				'null' => false,
            ],

			'id_responsible' => [
                'type'       => 'INT',
                'constraint' => 11,
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
        $this->forge->createTable('crm_results');
		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->forge->dropTable('crm_results');
	}
}
