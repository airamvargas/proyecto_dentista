<?php

namespace App\Controllers;


class Email extends BaseController
{



        public function index()
        {
               

                //echo("hola mundo");

                $correo_envio = "belcros90@gmail.com";
                $file = array(

                        "./../assets/img/logo.png", "./../assets/img/Sortimex.png",
                      
                );

                //$file="";

                $mensaje = "Soliq entrega";
                $asunto = "Solimaq Prueba";
                $token = "532f9e7aa192ceb76b21d3609d15de0888547de45ae9c306";
                $full_name = "giovanni zavala";

                $datos['usuario'] = $full_name;
                $datos['texto'] = "Crear Contraseña";
                $datos['url'] = "Generales/Recuperar_contrasena/".$token;
                //$mensaje = view('General/Password', $datos);

                //Esta es la funcion Global
                $envio = send_email($correo_envio, $asunto, $mensaje, $file);

                var_dump($envio);
        }

        public function prueba(){
         helper('menu');
         $session = session();
         $data_left['menu'] = get_menu();

         

        }
}
