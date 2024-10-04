<?php

namespace App\Models\Administrador;

use CodeIgniter\Model;

class Usuarios extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_group', 'user_name', 'email', 'password', 'activation_token', 'code','photo', 'id_parent', 'telefono', 'active', 'business_id'];
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $skipValidation     = false;
    protected $validationRules    = [
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
    ];
    protected $validationMessages = [
        'email' => [
            'is_unique' => 'El CORREO YA EXISTE.',
        ],
    ];


    public function users()
    {
        return $this->asObject()
            ->select('users.id as id_user,users.user_name,users.email,users.password,users.activation_token,users.photo,users.telefono,users.active,groups.name')
            ->join('groups', 'groups.id = users.id_group')
            ->where('id_group >=', 3)
            ->where('id_group <=', 10)
            ->findAll();
    }

    public function get_user($id)
    {
        return $this->asObject()
            ->select('*')->where('id', $id)->find();
    }

    public function read($grupo)
    {
        if ($grupo == 1 or 2) {
            return $this->asObject()
                ->select('users.id as id_user, users.email,users.active,groups.name as grupo, identity_employed.name as empleado,
            identity_employed.first_name, identity_employed.second_name,identity_employed.phone,identity_employed.photo,
            identity_employed.id_cat_business_unit,cat_business_unit.name')
                ->join('identity_employed', 'identity_employed.id_user = users.id')
                ->join('cat_business_unit', 'cat_business_unit.id = identity_employed.id_cat_business_unit')
                ->join('groups', 'groups.id = users.id_group')
                ->findAll();
        } else {
        }
    }

    public function getUser($id)
    {
        return $this->asObject()
            ->select('users.id as id_user, users.password, users.email,users.active,users.id_group,groups.name as grupo,identity_employed.id as id_identity,identity_employed.name as empleado,
            identity_employed.first_name, identity_employed.second_name,identity_employed.phone,identity_employed.photo,
            identity_employed.id_cat_business_unit,cat_business_unit.name')
            ->join('identity_employed', 'identity_employed.id_user = users.id')
            ->join('cat_business_unit', 'cat_business_unit.id = identity_employed.id_cat_business_unit')
            ->join('groups', 'groups.id = users.id_group')->where('users.id', $id)
            ->find();
    }

    public function getToken($token){
        return $this->asArray()->selectCount('activation_token')->where('activation_token',$token)->first();

    }

    public function getDataidentity($token){
        return $this->asArray()->select('users.id, users.email, hcv_identity.NAME, hcv_identity.F_LAST_NAME, hcv_identity.S_LAST_NAME')
        ->join('hcv_identity','hcv_identity.ID_USER = users.id')
        ->where('activation_token',$token)
        ->find();

    }

    public function getCode($jeraquia){
        return $this->asArray()
        ->select('code,users.id,groups.hierarchy')
        ->join('groups', 'groups.id = users.id_group')
        ->where('groups.hierarchy >',0)
        ->where('groups.hierarchy <',(int) $jeraquia)
        ->findAll();

    }

    public function setCode(){
        $builder = $this->builder();
        $builder->set('code', ' ');
        $builder->update();

    }

    public function getCodes(){
        return $this->asArray()
        ->findAll();
    }

    public function getUsersExternal($id_parent){
        $sql = "SELECT users.id AS id_user, identity_bussiness.id, users.user_name, users.email, identity_bussiness.photo, identity_bussiness.phone, 
        (SELECT groups.name FROM groups WHERE groups.id = users.id_group) AS grupo FROM users JOIN identity_bussiness ON users.id = 
        identity_bussiness.id_user WHERE id_parent = :id_parent: AND users.deleted_at = '0000-00-00 00:00:00' AND identity_bussiness.deleted_at = '0000-00-00 00:00:00'";
        $datos = $this->db->query($sql, ['id_parent' => $id_parent]);
        return $datos->getResult();
    }

    public function showUserBuss($id_user){
        return $this->asArray()->select('users.id AS id_user, identity_bussiness.id, identity_bussiness.name, identity_bussiness.first_name, identity_bussiness.second_name, users.email, identity_bussiness.photo, identity_bussiness.phone, 
        users.id_group')
        ->join('identity_bussiness',' users.id = identity_bussiness.id_user')
        ->where('identity_bussiness.id',$id_user)
        ->where('identity_bussiness.deleted_at', '0000-00-00 00:00:00')
        ->where('users.deleted_at', '0000-00-00 00:00:00')
        ->find();
    }
}
