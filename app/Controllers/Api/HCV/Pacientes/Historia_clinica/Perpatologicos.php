<?php 

namespace App\Controllers\Api\HCV\Pacientes\Historia_clinica;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

helper('Acceso');
use App\Models\Models_hcv\Model_personales_patologicos as model;
use App\Models\Models_hcv\Model_alergias as alergias;
use App\Models\Models_hcv\Model_cirugias as cirugias;
use App\Models\Models_hcv\Model_infectado_contagios as infectocontagiosas;
use App\Models\Models_hcv\Model_enfermedades_infancia as infancia;
use App\Models\Models_hcv\Model_enfermedades_base as base;

class Perpatologicos extends ResourceController {
    use ResponseTrait;
    var $model;
    var $db;
    var $alergias;
    var $cirugias;
    var $infectocontagiosas;
    var $infancia;
    var $base;

    public function __construct(){
        //Assign global variables
        $this->model = new model();
        $this->alergias = new alergias();
        $this->cirugias = new cirugias();
        $this->infectocontagiosas = new infectocontagiosas();
        $this->infancia = new infancia();
        $this->base = new base();
        $this->db = db_connect();
        helper('messages');
    }

    //Insertar enfermedades base
    public function create() {
        $request = \Config\Services::request();

        if($request->getPost('sustancias') == "Otro"){
            $sustancia = $request->getPost('des_susutancias');
        } else {
            $sustancia = $request->getPost('sustancias');
        }

        $data = [
            'transfusion' => $request->getPost('transfusion'),
            'desc_transfusion' => $request->getPost('des_trans'),
            'fractura_esguince_luxacion' => $request->getPost('accidente'),
            'desc_fractura' => $request->getPost('des_accidente'),
            'consumo_sustancias' => $sustancia,
            'cantidad_consumo' => $request->getPost('cantidad'),
            'user_id' =>$request->getPost('id_user_patient')
        ];
        
        $id = $this->model->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);
    }

    public function read(){    
        $id_paciente = $_POST['id_paciente'];
        $data = $this->model->readPatologicos($id_paciente);
        return $this->respond($data);        
    }

    //Obtener datos para el select de enfemedades base
    public function readBase() {
        $model_base = model('App\Models\Models_hcv\Model_cie10');
        $data = $model_base->get_capitulo();
        return $this->respond($data);     
    }

    //Datatable alergias
    public function showAlergias(){   
        $id_paciente = $_POST['id_paciente'];
        $data['data'] = $this->alergias->showAlergias($id_paciente);
        return $this->respond($data);        
    }

    //Datatable enfermedades infectocontagiosas
    public function showCirugias(){   
        $id_paciente = $_POST['id_paciente'];
        $data['data'] = $this->cirugias->show($id_paciente);
        return $this->respond($data);        
    }

    //Datatable cirugias
    public function showInfecto(){   
        $id_paciente = $_POST['id_paciente'];
        $data['data'] = $this->infectocontagiosas->showInfecto($id_paciente);
        return $this->respond($data);        
    }

    //Datatable enfermedades infancia
    public function showInfancia(){   
        $id_paciente = $_POST['id_paciente'];
        $data['data'] = $this->infancia->show($id_paciente);
        return $this->respond($data);        
    }

    //Datatable enfermedades base
    public function showBase(){   
        $id_paciente = $_POST['id_paciente'];
        $data['data'] = $this->base->show($id_paciente);
        return $this->respond($data);        
    }

    //Insertar alergia
    public function createAlergia() {
        $request = \Config\Services::request();
        $model_diseases = model('App\Models\Catalogos\Diseases');
        $id_alergia =  $request->getPost('id_cat_alergia');
        $user = $request->getPost('user_id');

        $validate = $this->alergias->where('id_cat_alergia',$id_alergia)->where('user_id',$user)->find();

        if(!empty($validate)){
            $data = [
                "status" => 400,
                "msg" => "EL REGISTRO DE LA ALERGIA YA EXISTE"
            ];
            return $this->respond($data); 

        }

        $name_alergia = $model_diseases->select('common_name')->where('id', $request->getPost('id_cat_alergia'))->find();

        $data = [
            'id_cat_alergia' => $request->getPost('id_cat_alergia'),
            'name' => $name_alergia[0]['common_name'],
            'user_id' =>$request->getPost('user_id')
        ];

        $id = $this->alergias->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje); 
    }

    //Insertar procedimientos/cirugia
    public function createProcedimiento() {
        $request = \Config\Services::request();
        $model_procedimientos = model('App\Models\HCV\Administrativos\Model_mini_procedimiento');
        $name_proce = $model_procedimientos->select('common_name')->where('id', $request->getPost('id_cat_procedimiento'))->find();

        //Se verifica que no exista esa cirugia ya registrada en la tabla
        $id_procedimiento =  $request->getPost('id_cat_procedimiento');
        $user = $request->getPost('user_id');

        $procedimiento = $this->cirugias->where('id_cat_procedimiento',$id_procedimiento)->where('user_id',$user)->find();

        if(!empty($procedimiento)){
            $data = [
                "status" => 400,
                "msg" => "EL REGISTRO DE LA CIRUGIA YA EXISTE"
            ];
            return $this->respond($data); 
        }  

        //Se guardan los datos de cirugia en caso de que no exista ese registro
        $data = [
            'id_cat_procedimiento' => $request->getPost('id_cat_procedimiento'),
            'name' => $name_proce[0]['common_name'],
            'user_id' =>$request->getPost('user_id')
        ];

        $id = $this->cirugias->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);
    }

    //Insertar enfermedades infectocontagiosas
    public function createInfecto() {
        $request = \Config\Services::request();
        $model_diseases = model('App\Models\Catalogos\Diseases');
        $name_enfermedad = $model_diseases->select('common_name')->where('id', $request->getPost('id_cat_disease'))->find();

       //Se verifica que no exista esa enfermedad infectocontagiosa registrada en la tabla
       $id_infecto =  $request->getPost('id_cat_disease');
       $user = $request->getPost('user_id');

       $infecto = $this->infectocontagiosas->where('id_cat_disease',$id_infecto)->where('user_id',$user)->find();

       if(!empty($infecto)){
           $data = [
               "status" => 400,
               "msg" => "EL REGISTRO DE ENFERMEDAD INFECTOCONTAGIOSA YA EXISTE"
           ];
           return $this->respond($data); 
       }  

       //Se guardan los datos de enfermedad infectocontagiosa en caso de que no exista ese registro
        $data = [
            'id_cat_disease' => $request->getPost('id_cat_disease'),
            'name' => $name_enfermedad[0]['common_name'],
            'user_id' =>$request->getPost('user_id')
        ];

        $id = $this->infectocontagiosas->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje); 
    }

    //Insertar enfermedades infancia
    public function createInfancia() {
        $request = \Config\Services::request();
        $model_diseases = model('App\Models\Catalogos\Diseases');
        $name_enfermedad = $model_diseases->select('common_name')->where('id', $request->getPost('id_cat_disease'))->find();

        //Se verifica que no exista esa enfermedad de la infancia registrada en la tabla
        $id_infancia =  $request->getPost('id_cat_disease');
        $user = $request->getPost('user_id');

        $infancia = $this->infancia->where('id_cat_disease',$id_infancia)->where('user_id',$user)->find();

        if(!empty($infancia)){
           $data = [
               "status" => 400,
               "msg" => "EL REGISTRO DE ENFERMEDAD DE LA INFANCIA YA EXISTE"
           ];
           return $this->respond($data); 
        }  

       //Se guardan los datos de enfermedad de la infancia en caso de que no exista ese registro
        $data = [
            'id_cat_disease' => $request->getPost('id_cat_disease'),
            'name' => $name_enfermedad[0]['common_name'],
            'user_id' =>$request->getPost('user_id')
        ];

        $id = $this->infancia->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);
    }

    //Insertar enfermedades base
    public function createBase() {
        $request = \Config\Services::request();
        $model_cie10 = model('App\Models\Models_hcv\Model_cie10');
        $name_enfermedad = $model_cie10->select('NOMBRE')->where('ID', $request->getPost('id_cat_disease'))->find();

        //Se verifica que no exista esa enfermedad de base ya registrada en la tabla
        $id_enfermedad =  $request->getPost('id_cat_disease');
        //$id_grupo =  $request->getPost('grupo');
        $user = $request->getPost('user_id');

        $base = $this->base->where('id_cat_disease',$id_enfermedad)->where('user_id',$user)->find();

        if(!empty($base)){
            $data = [
                "status" => 400,
                "msg" => "EL REGISTRO DE ENFERMEDAD DE BASE YA EXISTE"
            ];
            return $this->respond($data); 
        }  

        //Se guardan los datos de enfermedad de base en caso de que no exista ese registro
        $data = [
            'id_cat_disease' => $request->getPost('id_cat_disease'),
            'enfermedad' => $name_enfermedad[0]['NOMBRE'],
            'grupo' => $request->getPost('grupo'),
            'user_id' =>$request->getPost('user_id')
        ];

        $id = $this->base->insert($data);
        $mensaje = messages($insert = 0, $id);
        return $this->respond($mensaje);
    }

    //Eliminar alergia
    public function deleteAlergia() {
        $request = \Config\Services::request();
        $id = $request->getPost('id_delete');
        
        $this->alergias->delete($id);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje;
    }

    //Eliminar procedimiento/Cirugia
    public function deleteProcedimiento() {
        $request = \Config\Services::request();
        $id = $request->getPost('id_delete');
        
        $this->cirugias->delete($id);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje;
    }

    //Eliminar enfermedades infecto
    public function deleteEnfermedad() {
        $request = \Config\Services::request();
        $id = $request->getPost('id_delete');
        
        $this->infectocontagiosas->delete($id);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje;
    }

    //Eliminar enfermedades infancia
    public function deleteInfancia() {
        $request = \Config\Services::request();
        $id = $request->getPost('id_delete');
        
        $this->infancia->delete($id);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje;
    }

    //Eliminar enfermedades base
    public function deleteBase() {
        $request = \Config\Services::request();
        $id = $request->getPost('id_delete');
        
        $this->base->delete($id);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje;
    }
}