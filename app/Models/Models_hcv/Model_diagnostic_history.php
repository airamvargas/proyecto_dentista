<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_diagnostic_history extends Model
{
    protected $table = 'hcv_diagnostic_history';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','enfermedad','grupo','fecha','time','id_patient','id_folio','id_medico'];
    protected $returnType="array";
    protected $useSoftDeletes=false;



    public function primera_cita($id_patient){
    	$db = \Config\Database::connect();
    	$builder = $db->table('hcv_quotes');
    	$builder->selectMin('date_time');

    	$builder->where('patient_id',$id_patient);
    	$query = $builder->get();
    	return $query->getResult();

    }

    public function primera_diagnostic($id_folio){
    	 return $this->asArray()
        ->select('*')
        ->where('hcv_diagnostic_history.id_folio',$id_folio)
        ->find();

    }

    public function get_all_cita($date){
        $db = \Config\Database::connect();
        $builder = $db->table('hcv_quotes');
        $builder->select('*');

        $builder->where('date_time',$date);
        $query = $builder->get();
        return $query->getResult();
    }

    public function get_notas_folio($id_folio){
    	$db = \Config\Database::connect();
    	$builder = $db->table('hcv_nota_general');
    	$builder->select('*');         
    	$builder->where('id_folio',$id_folio);
    	$query = $builder->get();
    	return $query->getResult();

    }
 }