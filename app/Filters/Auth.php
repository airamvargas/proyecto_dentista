<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if($session->get('logged_in') == true and $session->has('token'))
        {
            helper('Access');
            $router = service('router');
            $controller  = $router->controllerName();
            $acess = access($controller);
            if(!$acess){
                return redirect()->to(base_url().'/Redirect');
           }  
        }else{
            return redirect()->to(base_url().'/Home');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}