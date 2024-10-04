<?php 

    if(!function_exists('access')) {
        function access($controlador) {
            $session = session();
            $model_modules = model('App\Models\Administrador\Modules');
            $model_access = model('App\Models\Administrador\Accesos');
            $name_controller = str_replace("\\","/",substr($controlador, 17));
            $id_module = $model_modules->select('id')->like('controller',$name_controller)->findAll();
            if(!empty($id_module)){
                $id_grupo = $session->get('group');
                $data = $model_access->where('id_module',$id_module[0]['id'])->where('id_group',$id_grupo)->findAll();
                if(!empty($data)){
                    return true;
                }else{
                    return false;
                } 
            }else{
                return true;
            }
        }
    }
