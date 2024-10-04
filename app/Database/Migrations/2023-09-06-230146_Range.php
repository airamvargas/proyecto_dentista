<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Range extends Migration
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
            'min' => [
                'type'       => 'INT',
                'constraint' => '5',
				'null' => false,
            ],
			'max' => [
				'type'       => 'INT',
                'constraint' => '5',
				'null' => false,
            ],
			'description' => [
				'type'       => 'VARCHAR',
                'constraint' => '100',
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
        $this->forge->createTable('crm_cat_age_range');
		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->forge->dropTable('crm_cat_age_range');
	}
}
