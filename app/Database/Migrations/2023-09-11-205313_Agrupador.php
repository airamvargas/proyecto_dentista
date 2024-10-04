<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Agrupador extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
				'null' => false,
            ],
			'description' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
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
        $this->forge->createTable('crm_grouper');
		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->forge->dropTable('crm_grouper');
	}
}
