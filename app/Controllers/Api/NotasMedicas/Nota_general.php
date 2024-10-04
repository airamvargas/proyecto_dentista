<?php

namespace App\Controllers\Api\NotasMedicas;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

require_once __DIR__ . '../../../vendor/autoload.php';
helper('Acceso');
helper('sendmail');

class Nota_general extends ResourceController
{
    use ResponseTrait;
    var $db;
    var $nota_general;
    var $signos;
    var $modelmedico;
    var $modiagnostico;
    var $receta;
    var $model_procedimintos;
    var $cita_procedimientos;
    var $agenda_citas;

    public function __construct()
    {
        //Assign global variables
        $this->db = db_connect();
        $this->signos = new \App\Models\Citas\Hcv_medical_signs();
        $this->nota_general = new \App\Models\Citas\Nota_general();
        $this->modelmedico = new \App\Models\HCV\Operativo\Ficha_Identificacion();
        $this->modiagnostico = new  \App\Models\Citas\Diagnostico();
        $this->receta = new  \App\Models\Citas\Receta();
        $this->model_procedimintos = new \App\Models\Catalogos\Tipos_procedimientos() ;
        $this->cita_procedimientos = new \App\Models\Citas\Procedimientos();
        $this->agenda_citas = new \App\Models\Agendas\Appointment_schedule();
        helper('messages');
    }

    public function index()
    {
        $session = session();
        $id_user = $session->get('unique');
        $name = $this->nameMedico($id_user);
        $id_folio = $_POST['id_folio'];
        $validate = $this->nota_general->NotaGeneral($id_folio);
        $count = count($validate);
        //validacion para insertar y actualizar
        if ($count > 0) {
            $update = $this->updateNota($_POST, $name, $id_user, $validate);
            return $this->respond($update);
        } else {
            $insert = $this->insertNota($_POST, $name, $id_user);
            return $this->respond($insert);
        }
    }

    //obtenmos el nombre del medico
    public function nameMedico($id_user)
    {
        return $this->modelmedico->getName($id_user)[0]['nombre'];
    }

    //insertar nota
    public function insertNota($post, $name, $id_user)
    {
        $data = [
            'id_medico' => $id_user,
            'nota' => $post['nota_general'],
            'name_medico' => $name,
            'time' => date('H:i:s'),
            'date' => date('Y-m-d'),
            'id_patient' => $post['id_paciente'],
            'id_folio' => $post['id_folio']
        ];

        $id = $this->nota_general->insert($data);
        if ($id) {
            $data = [
                "status" => 200,
                "msg" => "AGREGADO CON EXITO"
            ];
            return $data;
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return $data;
        }
    }

    //actualizacion de la nota
    public function updateNota($post, $name, $id_user, $nota)
    {

        $data = [
            'id_medico' => $id_user,
            'nota' => $post['nota_general'],
            'name_medico' => $name,
            'time' => date('H:i:s'),
            'date' => date('Y-m-d'),
            'id_patient' => $post['id_paciente'],
            'id_folio' => $post['id_folio']
        ];

        $this->nota_general->update($nota[0]['id'], $data);
        $affected_rows = $this->db->affectedRows();
        if ($affected_rows > 0) {
            $data = [
                "status" => 200,
                "msg" => "ACTUALIZADO CON EXITO"
            ];
            return $data;
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return $data;
        }
    }

    //traemos la nota general
    public function getNota($id_folio)
    {
        $nota['nota'] = $this->nota_general->NotaGeneral($id_folio);
        $nota['signos'] = $this->signos->getsings($id_folio);
        return $this->respond($nota);
    }

    public function createSignos()
    {

        $session = session();
        $id_user = $session->get('unique');
        $id_folio = $_POST['id_folio'];
        $validate = $this->signos->getsings($id_folio);
        $count = count($validate);
        //validacion para insertar o actualizar los signos vitales
        if ($count > 0) {
            $update = $this->updateSings($_POST, $id_user, $validate);
            return $this->respond($update);
        } else {
            $insert = $this->inserSings($_POST, $id_user);
            return $this->respond($insert);
        }
    }

    //creacion de los signos
    public function inserSings($post, $id_user)
    {
        $data = [
            'FC' => $post['FC'],
            'FR' => $post['FR'],
            'temp' => $post['temp'],
            'TA' => $post['TA'],
            'TA2' => $post['TA2'],
            'satO2' => $post['satO2'],
            'mg_dl' => $post['mg_dl'],
            'peso' => $post['peso'],
            'talla' => $post['talla'],
            'patient_id' => $post['id_paciente'],
            'id_folio' => $post['id_folio'],
            'operativo_id' => $id_user
        ];

        $id = $this->signos->insert($data);
        if ($id) {
            $data = [
                "status" => 200,
                "msg" => "AGREGADO CON EXITO"
            ];
            return $data;
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return $data;
        }
    }

