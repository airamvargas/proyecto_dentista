<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SamplesDeliveries extends Migration
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
            'id_cita' => [
                'type'       => 'INT',
                'constraint' => 11,
				'null' => false,
            ],
			'temperature' => [
                'type'       => 'VARCHAR',
				'constraint' => 250,
				'null' => false,
            ],
			'type' => [
                'type'       => 'VARCHAR',
				'constraint' => 250,
				'null' => false,
            ],
			'id_recolector' => [
                'type'       => 'INT',
				'constraint' => 11,
				'null' => false,
            ],
			'name_recolector' => [
                'type'       => 'VARCHAR',
				'constraint' => '255',
				'null' => false,
            ],
			'id_entrega' => [
                'type'       => 'VARCHAR',
				'constraint' => '255',
				'null' => false,
            ],

			'name_entrega' => [
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
        $this->forge->createTable('samples_deliveries');
	}

	public function down()
	{
		$array =  array('medic_referido','tel_medic','correo');
		$this->forge->dropColumn('cotization',$array);
	}
}
