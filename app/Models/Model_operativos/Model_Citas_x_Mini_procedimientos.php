<?php

namespace App\Models\Model_operativos;

use CodeIgniter\Model;

class Model_Citas_x_Mini_procedimientos extends Model
{
    protected $table = 'mini_procedimientos_x_consulta';
    protected $primaryKey = 'id';
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id','id_mini_procedimiento', 'name_procedimiento','id_cita', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deleteddField = 'deleted_at';
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;

    public function get_procedimientos($id_cita){
      
            return $this->asArray()
            ->select('mini_procedimientos_x_consulta.id,hcv_procedimientos_mini.nombre,hcv_procedimientos_mini.Precio')
            ->join('hcv_procedimientos_mini', 'hcv_procedimientos_mini.id = mini_procedimientos_x_consulta.id_mini_procedimiento')
            ->where('mini_procedimientos_x_consulta.id_cita',$id_cita)
            ->orderBy('Id', 'DESC')
            ->findAll();
        

    }

    public function readProcedimientosDisciplina($folio){
		return $this->asArray()
        ->select('*')
		->where('id_cita', $folio)
        ->findAll();
	}

    public function showProcedimientos($folio){
		return $this->asArray()
		->where('id_cita', $folio)
        ->findAll();
	}
   

}