<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Preguntas extends Migration
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
            'question' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
				'null' => false,
            ],
			'type' => [
                'type'       => 'TINYINT',
				'constraint' => '1',
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
        $this->forge->createTable('questions');
	}

	public function down()
	{
		$this->forge->dropTable('questions');
	}
}