    //actualizacion de los signos viatles
    public function updateSings($post, $id_user, $signos)
    {

        $data = [
            'FC' => $post['FC'],
            'FR' => $post['FR'],
            'temp' => $post['temp'],
            'TA' => $post['TA'],
            'TA2' => $post['TA2'],
            'satO2' => $post['satO2'],
            'mg_dl' => $post['mg_dl'],
            'peso' => $post['peso'],
            'talla' => $post['talla'],
        ];

        $this->signos->update($signos[0]['id'], $data);
        $affected_rows = $this->db->affectedRows();
        if ($affected_rows > 0) {
            $data = [
                "status" => 200,
                "msg" => "ACTUALIZADO CON EXITO"
            ];
            return $data;
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return $data;
        }
    }

    //creacion de la enfermedad de la tabla de diagnistico
    public function createDiagostic()
    {
        $session = session();
        $id_user = $session->get('unique');
        $data = [
            'enfermedad' => $_POST['enfermedad'],
            'fecha' => date('Y-m-d'),
            'time' =>  date('H:i:s'),
            'id_patient' => $_POST['id_paciente'],
            'id_folio' => $_POST['id_folio'],
            'id_medico' => $id_user
        ];
        $id = $this->modiagnostico->insert($data);
        if ($id) {
            $data = [
                "status" => 200,
                "msg" => "AGREGADO CON EXITO"
            ];
            return $this->respond($data);
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return $this->respond($data);
        }
    }

    //datos para la tabla de diagnostico
    public function getDiagnostic($id_cita)
    {
        $data['data'] = $this->modiagnostico->getDiagnostic($id_cita);
        return $this->respond($data);
    }

    //elimina de la tabla de diagnostico 
    public function deleteDiagnostic()
    {
        $this->modiagnostico->delete($_POST['id_delete']);
        $affected_rows = $this->db->affectedRows();
        if ($affected_rows > 0) {
            $data = [
                "status" => 200,
                "msg" => "ELIMINADO CON EXITO"
            ];
            return $this->respond($data);
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return $this->respond($data);
        }
    }

    //creacion de medicamentos
    public function createReceta()
    {
        $session = session();
        $id_user = $session->get('unique');
        $data = [
            'medicamento' => $_POST['medicamento'],
            'presentacion' => $_POST['presentacion'],
            'indicaciones' =>  $_POST['indicaciones'],
            'patient_id' => $_POST['id_paciente'],
            'id_folio' => $_POST['id_folio'],
            'operativo_id' => $id_user
        ];
        $id = $this->receta->insert($data);
        if ($id) {
            $data = [
                "status" => 200,
                "msg" => "AGREGADO CON EXITO"
            ];
            return $this->respond($data);
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return $this->respond($data);
        }
    }

    //obtenemos los datos medicamentos
    public function getReceta($id)
    {
        $data['data'] = $this->receta->getReceta($id);
        return $this->respond($data);
    }

    //borra de la tabla el medicamento 
    public function deleteMedicamento()
    {
        $this->receta->delete($_POST['id_delete']);
        $affected_rows = $this->db->affectedRows();
        if ($affected_rows > 0) {
            $data = [
                "status" => 200,
                "msg" => "ELIMINADO CON EXITO"
            ];
            return $this->respond($data);
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return $this->respond($data);
        }
    }

    //insert de indicacion secundaria
    public function createIdicaciones()
    {
        $session = session();
        $id_user = $session->get('unique');
        $data = [
            'indicaciones_secundarias' => $_POST['secundarias'],
            'patient_id' => $_POST['id_paciente'],
            'id_folio' => $_POST['id_folio'],
            'operativo_id' => $id_user

        ];

        if (($_POST['id'] != "")) {
            $this->receta->update($_POST['id'], $data);
            $affected_rows = $this->db->affectedRows();
            if ($affected_rows > 0) {
                $data = [
                    "status" => 200,
                    "msg" => "AGREGADO CON EXITO"
                ];
                return $this->respond($data);
            } else {
                $data = [
                    "status" => 400,
                    "msg" => "ERROR EN EL SERVIDOR"
                ];
                return $this->respond($data);
            }
        } else {
            $id = $this->receta->insert($data);
            if ($id) {
                $data = [
                    "status" => 200,
                    "msg" => "AGREGADO CON EXITO"
                ];
                return $this->respond($data);
            } else {
                $data = [
                    "status" => 400,
                    "msg" => "ERROR EN EL SERVIDOR"
                ];
                return $this->respond($data);
            }
        }
    }

    //indicacion secundaria
    public function getIndicaciones($id_folio)
    {
        $data = $this->receta->getIndicacion($id_folio);
        return $this->respond($data);
    }

