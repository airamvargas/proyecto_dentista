<?php

namespace App\Models\Catalogos\Laboratorio;

use CodeIgniter\Model;

class Preguntas extends Model{
    protected $table = 'questions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['question', 'type_name', 'type', 'created_at','updated_at','deleted_at'];
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

   /*  public function getQuestions(){
        return $this->asArray()
            ->select('values_x_question.id AS id_value_question, questions.question, questions.type_name, questions.type, values_x_question.id_questions, values_x_question.name, values_x_question.deleted_at')
            ->join('values_x_question', 'values_x_question.id_questions = questions.id', 'left')
            ->where('values_x_question.deleted_at', '0000-00-00 00:00:00')
            ->findAll();
    } */

    //Join de los checkbox correspondientes al id de pregunta si tiene
    public function getQuestionType($id_question){
        return $this->asArray()
            ->select('values_x_question.id AS id_value_question, questions.question, questions.type_name, questions.id as id_pregunta, questions.type, values_x_question.id_questions, values_x_question.name')
            ->join('values_x_question', 'values_x_question.id_questions = questions.id', 'left')
			->where('questions.id', $id_question)
            //->where('values_x_question.deleted_at', '0000-00-00 00:00:00')
			->findAll();
    }

    //busqueda por nombre
    public function searchQuestions($busqueda){
        return $this->asArray()
        ->select('questions.id,questions.question')
        ->like('questions.question', $busqueda)
        ->findAll(50);
    }


  

    


}
