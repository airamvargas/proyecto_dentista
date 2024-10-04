<?php

namespace App\Controllers\Api\HCV\Operativo;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');

use App\Models\HCV\Operativo\Nota_medica\Nota_psicologia as model;
use App\Models\HCV\Paciente\registro_medico\Evidencia as evidencia;
use App\Models\Catalogos\Tipos_procedimientos as procedimientos;
use App\Models\Citas\Procedimientos as procedimientos_x_cita;
use DateTime;

class Nota_medica extends ResourceController
{
    use ResponseTrait;
    var $model;
    var $db;
    var $evidencia;
    var $procedimientos;
    var $procedimientos_x_cita;


    public function __construct()
    { //Assign global variables
        $this->model = new model();
        $this->evidencia = new evidencia();
        $this->procedimientos = new procedimientos();
        $this->procedimientos_x_cita = new procedimientos_x_cita();
        $this->db = db_connect();
        helper('messages');
    }

    //Obtener datos del paciente
    public function readPaciente()
    {
        $model_identity = model('App\Models\models_paciente\Identity');
        $id_paciente = $_POST['id_paciente'];

        $id = $model_identity->select('BIRTHDATE, SEX, PATH, NAME, F_LAST_NAME, S_LAST_NAME')->where('ID_USER', $id_paciente)->find();
        //var_dump($id_paciente);
        $nacimiento = new DateTime($id[0]['BIRTHDATE']);
        $ahora =  new DateTime();
        $diferencia = $ahora->diff($nacimiento);
        //Variables
        $data['nombre'] = $id[0]['NAME'] . " " . $id[0]['F_LAST_NAME'] . " " . $id[0]['S_LAST_NAME'];
        $data['genero'] = $id[0]['SEX'];
        $data['edad'] = $diferencia->format("%y");
        $data['imagen'] = $id[0]['PATH'];

        return $this->respond($data);
    }

    //GUARDAR NOTA MEDICA PSICOLOGICA
    public function create()
    {
        $request = \Config\Services::request();
        $id_folio = $request->getPost('id_folio');

        $count =  $this->model->selectCount('id_folio')->where('id_folio', $id_folio)->findAll();

        if ($count[0]['id_folio'] > 0) {
            $id = $this->model->select('id')->where('id_folio', $id_folio)->find();

            $data = [
                'tecnica' => $request->getPost('metodo_tecnica'),
                'tipo_abordaje' => $request->getPost('tipo_aborddaje'),
                'estado_emocional' => $request->getPost('edo_emocional'),
                'objectivo_consulta' => $request->getPost('objetivo'),
                'nota' => $request->getPost('nota_psci')
            ];

            $this->model->update($id[0]['id'], $data);
            //retun affected rows into database
            $affected_rows = $this->db->affectedRows();
            $mensaje = messages($update = 1, $affected_rows);
        } else {
            $data = [
                'tecnica' => $request->getPost('metodo_tecnica'),
                'tipo_abordaje' => $request->getPost('tipo_aborddaje'),
                'estado_emocional' => $request->getPost('edo_emocional'),
                'objectivo_consulta' => $request->getPost('objetivo'),
                'nota' => $request->getPost('nota_psci'),
                'id_patient' => $request->getPost('id_patient'),
                'id_folio' => $request->getPost('id_folio'),
                'id_medico' => $request->getPost('id_doctor')
            ];

            $id = $this->model->insert($data);
            $mensaje = messages($insert = 0, $id);
        }

        return $this->respond($mensaje);
    }

    //Obtener datos de la nota psicologica del paciente
    public function readNota()
    {
        $id_folio = $_POST['id_cita'];

        $data = $this->model->select('*')->where('id_folio', $id_folio)->find();

        return $this->respond($data);
    }

    //Insert procedimientos x consulta
    public function createProcedimiento()
    {
        $request = \Config\Services::request();
        $name_proc = $this->procedimientos->select('commun_name')->where('id', $request->getPost('id_cat_procedimiento'))->find();

        $data = [
            'id_mini_procedimiento' => $request->getPost('id_cat_procedimiento'),
            'name_procedimiento' => $name_proc[0]['commun_name'],
            'id_cita' => $request->getPost('id_folio')
        ];
        $id = $this->procedimientos_x_cita->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);
    }

    //Eliminar procedimiento
    public function deleteProcedimiento()
    {
        $request = \Config\Services::request();
        $id = $request->getPost('id_delete');

        $this->procedimientos_x_cita->delete($id);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje;
    }

    //Datatable de procedimientos
    public function showProcedimientos()
    {
        $id_folio = $_POST['id_cita'];

        $data['data'] = $this->procedimientos_x_cita->showProcedimientos($id_folio);

        return $this->respond($data);
    }

    //Insertar evidencia
    public function insertEvidencia()
    {
        $request = \Config\Services::request();
        $file = $this->request->getFile('file');
        $name_file = $file->getName();
        $global = [];
        $ext_val = array(
            "txt", "pdf", "csv", "jpeg", "jpg", "png", "docx", "pptx", "xls", "ods", "doc", "odt", "xlsx"
        );
        $extension = pathinfo($name_file, PATHINFO_EXTENSION);

        foreach ($ext_val as $key) {

            if ($key == $extension) {
                $env = 1;
                array_push($global, $env);
                $path = "uploads/paciente/nota_medica/";
                $file->move($path, $file->getName());
                // var_dump($name_file);
                $data = [
                    'name_foto' => $name_file,
                    'descripcion' => $request->getPost('descripcion'),
                    'patient_id' => $request->getPost('id_patient'),
                    'id_folio' => $request->getPost('id_folio'),
                    'operativo_id' => $request->getPost('id_doctor')
                ];

                $id = $this->evidencia->insert($data);
                $mensaje = messages($insert = 0, $id);
                return $this->respond($mensaje);
            }
        }

        if (empty($global)) {
            $data = [
                "status" => 250,
                "msg" => "El tipo de archivo no es permitido"
            ];
            return $this->respond($data);
        }
    }

    //Datatable de evidencias
    public function showEvidencias()
    {
        $id_folio = $_POST['id_cita'];

        $data['data'] = $this->evidencia->showEvidencia($id_folio);

        return $this->respond($data);
    }

    //Eliminar evidencia
    public function deleteEvidencia()
    {
        $request = \Config\Services::request();
        $id = $request->getPost('id_delete');

        $this->evidencia->delete($id);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $this->respond($mensaje);
    }

    //Terminar cita
    public function terminarCita()
    {
        $request = \Config\Services::request();
        $model_citas = model('App\Models\Agendas\Appointment_schedule');

        $count =  $this->model->selectCount('id_folio')->where('id_folio', $request->getPost('id'))->findAll();

        if ($count[0]['id_folio'] > 0) {
            $id = $model_citas->select('id')->where('id_cita', $request->getPost('id'))->findAll();

            $data = [
                'approved' => 3
            ];

            $model_citas->update($id[0]['id'], $data);
            $affected_rows = $this->db->affectedRows();

            if ($affected_rows) {
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
