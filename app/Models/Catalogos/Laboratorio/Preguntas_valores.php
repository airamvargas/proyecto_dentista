<?php

namespace App\Models\Catalogos\Laboratorio;

use CodeIgniter\Model;

class Preguntas_valores extends Model{
    protected $table = 'values_x_question';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'id_questions', 'created_at','updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Consulta para mostrar en el datatable las preguntas registradas
    public function getQuestions(){
        return $this->asArray()
			->findAll();
    }

    // Consulta para obtener los datos a imprimir en el modal de editar
    public function getQuestionType($id_question){
        return $this->asArray()
			->where('id', $id_question)
			->find();
    }

    public function getValues($id_question){
        return $this->asArray()
        ->where('id_questions', $id_question)
        ->findAll();

    }

    public function valuesQuestions($ids){
       return $this->asArray()->select('values_x_question.name,values_x_question.id_questions')
       ->whereIn('values_x_question.id_questions',$ids)->find();  
    }
}
