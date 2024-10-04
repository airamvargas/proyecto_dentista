<?php

namespace App\Controllers;

class Home extends BaseController
{
	
	public function index()
	{
		$session = session();
		if( $session->get('logged_in') != null){
			return redirect()->to(base_url().'/Principal');
		}else{
			$data['title'] = "CLINICA DENTAL";
			echo view('Login/Signin_view' ,  $data);
		}
	}
}