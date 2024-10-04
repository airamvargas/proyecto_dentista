<?php

namespace App\Models\Generales;

use CodeIgniter\Model;
class Notificaciones extends Model{
    protected $table      = 'notifications';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_type', 'state', 'id_user_emisor', 'id_user_receptor', 'date', 'sub_mensaje','url'];
    protected $useTimestamps = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getNotificaciones($iduser){
        return $this->asObject()
        ->select('notifications.*,type_of_notification.mensaje')
        ->join('type_of_notification', 'type_of_notification.id = notifications.id_type')
        ->where('id_user_receptor',$iduser)
        ->where('state',0)->findAll();
    }


}

?>