<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Compare extends BaseCommand
{
    protected $group       = 'astsuite';
    protected $name        = 'Compare';
    protected $description = 'Comparar base actual vs base de datos contra base developmente de referencia';


    public function run(array $params)
    {
        $catalogos_estaticos = ['modules' , 'groups' , 'group_modules' , 'access' , 'status_laboratory'];
        $info_color = "yellow";
        $error_color = "red";
        // $development_tables = $this->DB1->list_tables(); referene
        // $live_tables = $this->DB2->list_tables(); production
        $custom = [
            'DSN'      => '',
            'hostname' => 'ls-d282f96e3ca48dab27b5081fcaf5eb94b6612480.c1iqs8iwiddm.us-east-2.rds.amazonaws.com',
            'username' => 'traba_azm',
            'password' => '$evV56i3',
            'database' => 'doisy_dev',
            'DBDriver' => 'MySQLi',
            'DBPrefix' => '',
            'pConnect' => false,
            'DBDebug'  => true,
            'charset'  => 'utf8',
            'DBCollat' => 'utf8_general_ci',
            'swapPre'  => '',
            'encrypt'  => false,
            'compress' => false,
            'strictOn' => false,
            'failover' => [],
            'port'     => 3306,
        ];
        $db_actual = \Config\Database::connect();
        $db_reference = \Config\Database::connect($custom);
        $db_reference_tables = $db_reference->listTables();
        $db_actual_tables = $db_actual->listTables();
        foreach ($db_reference_tables as $reference) {
            $found = false;
            foreach ($db_actual_tables as $actual) {
                if ($reference == $actual) {
                    $found = true;
                }
            }
            if($found){
                CLI::write($reference . CLI::color(" Table Found", $info_color));
                $coluns_reference = $db_reference->query("SHOW COLUMNS FROM `$reference`")->getResultArray();
                $coluns_Actual = $db_actual->query("SHOW COLUMNS FROM `$reference`")->getResultArray();
                //var_dump($coluns_reference);
                foreach ($coluns_reference as $culumn_refernce ) {
                    $found_column = false;
                    foreach ($coluns_Actual as $culumn_actual ) {
                        if($culumn_refernce['Field']  == $culumn_actual['Field'] ){
                            $found_column = true;
                        }
                    }
                    if($found_column){
                        //CLI::write("    _".$culumn_refernce['Field'] . CLI::color(" Column Found", $info_color));
                    }else{
                        //var_dump($culumn_refernce);
                        CLI::write("    _".$culumn_refernce['Field'] . CLI::color("  Column Not Found", $error_color));
                        $add_field = "ALTER TABLE $reference ADD COLUMN `" . $culumn_refernce["Field"] . "` " . $culumn_refernce["Type"];
                        $add_field .= (isset($culumn_refernce["Null"]) && $culumn_refernce["Null"] == 'YES') ? ' Null' : '';
                        $add_field .= " DEFAULT " . $culumn_refernce["Default"];
                        $add_field .= (isset($culumn_refernce["Extra"]) && $culumn_refernce["Extra"] != '') ? ' ' . $culumn_refernce["Extra"] : '';
                        $add_field .= ';';
                        CLI::write("     ". CLI::color($add_field , $error_color));
                    }
                }
            }else{
                CLI::write($reference . CLI::color(" Table Not Found", $error_color));
                $query = $db_reference->query("SHOW CREATE TABLE `$reference` -- create tables");
                $table_structure = $query->getRowArray();
                CLI::write("    ". CLI::color($table_structure["Create Table"] . ";", $error_color));
            }
            
            # code...
        }
    }
}