<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_cie10_mini extends Model
{
    protected $table = 'hcv_cie10_mini';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['id','nombre_comun','cie10_id','categoria'];
    protected $returnType="array";
    protected $useSoftDeletes=true;
    protected $deletedField  = 'deleted_at';

    public function get_enfermedades(){
        return $this->asArray()
        ->select('hcv_cie10_mini.id,hcv_cie10_mini.nombre_comun')
        ->join('hcv_cie10', 'hcv_cie10.id = hcv_cie10_mini.cie10_id')
        ->where('hcv_cie10_mini.categoria','Heredofamiliares')
        ->where('deleted_at', null)
        ->findAll();
    }

    public function get_data($id){
        return $this->asArray()
        ->select('hcv_cie10_mini.*,hcv_cie10.CATALOG_KEY,hcv_cie10.NOMBRE')
        ->join('hcv_cie10', 'hcv_cie10.ID = hcv_cie10_mini.cie10_id')
        ->where('deleted_at', null)
        ->where('hcv_cie10_mini.id', $id)
        ->first();
    }

    public function get_trans_sexual(){
        return $this->asArray()
        ->select('hcv_cie10_mini.id,hcv_cie10_mini.nombre_comun')
        ->join('hcv_cie10', 'hcv_cie10.id = hcv_cie10_mini.cie10_id')
        ->where('hcv_cie10_mini.categoria','Transmision Sexual')
        ->where('deleted_at', null)
        ->findAll();
    }

    public function get_infecto(){
        return $this->asArray()
        ->select('hcv_cie10_mini.id,hcv_cie10_mini.nombre_comun')
        ->join('hcv_cie10', 'hcv_cie10.id = hcv_cie10_mini.cie10_id')
        ->where('hcv_cie10_mini.categoria','Infectocontagiosas')
        ->where('deleted_at', null)
        ->findAll();
    }

    public function get_infancia(){
        return $this->asArray()
        ->select('hcv_cie10_mini.id,hcv_cie10_mini.nombre_comun')
        ->join('hcv_cie10', 'hcv_cie10.id = hcv_cie10_mini.cie10_id')
        ->where('hcv_cie10_mini.categoria','Enfermedades de la Infancia')
        ->where('deleted_at', null)
        ->findAll();
    }

    


    
    
}