<?php 

    if(!function_exists('uploads_file')) {
        function messages($crud,$data){
            switch ($crud):
                case 0:
                    $tipo = "AGREGADO";
                    break;
                case 1:
                    $tipo = "ACTUALIZADO";
                    break;
                case 2:
                    $tipo = "ELIMINADO";
                    break;
                default:
            endswitch;

            if ($data > 0) {
                $data = [
                    "status" => 200,
                    "msg" => $tipo." "."CON EXITO"
                ];
                return json_encode($data);
            } else {

                $data = [
                    "status" => 400,
                    "msg" => "HUBO UN ERROR INTENTALO MÁS TARDE"
                ];
                return json_encode($data);
            }
            
        }
    }