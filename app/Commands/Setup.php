<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Setup extends BaseCommand
{
    protected $group       = 'astsuite';
    protected $name        = 'Setup';
    protected $description = 'Configuracion de variables de entorno de acuerdo a entorno de desarrollo parametro development,stage,production';

    public function run(array $params)
    {
        $info_color = "yellow";
        $error_color = "red";
        helper('file');
        $error = false;
        switch ($params[0]) {
            case 'development':
                //constants
                $CI_ENVIRONMENT = 'development';
                $CUSTOM_STRING = "DOISY";
                $APLICATION_STRING = "DOISY";
                //$SELECTOR_EXTENSIONS = "true";

                // database
                $baseURL = 'http://localhost/CRM_WEBCORP/public/index.php/';
                $dbhostname = "ls-d282f96e3ca48dab27b5081fcaf5eb94b6612480.c1iqs8iwiddm.us-east-2.rds.amazonaws.com";
                $database = "doisy_dev";
                $username = "traba_azm";
                $password = '$evV56i3';
                $DBDriver = "MySQLi";

                break;
            case 'stage':
                //constants
                $CI_ENVIRONMENT = 'development';
                $CUSTOM_STRING = "DOISY";
                $APLICATION_STRING = "DOISY";
                //$SELECTOR_EXTENSIONS = "true";

                // database
                $baseURL = 'https://stage-crm-doisy.devserver.com.mx/public/index.php/';
                $dbhostname = "ls-d282f96e3ca48dab27b5081fcaf5eb94b6612480.c1iqs8iwiddm.us-east-2.rds.amazonaws.com";
                $database = "doisy_dev";
                $username = "traba_azm";
                $password = '$evV56i3';
                $DBDriver = "MySQLi";
                break;

            case 'production':
                //constants
                $CI_ENVIRONMENT = 'production';
                $CUSTOM_STRING = "DOISY";
                $APLICATION_STRING = "DOISY";

                // database
                $baseURL = 'https://doisy.medicinae.app/public/index.php/';
                $dbhostname = "ls-d282f96e3ca48dab27b5081fcaf5eb94b6612480.c1iqs8iwiddm.us-east-2.rds.amazonaws.com ";
                $database = "doisy_test";
                $username = "traba_azm";
                $password = '$evV56i3';
                $DBDriver = "MySQLi";
                break;
            default:
                $error = true;
                CLI::write('Error:' . CLI::color("Entorno de desarrollo desconocido", $info_color));
                break;
        }

        if(!$error){
            CLI::write('Current Path: ' . CLI::color(APPPATH, $info_color));
            //constants

            //Env file
            $data = 'CI_ENVIRONMENT = "'.$CI_ENVIRONMENT.'"'."\n".
                    'CUSTOM_STRING = "'.$CUSTOM_STRING.'"'."\n".
                    'APLICATION_STRING = "'.$CUSTOM_STRING.'"'."\n".
                    //'SELECTOR_EXTENSIONS = '.$SELECTOR_EXTENSIONS."\n".
                    'app.baseURL ="'.$baseURL.'"'."\n".
                    'database.default.hostname = '.$dbhostname."\n".
                    'database.default.database = "'.$database.'"'."\n".
                    'database.default.username = "'.$username.'"'."\n".
                    'database.default.password = "'.$password.'"'."\n".
                    'database.default.DBDriver = "'.$DBDriver.'"'."\n";
            if ( ! write_file(APPPATH.'../.env', $data)){
                CLI::write('Unable to write .env the file: ' . CLI::color(APPPATH, $error_color));
            }else
            {CLI::write('.env the file:' . CLI::color("ok", $info_color));}
            //Env file

            // env javascript 
            CLI::write('Current Path: ' . CLI::color(APPPATH, $info_color));
            //constants

            //Env javascript
            $path_js = APPPATH."../assets/js/env.js";
            $data = 'BASE_URL = "'.$baseURL.'";'."\n";
            if ( ! write_file($path_js, $data)){
                CLI::write('Unable to write .env js the file: ' . CLI::color(APPPATH, $error_color));
            }else
            {CLI::write('.env js the file:' . CLI::color("ok", $info_color));}
            //Env javascript
        }
    }
}