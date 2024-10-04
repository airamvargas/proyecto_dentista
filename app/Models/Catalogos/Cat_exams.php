<?php

/* Desarrollador: Airam Vargas
Fecha de creacion:
Fecha de Ultima Actualizacion: 08 - 09 -2023 por Airam Vargas
Perfil: Administrador
Descripcion: Cátalogo de tipos de analitos */

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class Cat_exams extends Model{
    protected $table      = 'cat_exams';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'description', 'id_crm_cat_methods', 'id_crm_cat_age_range', 'id_crm_cat_measurement_units', 'reference_value', 'result', 'id_agrupador', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function readExams($sql_data){
        return $this->db->query($sql_data)->getResult();
    }

    public function readExam($id){
        return $this->asArray()
		->select('*')
        ->where('id', $id)
		->findAll();
    }

    public function readExamAuto($busqueda){
        return $this->asObject()
        ->select('id, name')
        ->like('name', $busqueda)    
        ->like("deleted_at","0000-00-00 00:00:00")
        ->findAll(100);
    }

    //Obtenemos el nombre y el metodo del analito
    public function nombreAnalito($id_analito){
        return $this->asArray()
        ->select('cat_exams.name AS analito, crm_cat_methods.name AS metodo, result, crm_cat_measurement_units.prefix, crm_grouper.name AS agrupador')
        ->join('crm_cat_methods', 'crm_cat_methods.id = cat_exams.id_crm_cat_methods')
        ->join('crm_cat_measurement_units', 'crm_cat_measurement_units.id = cat_exams.id_crm_cat_measurement_units')
        ->join('crm_grouper', 'crm_grouper.id = cat_exams.id_agrupador', 'left')
        ->where("cat_exams.id", $id_analito)
        ->find();
    }

    public function nameAnalito($id_analito){
        return $this->asArray()
        ->select('cat_exams.name AS analito')
        ->where("cat_exams.id", $id_analito)
        ->find();
        
    }

    

   
}

?>