<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StudiesQuestions extends Migration
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
            'id_question' => [
                'type'       => 'INT',
                'constraint'     => 11,
				'null' => false,
            ],
			'id_study' => [
                'type'       => 'INT',
				'constraint'     => 11,
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
        $this->forge->createTable('study_x_questions');
	}

	public function down()
	{
		$this->forge->dropTable('study_x_questions');
	}
}
