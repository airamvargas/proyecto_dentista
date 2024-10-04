<?php
/* 
Fecha de Ultima Actualizacion: 6-septiembre-2023 
Perfil: Paciente
Descripcion: Perfil de inicio con las citas programadas */ 
namespace App\Models\Agendas;

use CodeIgniter\Model;

class Appointment_schedule extends Model{
    protected $table      = 'appointment_schedule';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_cotizacion', 'id_insumo', 'fecha','hora', 'approved', 'id_doctor','id_consultorio','id_cita'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getHours($fecha,$id_medico){
        return $this->asArray()
        ->select('time_appointment')
        ->where('id_doctor',$id_medico)
        ->like('time_appointment',$fecha)
        ->findAll();
    }

    public function getMaxtime($fecha,$id_consultorio){
        return $this->asArray()
        ->selectMax('hora')
        ->where('id_consulting',$id_consultorio)
        ->where('date_appointment',$fecha)
		->findAll();
    }

    public function readAppointmentAccept($user_id){
        $sql = "SELECT appointment_schedule.id, fecha, hora, id_user_client AS id_paciente, id_cita, id_doctor, (SELECT id FROM cotization_x_products WHERE 
        cotization_x_products.id_cat_products = appointment_schedule.id_insumo AND appointment_schedule.id_cotizacion = cotization_x_products.id_cotization  AND 
        cotization_x_products.deleted_at = '0000-00-00 00:00:00') AS id_cotization_x_product,(SELECT name FROM consulting_room WHERE consulting_room.id = id_consultorio) 
        AS consultorio, (SELECT user_name FROM users WHERE users.id = cotization.id_user_client) AS paciente, (SELECT status_lab FROM cotization_x_products WHERE 
        cotization_x_products.id_cat_products = appointment_schedule.id_insumo AND appointment_schedule.id_cotizacion = cotization_x_products.id_cotization AND 
        cotization_x_products.deleted_at = '0000-00-00 00:00:00') AS status_lab, (SELECT name FROM cotization_x_products JOIN status_laboratory ON cotization_x_products.status_lab = 
        status_laboratory.id WHERE cotization_x_products.status_lab = status_laboratory.id AND cotization_x_products.id_cat_products = appointment_schedule.id_insumo AND 
        appointment_schedule.id_cotizacion = cotization_x_products.id_cotization AND cotization_x_products.deleted_at = '0000-00-00 00:00:00') AS status_name FROM appointment_schedule 
        JOIN cotization ON cotization.id = appointment_schedule.id_cotizacion WHERE id_doctor = :id_doctor: AND approved != :approved: AND show_cotization = 1";
        $datos = $this->db->query($sql, ['id_doctor' => $user_id, 'approved' => 3]);
        return $datos->getResult();
    }

    public function readAppointmentMuestras(){
        $sql = "SELECT appointment_schedule.id, fecha, hora, approved, (SELECT hcv_specialtytype.name FROM hcv_specialtytype JOIN hcv_identity_operativo ON 
        hcv_specialtytype.id = hcv_identity_operativo.disciplina_id WHERE hcv_identity_operativo.user_id = id_doctor) AS tipo_consulta, (SELECT name 
        FROM consulting_room WHERE consulting_room.id = id_consultorio) AS consultorio, (SELECT user_name FROM users WHERE users.id = 
        cotization.id_user_client) AS paciente FROM appointment_schedule JOIN cotization ON cotization.id = appointment_schedule.id_cotizacion 
        WHERE id_doctor = :id_doctor: AND approved = :approved: AND show_cotization = 1";
        $datos = $this->db->query($sql, ['id_doctor' => 0, 'approved' => 0]);
        return $datos->getResult();
    }
 
    // Consulta para traer el los datos de la citas que ha tenido el paciente
    public function readAppointmentPacient($user_id){
        $sql = "SELECT appointment_schedule.id, fecha, hora, (SELECT hcv_specialtytype.name FROM hcv_specialtytype JOIN hcv_identity_operativo ON 
        hcv_specialtytype.id = hcv_identity_operativo.disciplina_id WHERE hcv_identity_operativo.user_id = id_doctor) AS tipo_consulta, (SELECT 
        status_lab FROM cotization_x_products WHERE cotization_x_products.id_cat_products = appointment_schedule.id_insumo AND 
        appointment_schedule.id_cotizacion = cotization_x_products.id_cotization  AND cotization_x_products.deleted_at = '0000-00-00 00:00:00') AS status_lab, (SELECT status_name FROM cotization_x_products WHERE cotization_x_products.id_cat_products = appointment_schedule.id_insumo AND 
        appointment_schedule.id_cotizacion = cotization_x_products.id_cotization  AND cotization_x_products.deleted_at = '0000-00-00 00:00:00') AS status_name, (SELECT name 
        FROM consulting_room WHERE consulting_room.id = id_consultorio) AS consultorio, (SELECT user_name FROM users WHERE users.id = 
        appointment_schedule.id_doctor) AS doctor FROM appointment_schedule JOIN cotization ON cotization.id = appointment_schedule.id_cotizacion 
        WHERE cotization.id_user_client = :id_patient: AND show_cotization = 1 AND cotization.deleted_at = '0000-00-00 00:00:00' AND
        appointment_schedule.deleted_at = '0000-00-00 00:00:00' HAVING status_lab >= 200";
        $datos = $this->db->query($sql, ['id_patient' => $user_id]);
        return $datos->getResult();
    }

    //Resultado de la busqueda de historial de consultas medico-paciente
      public function getBusqueda($sql){
        $datos = $this->db->query($sql, ['approved' => 1]);
        return $datos->getResult();
    }  


    public function readHistorial($id_paciente, $disciplina){
        $sql = "SELECT appointment_schedule.id, fecha, hora, id_user_client, id_cita, id_doctor, (SELECT disciplina_id FROM hcv_identity_operativo WHERE 
        hcv_identity_operativo.user_id = id_doctor) AS tipo_consulta, (SELECT name FROM consulting_room WHERE consulting_room.id = id_consultorio) AS 
        consultorio, (SELECT user_name FROM users WHERE users.id = appointment_schedule.id_doctor) AS doctor FROM appointment_schedule JOIN cotization 
        ON cotization.id = appointment_schedule.id_cotizacion WHERE id_user_client = :id_paciente: AND approved = :approved: AND show_cotization = 1 AND cotization.deleted_at = 
        '0000-00-00 00:00:00' HAVING tipo_consulta = :disciplina:";
        $datos = $this->db->query($sql, ['id_paciente' => $id_paciente, 'approved' => 3, 'disciplina' => $disciplina]);
        return $datos->getResult();
    }

    public function getPaciente($id_appointment){
        return $this->asArray()
        ->select('cotization.id_user_client')
        ->join('cotization', 'appointment_schedule.id_cotizacion = cotization.id')
        ->where('appointment_schedule.id_cita', $id_appointment)
        ->findAll();
    }
}
?>