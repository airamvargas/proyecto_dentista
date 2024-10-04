<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ranges extends Migration
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
            'id_exam' => [
                'type'       => 'INT',
                'constraint' => 11,
				'null' => false,
            ],
			'id_gender' => [
                'type'       => 'INT',
				'constraint' => 11,
				'null' => false,
            ],
			'id_age_range' => [
                'type'       => 'INT',
				'constraint' => 11,
				'null' => false,
            ],
			'id_age_range' => [
                'type'       => 'INT',
				'constraint' => 11,
				'null' => false,
            ],
			'min' => [
                'type'       => 'VARCHAR',
				'constraint' => '255',
				'null' => false,
            ],
			'max' => [
                'type'       => 'VARCHAR',
				'constraint' => '255',
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
        $this->forge->createTable('crm_ranges');
	}

	public function down()
	{
		$this->forge->dropTable('crm_ranges');
	}
}
