<?php
/*if(!function_exists('get_menu')) {
    function get_menu() {
        $session = session();
        $token = $session->get('token');

        //var_dump($token);
        if($session->get('token') !=null){
            $group_module_model = model('App\Models\session\group_modules', false);
            $acces_model = model('App\Models\session\access', false);
            $user_model = model('App\Models\session\users', false);
            $data_left['menu'] = $group_module_model->find();
            $user_data = $user_model->select('id_group')->where('activation_token' ,$token)->find();
            //var_dump($user_data[0] ["id_group"]);
            $i = 0;
            foreach ($data_left['menu'] as $key ) {
                    $subModules = $acces_model->getPermisions($user_data[0]["id_group"] , $key['id']);
                    if(count($subModules) > 0){
                            $data_left['menu'][$i]['subModules'] = $subModules;
                    }else{
                        unset($data_left['menu'][$i]);
                    }
                    $i++;
            }
            return $data_left['menu'];

        }else{
            return array();
        }

       
    }

    function getController($class)
    {
        $controllerName =  explode( "\\" , get_class($class) );
        return $controllerName[count($controllerName) - 1];
    }

    function getPermision($class)
    {
        $session = session();
        $model_modules = model('App\Models\Administrador\Modules');
        $model_access = model('App\Models\Administrador\Accesos');
        $acces_model = model('App\Models\session\access', false);
        $model_data = $model_modules->select('id')->like('controller',getController($class))->findAll()[0]['id'];
        $user_data = $session->get('group');
        if($user_data !=null && $model_data !=null)
        return  $acces_model->getModulePermisions($user_data, $model_data);
        return array(); 
 
    }
}*/
?>

