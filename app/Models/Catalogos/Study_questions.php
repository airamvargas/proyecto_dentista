<?php

/* Desarrollador: Giovanni Zavala Cortes
Fecha de creacion:30/08/2023
Fecha de Ultima Actualizacion: 30/08/2023 
Perfil: Administrador
Descripcion: Catalogo de asignacion de preguntas al estudio */

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class Study_questions extends Model{
    protected $table      = 'study_x_questions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_question', 'id_study', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getQuestionStudy($id){
        return $this->asArray()
        ->select('study_x_questions.id,questions.question,insumos.name')
        ->join('insumos', 'insumos.id = study_x_questions.id_study')
        ->join('questions', 'questions.id = study_x_questions.id_question')
        ->where('study_x_questions.id_study',$id)->findAll();
    }  

    public function questionStudies($ids){
        return $this->asArray()->select('questions.id,questions.question,questions.type,study_x_questions.id_study')->distinct()
        ->join('questions','study_x_questions.id_question = questions.id','left')
        ->whereIn('study_x_questions.id_study',$ids)->find();      
    }
}

?>