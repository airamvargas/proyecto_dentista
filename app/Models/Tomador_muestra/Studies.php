<?php
/* Desarrollador: ULISES RODRIGUEZ GARDUÑO
Fecha de creacion: 5-10-2023
Fecha de Ultima Actualizacion: 5-10-2023 por ULISES RODRIGUEZ GARDU;O
Perfil: Recepcionista
Descripcion: CONTROLADOR MUESTRAS PENDIENTES */

namespace App\Models\Tomador_muestra;

use CodeIgniter\Model;

class Studies extends Model{
    protected $table      = 'cat_studies';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_category_lab', 'preparation', 'id_container', 
    'id_muestra', 'sample_volume', 'n_labels'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    
   
}

?>