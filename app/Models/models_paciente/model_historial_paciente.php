<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_historial_paciente extends Model
{
   
   public function hcv_psicology($id){
        $Nombres = $this->db->query("SELECT * from hcv_psicology where id_patient='".$id."' group by id_folio");
            return $Nombres->getResult();
   }

   public function hcv_nutricion($id){
        $Nombres = $this->db->query("SELECT * from hcv_nutricion where id_patient='".$id."' group by id_folio");
            return $Nombres->getResult();
   }

   public function medical_signs($id){
        $Nombres = $this->db->query("SELECT * from medical_signs where id_patient='".$id."' group by id_folio");
            return $Nombres->getResult();
   }

   public function hcv_diagnostic_nutricional($id){
        $Nombres = $this->db->query("SELECT * from medical_signs where id_patient='".$id."' group by id_folio");
            return $Nombres->getResult();
   }



   //Historial clinica del paciente
   public function get_evidency($id){
        $Nombres = $this->db->query("SELECT * from photo_evidency where id_patient='".$id."' group by id_folio");
            return $Nombres->getResult();
   }
}