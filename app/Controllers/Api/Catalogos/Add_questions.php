<?php 

namespace App\Controllers\Api\Catalogos;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use VARIANT;

helper('Acceso');

class Add_questions extends ResourceController 
{
    use ResponseTrait;
    var $db;
    var $studyques;

    public function __construct()
    {
        //Assign global variables
        $this->db = db_connect();
        $this->studyques = new \App\Models\Catalogos\Study_questions();
        helper('messages');
    }
    
     //show data on tables
     public function index() {
        $id = $_POST['id'];
        $data['data'] = $this->studyques->getQuestionStudy($id); 
        return $this->respond($data); 
    }

    //insert de la prefunta por estudio
    public function create(){
        $id_question = $_POST['id_question'];
        $id_study = $_POST['id_study'];
        $validate = $this->studyques->asArray()->where('id_question',$id_question)->where('id_study',$id_study)->findAll();
        //validamos si existe la pregunta 
        if(count($validate) == 0){
            $data = [
                'id_question'=> $_POST['id_question'],
                'id_study' => $_POST['id_study']
            ];
            $id = $this->studyques->insert($data);
            if($id){
                $data = [
                    "status" => 200,
                    "msg" => "AGREGADO CON EXITO"
                ];
                return $this->respond($data);
            }else{
                $data = [
                    "status" => 400,
                    "msg" => "ERROR EN EL SERVIDOR"
                ];
                return $this->respond($data);
            } 
        }else{
            $data = [
                "status" => 400,
                "msg" => "LA PREGUNTA YA ESTA ASIGNADA AL ESTUDIO"
            ];
            return $this->respond($data);
        }    
    } 

    //eliminacion de la pregunta
    public function deleteQuestion(){
        $id = $_POST['id_delete'];
        $this->studyques->delete($id);
        $affected_rows = $this->db->affectedRows();
        if($affected_rows > 0){
            $data = [
                "status" => 200,
                "msg" => "ELIMINADO CON EXITO"
            ];
        }else{
            $data = [
                "status" => 400,
                "msg" => "OCURRIO UN ERROR INTENTALO MÁS TARDE"
            ];
        }
        
        return $this->respond($data);
    }
}