<?php 

namespace App\Controllers\Api\HCV\Operativo;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;


class Hcv_Rest_Identificacion extends ResourceController
{
    
    public function index(){
        $user_model = model('App\Models\session\users');
        $session = session();
        $token = $session->get('token');
        $id_user = $user_model->get_id($token);
        $id = $id_user['id'];

        $model = model('App\Models\Models_hcv\Model_hcv_identity_operativo');

        $cedula_profesional = $this->request->getFile('fcedula');
        $cedula_especialidad = $this->request->getFile('cedulaespe');
        $ine = $this->request->getFile('ine');
        $foto_user = $this->request->getFile('file_user');

        $path = 'uploads/operativo';
        $name_cedulap = $_POST['fcedula'];
        $name_cedulaes = $_POST['cedulaespe'];

        //$path = '../public/images';
       

       /*  if ($cedula_profesional->isValid() && ! $cedula_profesional->hasMoved()) {
            $newName = $cedula_profesional->getRandomName();
            $cedula_profesional->move(WRITEPATH.$path , $newName);
            $name_cedulap = $cedula_profesional->getName();
        }else{
            $name_cedulap = '';
        }
        if ($cedula_especialidad->isValid() && ! $cedula_especialidad->hasMoved()) {
            $newName2 = $cedula_especialidad->getRandomName();
            $cedula_especialidad->move(WRITEPATH.$path , $newName2);
            $name_cedulaes = $cedula_especialidad->getName();
        }else{
            $name_cedulaes = '';
        }     */


        if ($ine->isValid() && ! $ine->hasMoved()) {
            $newName3 = $ine->getRandomName();
            $ine->move(WRITEPATH.$path , $newName3);
            $name_ine = $ine->getName();
        }else{
            $name_ine = '';
        }     
                    
        if ($foto_user->isValid() && ! $foto_user->hasMoved()) {
            $newName4 = $foto_user->getRandomName();
            $foto_user->move(WRITEPATH.$path , $newName4);
            $name_foto_user = $foto_user->getName();
        }else{
            $name_foto_user = '';
        }     
        
        $fecha = date("Y-m-d", strtotime($_POST['BIRTHDATE']));
       // $fecha = date($_POST['BIRTHDATE'],"Y-m-d");

      
        $data = [
                'ID_USER' =>$id,
                'NAME' => $_POST['NAME'],
                'F_LAST_NAME' => $_POST['F_LAST_NAME'],
                'S_LAST_NAME' => $_POST['S_LAST_NAME'],
                'BIRTHDATE' =>$fecha,
                'DESC_PERSONAL' =>$_POST['descrip'],
                'CAT_CP_ID' =>$_POST['ID_CODE'],
                'STREET_NUMBER' =>$_POST['STREET'],
                'DISCIPLINE' =>$_POST['disciplina'],
                'SPECIALTY'=>$_POST['especialidad'],
                'FILE_PROFESSIONAL_CERTIFICATE' =>$name_cedulap,
                'FILE_SPECIALTY'=>$name_cedulaes,
                'FILE_INE' =>$name_ine,
                'FILE_USER' =>$name_foto_user,
                'PHONE_NUMBER' =>$_POST['PHONE_NUMBER'],
                'LATITUD'=>$_POST['latitud'],
                'LONGITUD'=>$_POST['longitud']
            ]; 

        $model->insert($data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'AGREGADO CON EXITO'
            ]
          ];
      return $this->respondCreated($response); 
          
 
    }

    public function get_medico(){
        $json = $this->request->getJSON();
        $id_paciente = $json->id;
        $model = model('App\Models\Models_hcv\Model_hcv_identity_operativo');
        $data = $model->get_operativo($id_paciente);
        return $this->respond($data, 200);
    }

    public function operativo_update(){

        $id = $_POST['id_operativo'];
        

        $model = model('App\Models\Models_hcv\Model_hcv_identity_operativo');
        $cedula_profesional = $this->request->getFile('fcedula');
        $cedula_especialidad = $this->request->getFile('cedulaespe');
        $ine = $this->request->getFile('ine');
        $foto_user = $this->request->getFile('file_user');

        $path = 'uploads/operativo';
        $name_cedulap = $_POST['fcedula'];
        $name_cedulaes = $_POST['cedulaespe'];

        //$path = '../public/images';
       

       /*  if ($cedula_profesional->isValid() && ! $cedula_profesional->hasMoved()) {
            $newName = $cedula_profesional->getRandomName();
            $cedula_profesional->move(WRITEPATH.$path , $newName);
            $name_cedulap = $cedula_profesional->getName();
        }else{
            $name_cedulap = $_POST['name_cedula'];
        } */


       /*  if ($cedula_especialidad->isValid() && ! $cedula_especialidad->hasMoved()) {
            $newName2 = $cedula_especialidad->getRandomName();
            $cedula_especialidad->move(WRITEPATH.$path , $newName2);
            $name_cedulaes = $cedula_especialidad->getName();
        }else{
            $name_cedulaes = $_POST['name_especialidad'];
        }     */


        if ($ine->isValid() && ! $ine->hasMoved()) {
            $newName3 = $ine->getRandomName();
            $ine->move(WRITEPATH.$path , $newName3);
            $name_ine = $ine->getName();
        }else{
            $name_ine = $_POST['name_ine'];
        }     
                    
        if ($foto_user->isValid() && ! $foto_user->hasMoved()) {
            $newName4 = $foto_user->getRandomName();
            $foto_user->move(WRITEPATH.$path , $newName4);
            $name_foto_user = $foto_user->getName();
        }else{
            $name_foto_user = $_POST['name_profile'];
        }    

        $fecha = date("Y-m-d", strtotime($_POST['BIRTHDATE']));
        
       // $fecha = date($_POST['BIRTHDATE']);

        $data = [
                'NAME' => $_POST['NAME'],
                'F_LAST_NAME' => $_POST['F_LAST_NAME'],
                'S_LAST_NAME' => $_POST['S_LAST_NAME'],
                'BIRTHDATE' =>$fecha,
                'DESC_PERSONAL' =>$_POST['descrip'],
                'CAT_CP_ID' =>$_POST['ID_CODE'],
                'STREET_NUMBER' =>$_POST['STREET'],
                'DISCIPLINE' =>$_POST['disciplina'],
                'SPECIALTY'=>$_POST['especialidad'],
                'FILE_PROFESSIONAL_CERTIFICATE' =>$name_cedulap,
                'FILE_SPECIALTY'=>$name_cedulaes,
                'FILE_INE' =>$name_ine,
                'FILE_USER' =>$name_foto_user,
                'PHONE_NUMBER' =>$_POST['PHONE_NUMBER'],
                'LATITUD'=>$_POST['latitud'],
                'LONGITUD'=>$_POST['longitud']
            ]; 

        $model->update($id,$data);

        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'AGREGADO CON EXITO'
            ]
          ];
      return $this->respondCreated($response); 
          

    }

    ///busqueda del mapa por servicio //

    public function data_mapa(){
        $json = $this->request->getJSON();
        $direct = $json->STREET;
        $address = urlencode($direct); 

        $googleMapUrl = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyCwD3Bk71LnFRTi329E7GRyqPQDTpDGXgk";
        $geocodeResponseData = file_get_contents($googleMapUrl);
        $responseData = json_decode($geocodeResponseData, true);

        if($responseData['status']=='OK') {
            $latitude = isset($responseData['results'][0]['geometry']['location']['lat']) ? $responseData['results'][0]['geometry']['location']['lat'] : "";
            $longitude = isset($responseData['results'][0]['geometry']['location']['lng']) ? $responseData['results'][0]['geometry']['location']['lng'] : "";
            $formattedAddress = isset($responseData['results'][0]['formatted_address']) ? $responseData['results'][0]['formatted_address'] : "";         
            if($latitude && $longitude && $formattedAddress) {   

                $data = [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'formattedAddress' => $formattedAddress
                   
                    
                ];

                return $this->respond($data, 200);
                         
            } else {
                return $this->respond(400);
            }         
        } else {
            
            return $this->failNotFound('BUSQUEDA NO ENCONTRADO');
        }
    }

    public function get_especialidad($busqueda){
        $model = model('App\Models\Models_hcv\Model_academic');
        $data = $model->get_academic($busqueda); 
        return $this->respond($data); 
    }

}