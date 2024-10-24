<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['sendmail' , 'menu', 'upload_files'];
	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);
		date_default_timezone_set('America/Guatemala');

		$exceptions = ['inicio' , 'Home' , 'Login' , 'Groups'];
		$flag_exception = false;
		//si no esta en alguno de estos controladores no se necesita permisos 
		//se valida en el controlador que estamos
		/* foreach ($exceptions as $key ) {
			if($key == getController($this)){
				$flag_exception = true; 
			}	 
			
		}
		if(!$flag_exception){
			$this->permisions = getPermision($this);
			if(count($this->permisions)  <= 0 ){
				echo("no tiene permisos");

				
			}else{
				echo("si tiene permisos");
				$this->permisions = $this->permisions[0];
				var_dump($this->permisions);
;			}
		} */




		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
	}
}
