<?php

namespace App\Models\HCV\Paciente\registro_medico;

use CodeIgniter\Model;

class Diagnostico_nutricional extends Model
{
  protected $table = 'hcv_diagnostic_nutricional';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $returnType = 'array';
  protected $useSoftDeletes = true;
  protected $allowedFields = ['id', 'tipo','balance','grasa','ingesta','patient_id','id_folio','operativo_id'];
  protected $useTimestamps = true;
  protected $validationRules = [];
  protected $validationMessages = [];
  protected $skipValidation = false;
  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $deletedField = 'deleted_at';

  //  
  public function get_table_diagnostico_nutricional($id_cita){
    return $this->asArray()
    ->select('hcv_diagnostic_nutricional.id as id, hcv_cat_nutritional_diagnostic.name as tipo, hcv_cat_type_nutricional_diagnostic.name as balance,hcv_cat_diagnostic_indice.name as grasa, hcv_cat_diagnostic_indice2.name as ingesta')
    ->join('hcv_cat_nutritional_diagnostic', 'hcv_cat_nutritional_diagnostic.id = hcv_diagnostic_nutricional.tipo', 'left')
    ->join('hcv_cat_type_nutricional_diagnostic', 'hcv_cat_type_nutricional_diagnostic.id = hcv_diagnostic_nutricional.balance', 'left')
    ->join('hcv_cat_diagnostic_indice', 'hcv_cat_diagnostic_indice.id = hcv_diagnostic_nutricional.grasa')
    ->join('hcv_cat_diagnostic_indice2', 'hcv_cat_diagnostic_indice2.id = hcv_diagnostic_nutricional.ingesta', 'left') 
    ->where('hcv_diagnostic_nutricional.id_folio', $id_cita)
    ->findAll();
  } 

  // Consulta que trae el catalogo de tipo de diagnostico
  public function hcv_cat_diagnostic(){
    $diagnostico = $this->db->query("SELECT * from hcv_cat_nutritional_diagnostic");
    return $diagnostico->getResult();
  } 

  // Consulta con trae el catalogo de tipo de ingesta de acuerdo al diagnostico
  public function get_type_ingesta($id){        
    $ingesta = $this->db->query("SELECT * from hcv_cat_type_nutricional_diagnostic WHERE hcv_cat_nutricional_id='" . $id . "'");
    return $ingesta->getResult();
  } 

  // Consulta que trae otro catalogo derivado del tipo de ingesta
  public function get_type_n($id){
    $indice = $this->db->query("SELECT * from hcv_cat_diagnostic_indice WHERE hcv_cat_type_nutricional_id='" . $id . "'");
    return $indice->getResult();
  } 

  // Consulta que trae otro catalogo derivado del indice anterior
  public function get_type_n_i2($id){
    $indice2 = $this->db->query("SELECT * from hcv_cat_diagnostic_indice2 WHERE hcv_diagnostic_indice_id='" . $id . "'");
    return $indice2->getResult();
  } 
  
  public function registroRepetido($folio, $tipo, $balance, $grasa, $ingesta){
    $sql = 'SELECT COUNT(id) AS total FROM hcv_diagnostic_nutricional WHERE id_folio = :folio: AND tipo = :tipo: AND balance = :balance: AND 
    grasa = :grasa: AND ingesta = :ingesta: AND deleted_at IS NULL';
    $query = $this->db->query($sql, ['folio' => $folio, 'tipo' => $tipo, 'balance' => $balance, 'grasa' => $grasa, 'ingesta' => $ingesta]);
    return $query->getResult();
  }

  public function registroRep($folio, $tipo, $balance, $grasa){
    $sql = 'SELECT COUNT(id) AS total FROM hcv_diagnostic_nutricional WHERE id_folio = :folio: AND tipo = :tipo: AND balance = :balance: AND 
    grasa = :grasa: AND deleted_at IS NULL';
    $query = $this->db->query($sql, ['folio' => $folio, 'tipo' => $tipo, 'balance' => $balance, 'grasa' => $grasa]);
    return $query->getResult();
  }
    
}