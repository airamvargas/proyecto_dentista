<?php 

/* Desarrollador: ULISES RODRIGUEZ GARDUÑO
Fecha de creacion: 5-10-2023
Fecha de Ultima Actualizacion: 5-10-2023 por ULISES RODRIGUEZ GARDU;O
Perfil: Recepcionista
Descripcion: API MUESTRAS PENDIENTES */

namespace App\Controllers\Api\Recoleccion;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Tomador_muestra\Citas as model_citas;
use App\Models\Administrador\Identity_employed as identity; 

require_once __DIR__ . '../../../vendor/autoload.php';
class Recolectadas extends ResourceController 
{
    public function index(){
        $session = session();
        $model_citas = new model_citas();
        $full_cita = $model_citas->builder();
        $full_cita->select('citas.id as Folio, 
                            citas.codigo as Codigo , 
                            insumos.name as Prueba, 
                            fecha as Fecha, hora as Hora ,   
                            users.user_name as `Tomador de muestra` , 
                            cat_business_unit.name as `Unidad de negocio`,
                            cotization_x_products.id_cotization as `Folio cotizacion ,
                            (SELECT user_name FROM users where users.id=cotization.id_user_client) as `Nombre Cliente`,
                            cotization.id_user_client as `Folio Cliente`'
                            );
        $full_cita->join('insumos', 'insumos.id = citas.id_study');
        $full_cita->join('users', 'users.id = citas.id_doctor');
        $full_cita->join('cat_business_unit', 'cat_business_unit.id = citas.id_business_unit');
        $full_cita->join('cotization_x_products', 'citas.id_cotization_x_product = cotization_x_products.id');
        $full_cita->join('cotization', 'cotization_x_products.id_cotization = cotization.id');
        $full_cita->where('citas.status_lab' , 109 );
        $full_cita->where('citas.id_recolector' , $session->get('unique') );
        $data['data'] = $full_cita->get()->getResult();
        return $this->respond($data);
    } // list all
    public function create(){}
    //public function show($id = null){}
    public function read(){}
    public function update($id = null){
        $request = \Config\Services::request();
        $json = $request->getJSON();
        var_dump($request);
    }
    public function delete($id = null){}
    public function set_status(){
        $request = \Config\Services::request();
        $session = session();
        $user_id = $session->get('unique');
        $model_user = model('Administrador/Usuarios');
        $model_cita = model('Model_cotizacion/Model_citas');
        $code = $request->getPOST('code');
        $user = $model_user->select('user_name')->where('code',$code)->find();
        if(count($user) > 0){
            $muestras = json_decode($request->getPOST('muestras'));
            foreach ($muestras as $muestra ) {
                $data = [
                    'status_lab' => '109',
                    'status_name'    => 'Recolecta de muestra',
                    'id_recolector' => $user_id,
                ];
                $model_cita->update($muestra->Folio, $data);
            }
            $data['status'] = 200;
            return $this->respond($data);
        }else{
            $data['status'] = 400;
            $data['Message'] = "CODIGO INCORRECTO";
            return $this->respond($data);
        }
    }
}