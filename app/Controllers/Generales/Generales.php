<?php

namespace App\Controllers\Generales;
use App\Controllers\BaseController;

class Generales extends BaseController
{
    public function index()
    {
        $session = session();
        if(isset($_SESSION['group'])){
            $grupo = $session->get('group');
            $data = $grupo;
            return $data;
        }else{
            return redirect()->to(base_url());
        }
    }

}