    //envio de receta en correo
    public function sendPdf()
    {
        //modelos
        $model_identity = model('App\Models\HCV\Paciente\Ficha_identificacion_paciente');
        $model_medico =   model('App\Models\HCV\Operativo\Ficha_Identificacion');
        $model_diagnostico = model(' \App\Models\Citas\Diagnostico');
        $model_receta = model('\App\Models\Citas\Receta');
        $agenda_medico = model('App\Models\Agendas\Doctor_schedule');
        $users = model(' App\Models\Administrador\Usuarios');
        //variables 
        $id_folio = $_POST['id_folio'];
        $medico = $_POST['id_medico'];
        $paciente = $_POST['id_paciente'];
        //datos para el pdf
        $data['paciente'] = $model_identity->select('CONCAT(hcv_identity.NAME," ",hcv_identity.F_LAST_NAME," ",hcv_identity.S_LAST_NAME) as fullname')->where('ID_USER', $paciente)->find();
        $data['medico'] = $model_medico->select('CONCAT(NAME," ",F_LAST_NAME," ",S_LAST_NAME) as name_medico,NUMBER_PROFESSIONAL_CERTIFICATE')->where('user_id', $medico)->find();
        $data['indicacion'] = $model_receta->getIndicacion($id_folio);
        $data['diagnostico'] = $model_diagnostico->select('enfermedad')->where('id_folio', $id_folio)->findAll();
        $data['receta'] = $model_receta->getReceta($id_folio);
        $data['fecha_cita'] = $agenda_medico->select('date_appointment')->where('id_cita', $id_folio)->find();
        $correo = $users->find($paciente);
        //validacion si hay un correo a donde enviar la receta
        if ($correo['email'] != "") {
            $output2 = '../public/Cotizaciones/Receta.pdf';
            $response = service('response');
            $response->setHeader('Content-type', ' application/pdf');
            $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
            $mpdf->WriteHTML($this->body($data));
            $mpdf->Output($output2, 'F');

            $mensaje = "Receta Medica";
            $asunto = "Receta";
            $file_array = array(
                $output2,
            );
            $envio = send_email($correo['email'], $asunto, $mensaje, $file_array);
            if ($envio) {
                unlink($output2);
                $response = [
                    "status" => 200,
                    "msg" => "CORREO ENVIADO CON EXITO"
                ];
                return $this->respond($response);
            }
        } else {
            $data = [
                "status" => 400,
                "msg" => "NO HAY UN CORREO DE ENVIO DEL PACIENTE"
            ];
            return $this->respond($data);
        }
    }
    //creacion de la vista del pdf
    public function body($data)
    {
        return view('Medicos/Receta_pdf', $data);
    }

    //catalogo de procedimientos
    public function getProdimientos()
    {
        $session = session();
        $id_user = $session->get('unique');
        $especilidad = $this->modelmedico->select('disciplina_id')->where('user_id',$id_user)->find()[0]['disciplina_id'];
        $data = $this->model_procedimintos->readProcedimientoPsico($especilidad);
        return $this->respond($data); 
    }

    //insert procedimiento de la cita
    public function creteCita()
    {
        $mini = $this->model_procedimintos->find($_POST['id_proce'])['commun_name'];
        $data = [
            'id_mini_procedimiento' => $_POST['id_proce'],
            'name_procedimiento' => $mini,
            'id_cita' =>  $_POST['id_folio']
        ];
        $id = $this->cita_procedimientos->insert($data);
        if ($id) {
            $data = [
                "status" => 200,
                "msg" => "AGREGADO CON EXITO"
            ];
            return $this->respond($data);
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return $this->respond($data);
        }
    }

    //tabla de procedimientos
    public function getMini($id)
    {
        $data['data'] = $this->cita_procedimientos->getProcediemintos($id);
        return $this->respond($data);
    }

    public function deleteProcedimiento()
    {
        $this->cita_procedimientos->delete($_POST['id_delete']);
        $affected_rows = $this->db->affectedRows();
        if ($affected_rows > 0) {
            $data = [
                "status" => 200,
                "msg" => "ELIMINADO CON EXITO"
            ];
            return $this->respond($data);
        } else {
            $data = [
                "status" => 400,
                "msg" => "ERROR EN EL SERVIDOR"
            ];
            return $this->respond($data);
        }
    }

    public function finishCita()
    {
        $id_folio = $_POST['folio'];
        $signos = count($this->signos->where('id_folio', $id_folio)->findAll());
        $nota = count($this->nota_general->where('id_folio', $id_folio)->findAll());
        $diagnostico = count($this->modiagnostico->where('id_folio', $id_folio)->findAll());
        $id = $this->agenda_citas->where('id_cita', $id_folio)->findAll()[0]['id'];

        if ($diagnostico > 0 and $nota > 0 and $signos) {
            $data = [
                'approved' => 3
            ];

            $this->agenda_citas->update($id, $data);
            $affected_rows = $this->db->affectedRows();
            if ($affected_rows > 0) {
                $data = [
                    "status" => 200,
                    "msg" => "CITA TERMINADA"
                ];
                return $this->respond($data);
            } else {
                $data = [
                    "status" => 400,
                    "msg" => "ERROR EN EL SERVIDOR"
                ];
                return $this->respond($data);
            }
        } else {
            $data = [
                "status" => 400,
                "msg" => "FALTAN DATOS POR LLENAR"
            ];
            return $this->respond($data);

        }
    }
}
