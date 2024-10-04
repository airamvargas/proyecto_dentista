<?php
/* Desarrollador: ULISES RODRIGUEZ GARDUÑO
Fecha de creacion: 5-10-2023
Fecha de Ultima Actualizacion: 5-10-2023 por ULISES RODRIGUEZ GARDU;O
Perfil: Recepcionista
Descripcion: CONTROLADOR MUESTRAS PENDIENTES */

namespace App\Models\Tomador_muestra;

use CodeIgniter\Model;

class Citas extends Model{
    protected $table      = 'citas';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'id_cotization_x_product', 'id_study','fecha','hora',
                                'id_doctor', 'id_consultorio', 'status_lab', 'status_name'
                                ,'id_business_unit','codigo', 'imprimir'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}

?>