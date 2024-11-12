<?php

namespace App\Models\models_paciente;

use CodeIgniter\Model;

class Tratamientos_x_cita extends Model
{
    protected $table = 'tratamientos_x_cita';
    protected $primaryKey = 'id';
    protected $returnType="array";
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_cita','id_tratamiento', 'precio', 'cantidad', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function trata_x_cita($id_cita){
        return $this->asArray()
        ->select('tratamientos_x_cita.id, tratamientos.nombre AS tratamiento, tratamientos.observaciones AS observaciones, id_cita, tratamientos_x_cita.precio, cantidad')
        ->join('tratamientos', 'tratamientos.id = tratamientos_x_cita.id_tratamiento')
        ->where('tratamientos_x_cita.id_cita', $id_cita)
        ->find();
    }

    public function get_total($id_cita){
        $sql = 'SELECT SUM(precio) AS total FROM tratamientos_x_cita WHERE id_cita = :id: AND deleted_at IS NULL';
        $datos = $this->db->query($sql, ['id' => $id_cita]);
        return $datos->getResult();
    }

}