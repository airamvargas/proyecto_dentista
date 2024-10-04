<?php 

    if(!function_exists('check_cotization')) {
        function check_cotization($id , $user_id) {
            $model = model('App\Models\Model_cotizacion\Cotizacion');

            $total = $model->confirm_cotization($id, $user_id);

            $confirm = $total[0]->total;
            
            if($confirm != 0){
                return true;
            } else {
                return false;
            }
           
        }

    }

    
?>