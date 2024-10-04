<?php

namespace App\Models\Company_data;

use CodeIgniter\Model;

class Company_data extends Model{
    protected $table      = 'company_data';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'tel','address','logo','rfc', 'email', 'whatsapp', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getConpany(){
        return $this->asArray()
        ->select('*')
        ->where('deleted_at', '0000-00-00 00:00:00')
		->find();
    }

    public function readUpdate($id){
        return $this->asArray()
        ->where('id', $id)
		->findAll();
    }

    public function getData(){
        $sql = "SELECT COUNT(*) AS total FROM company_data WHERE deleted_at = '0000-00-00 00:00:00'";
        $datos = $this->db->query($sql);
        return $datos->getResult();
    }
}

?>