<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TipoMuestra extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
				'null' => false,
            ],
			'description' => [
                'type'       => 'TEXT',
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
        $this->forge->createTable('sample_types');
	}

	public function down()
	{
		$this->forge->dropTable('sample_types');
	}
}
