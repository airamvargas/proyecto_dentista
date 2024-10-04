<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdPayments extends Migration
{
	public function up()
	{
		$fields = [
			'pending' => [
				'type'       => 'BOOLEAN',
				'after' => 'amount',
			],

		];
		$this->forge->addColumn('payments',$fields);
	}
	

	public function down()
	{
		$this->forge->dropColumn('payments', 'pending');
	}
}
