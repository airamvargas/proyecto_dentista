<?php
/*
Desarrollador: Airam Valeria Vargas López
Fecha Creacion: 11 - 09 - 2023
Fecha de Ultima Actualizacion: 
Perfil: Administracion
Descripcion: Catalogo de los rangos de un analito, segun edades y genero 
*/

namespace App\Models\Catalogos\Laboratorio;

use CodeIgniter\Model;

class Cat_ranges_exam extends Model
{

    protected $table = 'crm_ranges';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_exam', 'id_gender', 'id_age_range', 'edad_minima', 'edad_maxima', 'operator', 'min', 'max', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function show($id_exam) {
        $sql = "SELECT id, operator, (SELECT name FROM crm_gender WHERE crm_gender.id = id_gender) AS genero, (SELECT CONCAT(min, ' - ', max) FROM crm_cat_age_range WHERE 
        crm_cat_age_range.id = id_age_range AND crm_cat_age_range.deleted_at = '0000-00-00 00:00:00') AS rango, edad_minima, edad_maxima, (SELECT CONCAT(min, ' - ', max) FROM crm_cat_age_range WHERE 
        crm_cat_age_range.id = id_age_range AND crm_cat_age_range.deleted_at = '0000-00-00 00:00:00') AS rango, min, max FROM crm_ranges WHERE 
        crm_ranges.deleted_at = '0000-00-00 00:00:00' AND id_exam = :id_exam:";
        $query = $this->db->query($sql, ['id_exam' => $id_exam]);
        return $query->getResult();
    }

    public function getValues($id) {
        return $this->asArray()
        ->where('id', $id)
        ->findAll();
    }

    public function get_Rangos($id_exam, $id_gender, $id_age)
    {
        $results =  $this->asArray()
            ->where('id_exam', $id_exam)
            ->where('id_gender', $id_gender)
            ->where('id_age_range', $id_age)
            ->findAll();
    }

    public function getResulText($id_exam, $id_gender, $edad){
        $sql = "SELECT crm_ranges.*,cat_exams.id as id_analito,cat_exams.id_crm_cat_methods,cat_exams.result,cat_exams.name,crm_cat_methods.name as metodo, 
        crm_cat_measurement_units.prefix as unidad, crm_grouper.name as agrupador FROM crm_ranges LEFT JOIN cat_exams ON cat_exams.id = 
        crm_ranges.id_exam LEFT JOIN crm_cat_methods ON crm_cat_methods.id  = cat_exams.id_crm_cat_methods JOIN crm_cat_measurement_units ON 
        crm_cat_measurement_units.id  = cat_exams.id_crm_cat_measurement_units LEFT JOIN crm_grouper ON crm_grouper.id  = cat_exams.id_agrupador WHERE
        crm_ranges.id_exam = :id_exam: AND crm_ranges.id_gender = :id_gender: AND $edad BETWEEN edad_minima AND edad_maxima AND crm_ranges.deleted_at IS NULL";
        $query = $this->db->query($sql, ['id_exam' => $id_exam, 'id_gender' => $id_gender, 'edad' => $edad]);
        return $query->getResult();
    }

    /*public function getResulText($id_exam, $id_gender, $id_age)
    {
        $results =  $this->getResults($id_exam, $id_gender, $id_age);

        if(empty($results)){
            $results =  $this->getResults($id_exam, $id_gender, 1);
        }

        return $results;
    }

    public function getResults($id_exam, $id_gender, $id_age){
        return $this->asArray()->select('crm_ranges.*,cat_exams.id as id_analito,cat_exams.id_crm_cat_methods,cat_exams.result,cat_exams.name,crm_cat_methods.name as metodo, crm_cat_measurement_units.prefix as unidad, crm_grouper.name as agrupador')
        ->join('cat_exams', 'cat_exams.id = crm_ranges.id_exam', 'left')
        ->join('crm_cat_methods', 'crm_cat_methods.id  = cat_exams.id_crm_cat_methods', 'left')
        ->join('crm_cat_measurement_units', 'crm_cat_measurement_units.id  = cat_exams.id_crm_cat_measurement_units', 'left')
        ->join('crm_grouper', 'crm_grouper.id  = cat_exams.id_agrupador', 'left')
        ->where('id_exam', $id_exam)
        ->where('id_gender', $id_gender)
        ->where('id_age_range', $id_age)
        ->findAll();
    }*/
    
    public function valoresAnalito($id_exam, $id_gender, $edad){
        $sql = "SELECT crm_ranges.*, cat_exams.id as id_analito, cat_exams.id_crm_cat_methods, cat_exams.result, cat_exams.name, crm_cat_methods.name as metodo, 
        crm_cat_measurement_units.prefix as unidad, crm_grouper.name as agrupador FROM crm_ranges LEFT JOIN cat_exams ON cat_exams.id = 
        crm_ranges.id_exam LEFT JOIN crm_cat_methods ON crm_cat_methods.id  = cat_exams.id_crm_cat_methods LEFT JOIN crm_cat_measurement_units ON
        crm_cat_measurement_units.id  = cat_exams.id_crm_cat_measurement_units LEFT JOIN crm_grouper ON crm_grouper.id  = cat_exams.id_agrupador WHERE
        id_exam = :id_exam: AND id_gender = :id_gender: AND $edad BETWEEN edad_minima AND edad_maxima AND crm_ranges.deleted_at IS NULL";
        $query = $this->db->query($sql, ['id_exam' => $id_exam, 'id_gender' => $id_gender, 'edad' => $edad]);
        return $query->getResult();
    }
    /*public function valoresAnalito($id_analito, $sex, $id_rango){
        $results =  $this->valores($id_analito, $sex, $id_rango);
        if(empty($results)){
            $results =  $this->valores($id_analito, $sex, 1);
        }
        
        return $results;
    }

    public function valores($id_analito, $sex, $id_rango) {
        return $this->asArray()->select('crm_ranges.*,cat_exams.id as id_analito,cat_exams.id_crm_cat_methods,cat_exams.result,cat_exams.name,crm_cat_methods.name as metodo, crm_cat_measurement_units.prefix as unidad, crm_grouper.name as agrupador')
        ->join('cat_exams', 'cat_exams.id = crm_ranges.id_exam', 'left')
        ->join('crm_cat_methods', 'crm_cat_methods.id  = cat_exams.id_crm_cat_methods', 'left')
        ->join('crm_cat_measurement_units', 'crm_cat_measurement_units.id  = cat_exams.id_crm_cat_measurement_units', 'left')
        ->join('crm_grouper', 'crm_grouper.id  = cat_exams.id_agrupador', 'left')
        ->where('id_exam', $id_analito)
        ->where('id_gender', $sex)
        ->where('id_age_range', $id_rango)
        ->findAll();

    }*/

    public function val_minima($edad_minima, $id_genero, $id_exam){
        $sql = "SELECT COUNT(id) AS val_min, id FROM crm_ranges WHERE :minima: BETWEEN edad_minima AND edad_maxima AND id_gender = :genero: AND id_exam = :id_exam: and deleted_at = :fecha:";
        $query = $this->db->query($sql, ['minima' => $edad_minima, 'genero' => $id_genero, 'id_exam' => $id_exam , 'fecha'=> '0000-00-00 00:00:00']);
        return $query->getResult();
    }

    public function val_maxima($edad_maxima, $id_genero, $id_exam){
        $sql = "SELECT COUNT(id) AS val_max, id FROM crm_ranges WHERE :maxima: BETWEEN edad_minima AND edad_maxima AND id_gender = :genero: AND id_exam = :id_exam: and deleted_at = :fecha:";
        $query = $this->db->query($sql, ['maxima' => $edad_maxima, 'genero' => $id_genero, 'id_exam' => $id_exam, 'fecha'=> '0000-00-00 00:00:00']);
        return $query->getResult();
    }

    
}
