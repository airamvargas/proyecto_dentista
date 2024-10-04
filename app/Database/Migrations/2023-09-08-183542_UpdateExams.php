<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateExams extends Migration
{
	public function up()
	{
		$fields = [
			'id_crm_cat_methods' => [
				'type'       => 'INT',
				'after' => 'description',
			],

			'id_crm_cat_age_range' => [
				'type'       => 'INT',
				'after' => 'id_crm_cat_methods',
			],

			'id_crm_cat_measurement_units' => [
				'type'       => 'INT',
				'after' => 'id_crm_cat_age_range',
			],

			'reference_value' => [
				'type'       => 'VARCHAR',
                'constraint' => '500',
				'null' => false,
				'after' => 'id_crm_cat_measurement_units',
			],

			'result' => [
				'type'       => 'VARCHAR',
                'constraint' => '500',
				'null' => false,
				'after' => 'reference_value',
			],

		];
		$this->forge->addColumn('cat_exams',$fields);
	}

	public function down()
	{
		$array =  array('id_crm_cat_methods','id_crm_cat_age_range','id_crm_cat_measurement_units,','reference_value',
	'result');
		$this->forge->dropColumn('cat_exams',$array);
	}
}
