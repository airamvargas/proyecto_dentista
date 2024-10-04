<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Contenedores extends Migration
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
                'type'       => 'VARCHAR',
                'constraint' => '250',
				'null' => false,
            ],
			'measure' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
				'null' => true,
            ],
			'measurement value' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
				'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('containers');
    }
	

	public function down()
	{
		$this->forge->dropTable('containers');
	}
}
