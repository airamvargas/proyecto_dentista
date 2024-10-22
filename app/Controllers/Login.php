<?php
namespace App\Controllers;
use App\Models\Model_login;
	
class Login extends BaseController
{
	public function verify_login()  {
		$correo=$_POST['email'];
		$password=$_POST['password'];
		$log=new Model_login();
		$data['login']=$log->get_login($correo,$password);
		if(count($data['login'])>0){
			$hashed=$data['login'][0]->password;
			if(password_verify($password, $hashed )){
				//echo "Contraseña correcta";
				$session = session();
				$newdata = [
					'username'  => $data['login'][0]->user_name,
					'email'     => $data['login'][0]->email,
					'token'		=> $data['login'][0]->activation_token,
					//'group'		=> $data['login'][0]->id_group,
					'unique'    => $data['login'][0]->id,
					'logged_in' => TRUE
				];
				$session->set($newdata);
				return redirect()->to(base_url().'/Principal');
				/*$group = $newdata["group"];
				switch($group) {
					//ADMINISTRADOR
					case 1: 
						return redirect()->to(base_url().'/Principal');
					break;
						//BACK OFFICE
					case 2:
						return redirect()->to(base_url().'/Principal');
					break;
					default:
						return redirect()->to(base_url().'/Principal');
					break;
				}*/
				//var_dump($group);
				//return redirect()->to(base_url().'/inicio');.
			}else{
				$data['title'] = PROYECT;
				$data['error'] = "USUARIO O CONTRASEÑA INCORRECTOS";
				echo view('Login/Signin_view' ,  $data);
			}
		}else{
			$data['title'] = PROYECT;
			$data['error'] = "USUARIO O CONTRASEÑA INCORRECTOS";
			echo view('Login/Signin_view' ,  $data);
		}
		
	}

	public function sign_out() {
		$session = session();
		//var_dump($session);
		if($session->has('unique')){
			/*user_id = $session->get('unique');
			$model_identity = model('App\Models\HCV\Operativo\Ficha_Identificacion');
			$model_users = model('App\Models\Administrador\Usuarios');
			$group = $model_users->select('id_group')->where('id', $user_id)->find()[0]['id_group'];
			
			if($group == 7){
				$id_identity = $model_identity->select('ID')->where('user_id', $user_id)->find()[0]['ID'];
				$data = [
					'status_area' => 2
				];
				$model_identity->update($id_identity, $data);
			}*/
			$session->destroy();
			return redirect()->to(base_url()); 
		} else {
			return redirect()->to(base_url()); 
		}
	}
}