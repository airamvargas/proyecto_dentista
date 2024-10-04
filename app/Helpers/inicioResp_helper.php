<?php 

    /* Desarrollador: Airam Vargas
    Fecha de creacion: 30/octubre/2023
    Fecha de Ultima Actualizacion:
    Perfil: Responsable sanitario
    Descripcion: Helper para el varificar que el usuario tenga su firma en el sistema */

    if(!function_exists('ingreso')) {
        function ingreso($user_id) {
            $model = model('App\Models\HCV\Operativo\Ficha_Identificacion');

            $var_upd = $model->confirm_firma($user_id);
            $bandera = $var_upd[0]['signature'];
            
            if($bandera == 1){
                return true;
            } else {
                return false;
            } 
        }
    }
?>