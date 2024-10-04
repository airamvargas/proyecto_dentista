
<?php

if(!function_exists('send_email')) {

    function send_email($mail_to,$subject,$message,$file_path) {
        /* $email_from = "registro@redmedicasegura.com"; */
        //$email_from = "info@doisy.mx";
        $email_from = "giovanni.zavala@soluciones.webcorp.com.mx";

      
        $email = \Config\Services::email();

        if($file_path!=null){
            foreach ($file_path as $valor){
                $email->attach($valor);
                $email->setTo($mail_to);
                $email->setFrom($email_from);
                $email->setSubject($subject);
                $email->setMessage($message);     
            }
            if($email->send()){
                return true;
            }else{
                return false;
            }
        }else{
            $email->setTo($mail_to);
            $email->setFrom($email_from);
            $email->setSubject($subject);
            $email->setMessage($message);
            if($email->send()){
                return true;
            }else{
                return false;
            }// end else
        }// end else
    }// end Send mail
}

/* if (!function_exists('send_email')) {

    function send_email($mail_to, $email_vendedor, $subject, $message, $file_path, $correo_salida)
    {
        $email = \Config\Services::email();

        switch ($correo_salida) {
            case "info@solimaq.mx":
                $servidor = "secure.emailsrvr.com";
                break;
            case "info@soliwaste.mx":
                $servidor = "secure.emailsrvr.com";
                break;
            case "info@solimed.mx":
                $servidor = "smtpout.secureserver.net";
                break;
            case "info@solifood.mx":
                $servidor = "smtpout.secureserver.net";
                break;
            case "info@optisort.com.mx":
                $servidor = "smtpout.secureserver.net";
                break;
        }

    
        $config['protocol'] = 'smtp';
        $config['mailPath'] = '/usr/sbin/sendmail';
        $config['SMTPHost']  = $servidor;
        $config['SMTPUser'] = $correo_salida;
        $config['SMTPPass'] = 'Xochimilco1!';
        $config['SMTPPort'] = 465;
        $config['SMTPTimeout'] = 5;
        $config['SMTPCrypto'] = 'ssl/tsl';
        $config['mailType'] = 'html';
        $config['charset'] = 'utf-8';
        $email->initialize($config);


       


        $email_from = $correo_salida;
        $email = \Config\Services::email();

        if ($file_path != null) {
            foreach ($file_path as $valor) {
                $email->attach($valor);
                $email->setTo([$mail_to, $email_vendedor]);
                $email->setFrom($email_from);
                $email->setSubject($subject);
                $email->setMessage($message);
            }

            if ($email->send()) {
                return 0; 

            } else {
                return 1; 

            }
        } else {
            $email->setTo($mail_to);
            $email->setFrom($email_from);
            $email->setSubject($subject);
            $email->setMessage($message);

            if ($email->send()) {
                return 0; 

            } else {
                return 1; 

            }
        }
    }
} */


?>