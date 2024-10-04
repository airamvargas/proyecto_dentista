<?php 

namespace App\Controllers\Api\HCV\Operativo;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\HCV\Operativo\Nota_medica\Nota_odontologia as model;
use DateTime;

class Nota_odontologia extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct() { //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }

    //Obtener datos de la nota psicologica del paciente
    public function show($id = null){
        $id_folio = $_POST['id_cita'];

        $data = $this->model->select('*')->where('id_folio', $id_folio)->find();

        return $this->respond($data);
    }
    
    //GUARDAR NOTA MEDICA PSICOLOGICA
    public function create(){
        $request = \Config\Services::request();
        $id_folio = $request->getPost('id_cita');

        $count =  $this->model->selectCount('id_folio')->where('id_folio', $id_folio)->findAll();
    
        if($count[0]['id_folio'] > 0){
            $id = $this->model->select('id')->where('id_folio', $id_folio)->find();

            $data = [
                'marcha' => $request->getPost('marcha'),
                'mov_anormales' => $request->getPost('mov_anormales'),
                'facies' => $request->getPost('facies'),
                'complexion' => $request->getPost('complexion'),
                'posicion' => $request->getPost('posicion'),
                'cuidado_personal' => $request->getPost('personal'),
                'cara' => $request->getPost('cara'),
                'craneo' => $request->getPost('craneo'),
                'cuello' => $request->getPost('cuello'),
                'nariz' => $request->getPost('nariz'),
                'oidos' => $request->getPost('oidos'),
                'ojos' => $request->getPost('ojos'),
                'lesion' => $request->getPost('lesiones'),
                'localizacion' => $request->getPost('localizacion'),
                'forma' => $request->getPost('forma'),
                'color' => $request->getPost('color'),
                'superficie' => $request->getPost('superficie'),
                'bordes' => $request->getPost('bordes'),
                'consistencia' => $request->getPost('consistencia'),
                'base' => $request->getPost('base'),
                'tiempo_evolucion' => $request->getPost('tiempo_evol'),
                'cepillado' => $request->getPost('cepillado'),
                'hilo_dental' => $request->getPost('hilo_dental'),
                'enjuague' => $request->getPost('enjuague'),
                'succion' => $request->getPost('succion'),
                'deglucion_atipica' => $request->getPost('deglucion'),
                'respirador_bucal' => $request->getPost('respirador'),
                'alteraciones' => $request->getPost('alteraciones'),
                'dolor' => $request->getPost('dolor'),
                'dificultad_incapacidad' => $request->getPost('dificultad'),
                'ruidos' => $request->getPost('ruidos'),
                'desviacion' => $request->getPost('desviacion'),
                'edema' => $request->getPost('edema'),
            ];

            $this->model->update($id[0]['id'], $data);
            //retun affected rows into database
            $affected_rows = $this->db->affectedRows();
            $mensaje = messages($update = 1, $affected_rows);
        } else {
            $data = [
                'marcha' => $request->getPost('marcha'),
                'mov_anormales' => $request->getPost('mov_anormales'),
                'facies' => $request->getPost('facies'),
                'complexion' => $request->getPost('complexion'),
                'posicion' => $request->getPost('posicion'),
                'cuidado_personal' => $request->getPost('personal'),
                'cara' => $request->getPost('cara'),
                'craneo' => $request->getPost('craneo'),
                'cuello' => $request->getPost('cuello'),
                'nariz' => $request->getPost('nariz'),
                'oidos' => $request->getPost('oidos'),
                'ojos' => $request->getPost('ojos'),
                'lesion' => $request->getPost('lesiones'),
                'localizacion' => $request->getPost('localizacion'),
                'forma' => $request->getPost('forma'),
                'color' => $request->getPost('color'),
                'superficie' => $request->getPost('superficie'),
                'bordes' => $request->getPost('bordes'),
                'consistencia' => $request->getPost('consistencia'),
                'base' => $request->getPost('base'),
                'tiempo_evolucion' => $request->getPost('tiempo_evol'),
                'cepillado' => $request->getPost('cepillado'),
                'hilo_dental' => $request->getPost('hilo_dental'),
                'enjuague' => $request->getPost('enjuague'),
                'succion' => $request->getPost('succion'),
                'deglucion_atipica' => $request->getPost('deglucion'),
                'respirador_bucal' => $request->getPost('respirador'),
                'alteraciones' => $request->getPost('alteraciones'),
                'dolor' => $request->getPost('dolor'),
                'dificultad_incapacidad' => $request->getPost('dificultad'),
                'ruidos' => $request->getPost('ruidos'),
                'desviacion' => $request->getPost('desviacion'),
                'edema' => $request->getPost('edema'),
                'id_patient' => $request->getPost('id_paciente'),
                'id_folio' => $request->getPost('id_cita'),
                'id_medico' => $request->getPost('id_medico'),
            ];            
            $id = $this->model->insert($data);
            $mensaje = messages($insert = 0, $id);
        }
        return $this->respond($mensaje);  
    }

    //Insertar procedimientos/cirugia
    public function createProcedimiento() {
        $request = \Config\Services::request();
        $model_procedimientos = model('App\Models\HCV\Administrativos\Model_mini_procedimiento');
        $name_proce = $model_procedimientos->select('common_name')->where('id', $request->getPost('id_cat_procedimiento'))->find();

        $data = [
            'id_cat_alergia' => $request->getPost('id_cat_procedimiento'),
            'name' => $name_proce[0]['common_name'],
            'user_id' =>$request->getPost('user_id')
        ];

        $id = $this->$model_procedimientos->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);
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
}