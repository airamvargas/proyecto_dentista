<?php

namespace App\Models\Models_hcv;

use CodeIgniter\Model;

class Model_perinatales extends Model
{
    protected $table = 'hcv_perinatales';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['no_embarazo_del_nino', 'complicaciones_en_embarazo', 'desc_complicaciones',
    'tipo_nacimiento', 'edad_de_la_madre_al_nacimiento', 'presento_alguna_complicacion_al_nacimiento', 'desc_complicacion_al_nacimiento',
    'semanas_gestacion_al_nacer', 'alimentacion_al_nacer', 'desc_otra_alimentacion', 'calificacion_de_apgar', 'calificacion_de_silverman',
    'amerito_reanimacion', 'amerito_incubadora', 'user_id', 'created_at','updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';



    public function read($id){
        return $this->asArray()
        ->select('hcv_perinatales.*')
        ->where('user_id', $id)
        ->orderBy('id DESC')
        ->limit(1)
        ->findAll();
    
    
    }

    public function get_max_peri($id_paciente){
        $query = "SELECT * FROM perinatales
        WHERE perinatales.create  = (
        SELECT MAX(perinatales.create)
        FROM perinatales
        where Id_paciente = '$id_paciente')";
        $data = $this->db->query($query);
        return $data->getResult();
    }


}