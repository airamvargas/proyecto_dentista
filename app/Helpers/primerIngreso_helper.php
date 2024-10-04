<?php 

    /* Desarrollador: Airam Vargas
    Fecha de creacion:
    Fecha de Ultima Actualizacion: 29 - 08 - 2023 Airam Vargas
    Perfil: Tomador de muestra laboratorio
    Descripcion: Helper para el primer ingreso de un usuario tomador de muestra */

    if(!function_exists('ingreso')) {
        function ingreso($user_id) {
            $model = model('App\Models\HCV\Operativo\Ficha_Identificacion');

            $var_upd = $model->confirm_ingreso($user_id);
            $bandera = $var_upd[0]['status_area'];
            
            if($bandera == NULL || $bandera == 2){
                return false;
            } else {
                return true;
            } 
        }
    }
?>