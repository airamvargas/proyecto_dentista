<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Abonosindividuales extends Migration
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
            'id_company' => [
                'type'       => 'INT',
                'constraint' => 11,
				'null' => false,
            ],
			'abono' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
				'null' => false,
            ],
			'concepto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
				'null' => false,
            ],
			'c_fecha' => [
                'type'       => 'DATETIME',
				'null' => false,
            ],
			'medio_pago' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->createTable('crm_abonosIndividuales');
	}

	public function down()
	{
		//this->forge->dropTable('crm_abonosIndividuales');
	}
}
