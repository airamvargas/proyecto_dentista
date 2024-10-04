<?php 

namespace App\Controllers\Api\Generales;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Administrador\Usuarios as model;

class Recuperar_password extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct()
    {
        //Assign global variables
        $this->db = db_connect();
        helper('messages');
    }
    
    //change password
    public function change_password() {
        $request = \Config\Services::request();
        $model = model('App\Models\Administrador\Usuarios');

        $token = str_replace("&", ".", $request->getPost('token'));
        $password = $request->getPost('password');

        if(!$this->validate_password($password)){
            $mensaje = [
                'status' => 400,
                'msg' => 'La contraseña debe tener al menos 8 caracteres y al menos una mayuscula, una minuscula y un numero'
            ];
            return $this->respond($mensaje);
        } else {
            $data_user =  $model->getDataidentity($token);
            $id = $data_user[0]['id'];
            $password = password_hash($password,PASSWORD_DEFAULT);
            $token_url = password_hash($password, PASSWORD_DEFAULT);
            $data = [
                'password' => $password,
                'activation_token' => $token_url
            ];

            $model->update($id, $data);

            $mensaje = [
                'status' => 200,
                'msg' => 'ACTUALIZADO CON ÉXITO'
            ];
            return $this->respond($mensaje);
        }
       
    }

    private function validate_password($password){
		$uppercase = preg_match('@[A-Z]@', $password);
		$lowercase = preg_match('@[a-z]@', $password);
		$number    = preg_match('@[0-9]@', $password);
		//$specialChars = preg_match('@[^\w]@', $password);
		if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
			return false;
		}else{
			return true;
		}
	}


    
}