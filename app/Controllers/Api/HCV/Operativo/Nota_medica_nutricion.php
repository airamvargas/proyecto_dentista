<?php 
namespace App\Controllers\Api\HCV\Operativo;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\HCV\Paciente\registro_medico\Nutricion as model;
use DateTime;

class Nota_medica_nutricion extends ResourceController {
    use ResponseTrait;
    var $model;
    var $procedimientos_x_cita;
    var $db;

    public function __construct(){
        //Assign global variables
        $this->model = new model();
        $this->procedimientos_x_cita = new \App\Models\Citas\Procedimientos();
        $this->db = db_connect();
        helper('messages');
    }

    //Obtener datos del paciente para la nota medica
    public function readPaciente(){
        $model_identity = model('App\Models\HCV\Paciente\Ficha_identificacion_paciente');
        $id_paciente = $_POST['id_paciente'];        
        $id = $model_identity->getDatos($id_paciente);

        //Se calcula la edad del paciente para mostrar
        $nacimiento = new DateTime($id[0]['BIRTHDATE']);
        $fecha_actual = new DateTime(); 
        $edad = $fecha_actual->diff($nacimiento); 

        //Variables
        $data['nombre'] = $id[0]['NAME']." ".$id[0]['F_LAST_NAME']." ".$id[0]['S_LAST_NAME'];
        $data['genero'] = $id[0]['SEX'];
        $data['edad'] = $edad->format("%y");

        return $this->respond($data); 
    }

    /**************************************
     * PESTAÑA DE NUTRICION
     **************************************/
    //GUARDAR NOTA MEDICA DE NUTRICION
    public function create() {
        $request = \Config\Services::request();        
        $id_folio = $request->getPost('id_folio');

        //Ver si existe una nota de nutricion con ese folio
        $count = $this->model->notaNutricion($id_folio);

        if($count[0]['id_folio'] > 0){ //si existe una nota con ese id de cita se actualiza
            $id = $this->model->getIdNota($id_folio);

            $data = [
                'nota'=> $request->getPost('nota_Nutricion'),
                'cintura' => $request->getPost('Cintura'), 
                'cadera' => $request->getPost('Cadera'),
                'pantorrilla' => $request->getPost('Pantorrilla'),
                'masa_muscular' => $request->getPost('Masa_muscular'),
                'grasa_corporal' => $request->getPost('Grasa_corporal'),
                'grasa_visceral' => $request->getPost('Grasa_visceral'),
                'agua_corporal' => $request->getPost('Agua_corporal'),
                'tasa_metabolica' => $request->getPost('Tasa_metabolica'),
                'edad_metabolica' => $request->getPost('Edad_metabolica'),
                'peso' => $request->getPost('Peso'),
                'talla' => $request->getPost('Talla'),
                'imc' => $request->getPost('IMC')                
            ];
            $this->model->update($id[0]['id'], $data);
            //retun affected rows into database
            $affected_rows = $this->db->affectedRows();
            $mensaje = messages($update = 1, $affected_rows);
        }else{ //si no hay datos se crea nueva nota medica
            $data = [
                'nota'=> $request->getPost('nota_Nutricion'),
                'cintura' => $request->getPost('Cintura'), 
                'cadera' => $request->getPost('Cadera'),
                'pantorrilla' => $request->getPost('Pantorrilla'),
                'masa_muscular' => $request->getPost('Masa_muscular'),
                'grasa_corporal' => $request->getPost('Grasa_corporal'),
                'grasa_visceral' => $request->getPost('Grasa_visceral'),
                'agua_corporal' => $request->getPost('Agua_corporal'),
                'tasa_metabolica' => $request->getPost('Tasa_metabolica'),
                'edad_metabolica' => $request->getPost('Edad_metabolica'),
                'peso' => $request->getPost('Peso'),
                'talla' => $request->getPost('Talla'),
                'imc' => $request->getPost('IMC'),
                'id_folio' => $request->getPost('id_folio'),
                'patient_id' => $request->getPost('id_patient'),
                'operativo_id' => $request->getPost('id_doctor')
            ];
            $id = $this->model->insert($data);
            $mensaje = messages($insert = 0, $id);
        }
        return $this->respond($mensaje);
    }
    
    //Obtener los datos de la nota medica de nutricion del paciente
     public function readNutricion(){
        $id_folio = $_POST['id_cita'];
        $data = $this->model->getNota($id_folio);
        return $this->respond($data);
    }  

    /*******************************************
     * PESTAÑA DE DIAGNOSTICO NUTRICIONAL
     *******************************************/
    // Select con el catalogo de tipo de diagnostico
    public function readDiagnostico(){
        $request = \Config\Services::request();
        $model_diagnostico = model('App\Models\HCV\Paciente\registro_medico\Diagnostico_nutricional');        
        $data = $model_diagnostico->hcv_cat_diagnostic();
        echo json_encode($data); 
    }

    // Select con el catalogo de ingesta por id seleccionado de diagnostico
    public function readIngesta($id){
        $request = \Config\Services::request();
        $model_ingesta = model('App\Models\HCV\Paciente\registro_medico\Diagnostico_nutricional');   
        $data = $model_ingesta->get_type_ingesta($id);
        echo json_encode($data); 
    }

