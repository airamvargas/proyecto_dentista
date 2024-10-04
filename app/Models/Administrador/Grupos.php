<?php

namespace App\Models\Administrador;

use CodeIgniter\Model;

class Grupos extends Model{
    protected $table      = 'groups';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name','description','email','active','c_date'];
    protected $useTimestamps = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function get_grupos(){
        return $this->asObject()
        ->select('id,name')
        ->where('id >=', 3)
        ->where('id <=',10)
        ->findAll();
    }

    public function getGroups($grupo){
        if($grupo == 1){
            return $this->asObject()
            ->where('id >', 1)
            ->where('id != ', 4)
            ->where('id != ', 7)
            ->where('id != ', 8)
            ->where('id != ', 9)
            ->where('id < ', 13)
            ->findAll();

        }else{
            return $this->asObject()
            ->where('id >', 1)
            ->where('id != ', 4)
            ->where('id != ', 7)
            ->where('id != ', 8)
            ->where('id != ', 9)
            ->where('id < ', 13)
            ->findAll();

        }

    }

}
?>
