<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Identityuserempresas extends Migration
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
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
				'null' => false,
            ],
			'name' => [
                'type'       => 'VARCHAR',
				'constraint' => '250',
				'null' => false,
            ],
			'first_name' => [
                'type'       => 'VARCHAR',
				'constraint' => '250',
				'null' => false,
            ],
			'second_name' => [
                'type'       => 'VARCHAR',
				'constraint' => '250',
				'null' => false,
            ],
			'phone' => [
                'type'       => 'VARCHAR',
				'constraint' => '15',
				'null' => false,
            ],
			'photo' => [
                'type'       => 'VARCHAR',
				'constraint' => '20',
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
        $this->forge->createTable('identity_bussiness');
	}

	public function down()
	{
		$this->forge->dropTable('questions');
	}
}
