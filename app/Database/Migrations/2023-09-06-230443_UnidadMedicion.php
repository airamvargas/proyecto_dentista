<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UnidadMedicion extends Migration
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

			'prefix' => [
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
        $this->forge->createTable('crm_cat_measurement_units');
		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->forge->dropTable('crm_cat_measurement_units');
	}
}
