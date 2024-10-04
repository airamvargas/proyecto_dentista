<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ValuesQuestions extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();
		$this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
				'null' => false,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
				'null' => false,
            ],

			'id_questions' => [
                'type'       => 'INT',
                'constraint' => 11,
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
		$this->forge->addForeignKey('id_questions', 'questions', 'id');
        $this->forge->createTable('values_x_question');
		$this->db->enableForeignKeyChecks();
		
	}

	public function down()
	{
		$this->forge->dropTable('values_x_questiony');
	}
}
