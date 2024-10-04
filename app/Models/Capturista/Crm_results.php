<?php
/* 
Desarrollador: Airam Vargas
Fecha de creacion: 13 - octubre - 2023
Fecha de Ultima Actualizacion:
Perfil: Capturista de resultados
Descripcion: Captura de resultados de los estudios x analito
*/
namespace App\Models\Capturista;

use CodeIgniter\Model;

class Crm_results extends Model{
    protected $table      = 'crm_results';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_cita', 'id_study', 'name_study', 'id_analito', 'name_analito', 'agrupador', 'answer_analito', 'id_responsible', 'edad', 'name_paciente', 'tipo_muestra', 'metodo', 'question_type', 'operator', 'referencia_min', 'referencia_max', 'unit_of_measure', 'documento', 'success', 'bandera', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

   
}

?>