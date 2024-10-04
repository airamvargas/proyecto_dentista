<?php

namespace App\Models\Administrador;

use CodeIgniter\Model;

class Identity_employed extends Model
{
    protected $table      = 'identity_employed';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name','first_name','second_name','phone','photo', 'signature', 'id_cat_business_unit','id_user'];

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

    public function read(){
        //returns all the payment method data
        return $this->asArray()->select("modules.*,group_modules.name as grupo")
        ->join('group_modules', 'group_modules.id = modules.id_group_module')
        ->orderBy('id', 'DESC')
        ->findAll();
    }

    public function getData($id){
        return $this->asArray()->where('id',$id)->find();
    }

    public function getModule($id){
        return $this->asArray()->select("modules.*,group_modules.name as grupo")
        ->join('group_modules', 'group_modules.id = modules.id_group_module')
        ->where('modules.id_group_module',$id)
        ->orderBy('id', 'DESC')
        ->findAll();
    }

    public function getUnitB($user_id){
        return $this->asArray()
        ->select("id_cat_business_unit")
        ->where('id_user',$user_id)
        ->findAll();
    }

    public function show($user_id){
        return $this->asArray()
        ->select("identity_employed.*, users.code, users.email, cat_business_unit.name AS unidad")
        ->join('users', 'users.id = identity_employed.id_user')
        ->join('cat_business_unit', 'cat_business_unit.id = identity_employed.id_cat_business_unit')
        ->where('identity_employed.id_user', $user_id)
        ->findAll();
    }

    //imagen del header del usuario
    public function getImage($user_id){
        return $this->asArray()
        ->select("photo")
        ->where('identity_employed.id_user', $user_id)
        ->findAll();
    }

    public function geUser($id){
        
        return $this->asArray()
        ->select("identity_employed.*, users.code, users.email, cat_business_unit.name AS unidad")
        ->join('users', 'users.id = identity_employed.id_user')
        ->join('cat_business_unit', 'cat_business_unit.id = identity_employed.id_cat_business_unit')
        ->where('id_user',$id)->find();

    }   
    // Firma del responsable sanitario
    public function firma($id){
        return $this->asArray()
        ->where('identity_employed.id_user', $id)
        ->findAll();
    }

}