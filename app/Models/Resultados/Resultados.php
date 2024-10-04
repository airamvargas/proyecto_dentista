<?php

namespace App\Models\Resultados;

use CodeIgniter\Model;

class Resultados extends Model{
    protected $table = 'crm_results';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_cita', 'id_study', 'name_study', 'id_analito', 'name_analito', 'agrupador','answer_analito', 'id_responsible', 'edad', 'name_paciente', 'sex','tipo_muestra', 'metodo', 'question_type', 'operator', 'referencia_min', 'referencia_max', 'unit_of_measure', 'documento', 'success', 'bandera','created_at','updated_at','deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    //Resultados del estudio paciente 
    public function getResultado($id_cita){
        $sql = "select crm_results.*, (SELECT insumos.name from insumos where insumos.id = citas.id_study ) as nombre_estudio, (SELECT medic_referido FROM cotization where cotization_x_products.id_cotization
        = cotization.id) AS medico, (SELECT name_unit FROM cotization where cotization_x_products.id_cotization = cotization.id) AS unidad from crm_results join citas on citas.id = crm_results.id_cita JOIN cat_exams ON cat_exams.id = crm_results.id_analito JOIN cotization_x_products ON 
        cotization_x_products.id = citas.id_cotization_x_product where crm_results.id_cita  = :id_cita:";
        $datos = $this->db->query($sql, ['id_cita' => $id_cita]);
        return $datos->getResult();
    }

    public function getResultados($id_cita){
        return $this->asObject()->where('id_cita', $id_cita)->findAll();
    }

    public function getMetodo($id_cita){
        $sql = "SELECT distinct(metodo) FROM crm_results ";
        $datos = $this->db->query($sql, ['id_cita' => $id_cita]);
        return $datos->getResult(); 
    }

    public function getAgrupador($id_cita){
        $sql = "SELECT distinct(agrupador) FROM crm_results ";
        $datos = $this->db->query($sql, ['id_cita' => $id_cita]);
        return $datos->getResult(); 
    }

   

}
