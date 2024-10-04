<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateCatStudies extends Migration
{
	public function up()
	{
		$fields = [
			'n_labels' => [
				'type'       => 'INT',
				'after' => 'sample_volume',
			],

		];
		$this->forge->addColumn('cat_studies',$fields);
	}

	public function down()
	{
		$this->forge->dropColumn('cat_studies', 'n_labels');
	}
}
