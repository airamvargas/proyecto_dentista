<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProcedimientosCitas extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();
		$this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_hcv_specialtytype' => [
                'type'       => 'INT',
                'constraint' => 11,
				'null' => false,
            ],
            'name_hcv_specialtytype' => [
                'type' => 'VARCHAR',
				'constraint' => 250,
                'null' => false,
            ],

			'id_hcv_cat_procedimientos' => [
                'type'       => 'INT',
                'constraint' => 11,
				'null' => false,
            ],
			'name_hcv_cat_procedimientos' => [
                'type' => 'VARCHAR',
				'constraint' => 250,
                'null' => false,
            ],
			'commun_name' => [
                'type' => 'VARCHAR',
				'constraint' => 250,
                'null' => false,
            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('appointments_procedures');
		//$this->forge->addForeignKey('id_hcv_specialtytype', 'hcv_specialtytype','id');
		//this->forge->addForeignKey('id_hcv_cat_procedimientos', 'hcv_cat_procedimientos','id');
		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->forge->dropTable('appointments_procedures');
	}
}
