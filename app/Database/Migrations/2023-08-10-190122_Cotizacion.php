<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cotizacion extends Migration
{
	public function up()
	{
		$fields = [
			'id_company_data' => [
				'type'       => 'INT',
				'constraint' => 11,
				'null' => false,
				'after' => 'show_cotization',
			],

			'name_conpany' => [
				'type'       => 'VARCHAR',
				'constraint' => 250,
				'null' => true,
				'after' => 'id_company_data',
			],

			'tel_conpany' => [
				'type'       => 'VARCHAR',
				'constraint' => 12,
				'null' => true,
				'after' => 'name_conpany',
			],
			'address' => [
				'type'       => 'VARCHAR',
				'constraint' => 250,
				'null' => true,
				'after' => 'tel_conpany',
			],
			'logo' => [
				'type'       => 'VARCHAR',
				'constraint' => 250,
				'null' => true,
				'after' => 'address',
			],

			'rfc' => [
				'type'       => 'VARCHAR',
				'constraint' => 250,
				'null' => true,
				'after' => 'logo',
			],

			'email' => [
				'type'       => 'VARCHAR',
				'constraint' => 250,
				'null' => true,
				'after' => 'rfc',
			],
		];

		$this->forge->addColumn('cotization',$fields);
	}

	public function down()
	{
		$array =  array('id_company_data','name_conpany','tel_conpany','address','logo','rfc','email');
		$this->forge->dropColumn('cotization',$array);
	}
}
