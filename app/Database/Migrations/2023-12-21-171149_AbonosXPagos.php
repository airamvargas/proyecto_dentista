<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AbonosXPagos extends Migration
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
            'id_abono' => [
                'type'       => 'INT',
                'constraint' => 11,
				'null' => false,
            ],
			'id_payment' => [
                'type'       => 'INT',
                'constraint' => 11,
				'null' => false,
            ],
			'monto' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
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
        $this->forge->createTable('crm_abonos_x_pagos');
	}

	public function down()
	{
		//
	}
}
