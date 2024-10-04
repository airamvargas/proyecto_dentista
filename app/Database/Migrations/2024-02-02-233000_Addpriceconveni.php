<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addpriceconveni extends Migration
{
	public function up()
	{
		$fields = [
			'precio_convenio' => [
				'type'       => 'DECIMAL',
                'constraint' => '10,2',
				'null' => true,
				'after' => 'id_cat_conventions',
			],
		];	
		$this->forge->addColumn('cat_conventions_x_products', $fields);
	}

	public function down()
	{
		//$this->forge->dropColumn('cat_conventions_x_products', 'precio_convenio');
	}
}