    //Select con catalogo de nutricion 1
    public function get_type_nutricional_indice1($id){
        $request = \Config\Services::request();
        $model_alimentacion = model('App\Models\HCV\Paciente\registro_medico\Diagnostico_nutricional');  
        $data = $model_alimentacion->get_type_n($id);
        echo json_encode($data);
    }

    // Select con catalogo de nutricion 2
    public function get_type_nutricional_indice2($id){
        $request = \Config\Services::request();
        $model_indice2 = model('App\Models\HCV\Paciente\registro_medico\Diagnostico_nutricional');
        $data = $model_indice2->get_type_n_i2($id);
        echo json_encode($data);
    } 

    //GUARDAR NOTA MEDICA DE DIAGNOSTICO NUTRICIONAL
    public function createDiagnostico() {
        $request = \Config\Services::request();
        $model_nutricional = model('App\Models\HCV\Paciente\registro_medico\Diagnostico_nutricional'); 
        $folio = $request->getPost('id_folio');
        $tipo = $request->getPost('diagnostico');
        $balance = $request->getPost('ingesta');
        $grasa = $request->getPost('alimentacion');
        $ingesta = $request->getPost('ingestas');
        

        if($request->getPost('ingestas') == NULL){
            $confirm = $model_nutricional->registroRep($folio, $tipo, $balance, $grasa);
        } else {
            $confirm = $model_nutricional->registroRepetido($folio, $tipo, $balance, $grasa, $ingesta);
        }

        if($confirm[0]->total > 0){
            $respuesta = [
              "status" => 400,
              "msg" => "DIAGNÓSTICO NUTRICIONAL DUPLICADO"
            ]; 
            return $this->respond($respuesta);
        }else{ 
            $data = [
                'tipo'=> $request->getPost('diagnostico'),
                'balance' => $request->getPost('ingesta'), 
                'grasa' => $request->getPost('alimentacion'),
                'ingesta' => $request->getPost('ingestas'),            
                'id_folio' => $request->getPost('id_folio'),
                'patient_id' => $request->getPost('id_patient'),
                'operativo_id' => $request->getPost('id_doctor')
            ];
            $id = $model_nutricional->insert($data);
            
            $mensaje = messages($insert = 0, $id);
            return $this->respond($mensaje); 
        }
    }

    // Mostrar en la tabla los registros de los select seleccionados en la tabla
    public function readNutricional(){  
        $request = \Config\Services::request(); 
        $model_datos = model('App\Models\HCV\Paciente\registro_medico\Diagnostico_nutricional'); 
        //data from the datatable       
        $id_folio = $_POST['id_folio'];
        $data['data'] = $model_datos->get_table_diagnostico_nutricional($id_folio);
        return $this->respond($data);        
    } 

     //delete diagnostico nutricional
     public function delete_(){        
        $request = \Config\Services::request();
        $diagnostico = model('App\Models\HCV\Paciente\registro_medico\Diagnostico_nutricional'); 
        $id = $request->getVar("id_delete");
        $diagnostico->delete($id);
        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($detele = 2, $affected_rows);
        return $mensaje;
    } 


    //Terminar cita
    public function terminarCita(){
        $request = \Config\Services::request();
        $model_citas = model('App\Models\Agendas\Appointment_schedule');

        $count =  $this->model->selectCount('id_folio')->where('id_folio', $request->getPost('id'))->findAll();
        
        if($count[0]['id_folio'] > 0){
            $id = $model_citas->select('id')->where('id_cita', $request->getPost('id'))->findAll();
            
            $data = [
                'approved' => 3
            ];

            $model_citas->update($id[0]['id'], $data);
            $affected_rows = $this->db->affectedRows();

            if($affected_rows){
                $data = [
                    "status" => 200,
                    "msg" => "CITA TERMINADA CON EXITO"
                ];
            } else {
                $data = [
                    "status" => 400,
                    "msg" => "HUBO UN ERROR INTENTALO MÁS TARDE"
                ];
            }
        } else {
            $data = [
                "status" => 400,
                "msg" => "AUN FALTAN DATOS POR GUARDAR"
            ];
        }

        return $this->respond($data);
    }

    /**************************************
     * PESTAÑA DE PROCEDIMIENTOS
     **************************************/
    //Insertar procedimientos/cirugia
    public function createProcedimiento() {
        $request = \Config\Services::request();
        $model_procedimientos = model('App\Models\Catalogos\Tipos_procedimientos');
        $name_proc = $model_procedimientos->select('commun_name')->where('id', $request->getPost('id_cat_procedimiento'))->find()[0]['commun_name'];

        $data = [
            'id_mini_procedimiento' => $request->getPost('id_cat_procedimiento'),
            'name_procedimiento' => $name_proc,
            'id_cita' => $request->getPost('id_folio')
        ];
        $id = $this->procedimientos_x_cita->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);
    }


    public function getProcedimiento(){
        $request = \Config\Services::request();
        $model_procedimientos = model('App\Models\Model_Citas_x_Mini_procedimientos');
    }

    public function showProcedimientos(){
        $id_folio = $_POST['id_folio'];
        $data['data'] = $this->procedimientos_x_cita->getProcediemintos($id_folio);
        return $this->respond($data);
    }

    //Eliminar procedimiento
    public function deleteProcedimiento() {
        $request = \Config\Services::request();
        $id = $request->getPost('id_delete');
        
        $this->procedimientos_x_cita->delete($id);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje;
    }

  
    
}