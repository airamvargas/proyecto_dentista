<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class Products_x_unit extends Model{
    protected $table      = 'exams_x_study';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_study', 'id_exam', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function show($id){
        $sql = "SELECT exams_x_study.id, (SELECT name FROM insumos WHERE name_table LIKE '%cat_studies%' AND insumos.id_product = :study:) 
        AS study, cat_exams.name AS exam FROM exams_x_study JOIN cat_exams ON cat_exams.id = exams_x_study.id_exam  
        WHERE exams_x_study.id_study = :study: AND exams_x_study.deleted_at = '0000-00-00 00:00:00'";
        $datos = $this->db->query($sql, ['study' => $id]);
        return $datos->getResult();
    }

    public function repetidos($id_study, $id_exam){
        $sql = "SELECT COUNT(*) AS repetido FROM exams_x_study WHERE id_study = :study: AND id_exam = :exam: AND deleted_at = '0000-00-00 00:00:00'";
        $datos = $this->db->query($sql, ['study' => $id_study, 'exam' => $id_exam]);
        return $datos->getResult();
    }

    //obtenemos los analitos por estudio
    public function getAnalitos($id_study,$ids){
        return $this->asArray()
        ->select('cat_exams.name, cat_exams.id,cat_exams.result')
        ->join('cat_exams', 'cat_exams.id = exams_x_study.id_exam')
        ->whereIn('exams_x_study.id_exam',$ids)
        ->where('id_study',$id_study)
        ->findall();
    }    

    public function getAnalito($id_study){
        return $this->asArray()
        ->select('cat_exams.id, cat_exams.name, cat_exams.result')
        ->join('cat_exams', 'cat_exams.id = exams_x_study.id_exam')
        ->where('id_study', $id_study)
        ->where('cat_exams.deleted_at', '0000-00-00 00:00:00')
        ->findAll();
    }
}

?>