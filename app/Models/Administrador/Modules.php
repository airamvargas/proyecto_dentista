<?php

namespace App\Models\Administrador;

use App\Models\modules as ModelsModules;
use CodeIgniter\Model;

class Modules extends Model
{
    protected $table      = 'modules';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_group_module', 'name','description',"controller","active","phase","show_in_menu"];

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

    public function getAccess($id){
        return $this->asArray()->select("modules.*, access.*, group_modules.name as Category, groups.name as rol ")
        ->join('access', 'access.id_module = modules.id','left')
        ->join('group_modules', 'group_modules.id = modules.id_group_module')
        ->join('groups', 'groups.id = access.id_group','left')
        ->where('access.id_group',$id)
        ->orderBy('id', 'DESC')
        ->findAll();

    }

    //data select access
    public function showModules(){
        return $this->asArray()->select("modules.*,group_modules.name as grupo")
        ->join('group_modules', 'group_modules.id = modules.id_group_module')
        ->findAll();


    }
    
}