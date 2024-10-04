<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class Diseases extends Model
{
    protected $table      = 'cat_diseases';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_c10', 'id_cat_illness_type','common_name'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = false;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function redDiseases(){
        //returns all datacat_diseases
        return $this->asArray()
        ->select('cat_diseases.*, hcv_cie10.NOMBRE,cat_illness_type.name')
        ->join('hcv_cie10', 'hcv_cie10.ID = cat_diseases.id_c10')
        ->join('cat_illness_type', 'cat_illness_type.id = cat_diseases.id_cat_illness_type')
        ->orderBy('cat_diseases.id', 'DESC')
        ->findall();
    }

    public function readHeredofam(){
        return $this->asArray()
        ->select('id, common_name')
        ->where("id_cat_illness_type",  1)
        ->findAll();
    }

    public function readEts(){
        return $this->asArray()
        ->select('id, common_name')
        ->where("id_cat_illness_type",  2)
        ->findAll();
    }
    

    public function getDisease($id){
        //retun one value the what to pay
        return $this->asArray()
        ->select('cat_diseases.*, hcv_cie10.NOMBRE')
        ->join('hcv_cie10', 'hcv_cie10.ID = cat_diseases.id_c10')
        ->where('cat_diseases.id', $id)
        ->find();
    }

    public function existdata($id_c10,$cat_illness){
        return $this->asArray()
        ->select("id")->where("id_c10",$id_c10)->where("id_cat_illness_type",$cat_illness)
        ->find();
    }

    public function existUpdate($id_c10,$cat_illness,$id){
        return $this->asArray()
        ->selectCount("id")->where("id_c10",$id_c10)->where("id_cat_illness_type",$cat_illness)
        ->where("id !=",  $id)
        ->findAll();
        
    }

    public function readAlergias(){
        return $this->asArray()
        ->select('id, common_name')
        ->where("id_cat_illness_type", 3)
        ->findAll();        
    }

    public function readInfectocontagiosas(){
        return $this->asArray()
        ->select('id, common_name')
        ->where("id_cat_illness_type", 4)
        ->findAll();        
    }

    public function readEnfermedadesInfancia(){
        return $this->asArray()
        ->select('id, common_name')
        ->where("id_cat_illness_type", 5)
        ->findAll();        
    }
    
}