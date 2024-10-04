<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Updatecitas extends Migration
{
	public function up()
	{
		{
			$fields = [
				'codigo' => [
					'type'       => 'VARCHAR',
					'constraint' => '255',
					'after' => 'id_business_unit',
				],
	
			];
			$this->forge->addColumn('citas',$fields);
		}
	}

	public function down()
	{
		$this->forge->dropColumn('citas', 'id_crm_gender');
	}
}
