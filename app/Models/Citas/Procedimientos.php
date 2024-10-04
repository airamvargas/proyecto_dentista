<?php

namespace App\Models\Citas;

use CodeIgniter\Model;
class Procedimientos extends Model{
    protected $table      = 'mini_procedimientos_x_consulta';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_mini_procedimiento','name_procedimiento','id_cita'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

   

   public function getProcediemintos($id_cita){
        return $this->asArray()->where('id_cita',$id_cita)
        ->findAll();
    } 

    public function showProcedimientos($id_folio){
        return $this->asArray()
        ->select('*')
        ->where('id_cita', $id_folio)
        ->findAll();
    }

}

?>