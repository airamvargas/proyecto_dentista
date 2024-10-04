<?php

/* Desarrollador: Airam Vargas
Fecha de creacion:
Fecha de Ultima Actualizacion: 22 - 08 -2023 por Airam Vargas
Perfil: Administrador
Descripcion: Se agrego tipo de muestra, contenedor y volumen en las datos del estudio */

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class Cat_studies extends Model {

    protected $table      = 'cat_studies';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_category_lab', 'preparation', 'id_container', 'id_muestra', 'sample_volume', 'n_labels', 'dias_entrega', 'dias_proceso', 'tiempo_entrega', 'costo_proceso', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function readStudies($sql){
        return $this->db->query($sql)->getResult();
    }

    public function readStudy($id){
        $sql = "SELECT (SELECT id FROM insumos WHERE name_table LIKE '%cat_studies%' AND cat_studies.id = insumos.id_product) AS id, id AS id_product, 
        cat_studies.preparation, cat_studies.id_container, cat_studies.sample_volume, n_labels, cat_studies.id_muestra, (SELECT name FROM insumos WHERE name_table LIKE '%cat_studies%' AND cat_studies.id = insumos.id_product) 
        AS study, cat_studies.id_category_lab, (SELECT id_category FROM insumos WHERE name_table LIKE '%cat_studies%'AND cat_studies.id = 
        insumos.id_product) AS id_category, (SELECT cita FROM insumos WHERE name_table LIKE '%cat_studies%'AND cat_studies.id = 
        insumos.id_product) AS cita, (SELECT duration FROM insumos WHERE name_table LIKE '%cat_studies%' AND cat_studies.id = insumos.id_product)
        AS duration, dias_entrega, dias_proceso, tiempo_entrega FROM cat_studies WHERE cat_studies.id = :id: AND cat_studies.deleted_at = '0000-00-00 00:00:00'";
        $datos = $this->db->query($sql, ['id' => $id]);
        return $datos->getResult();
    }

    public function readStudiesAuto($busqueda, $category){
        return $this->asObject()
        ->select('cat_studies.id AS id_product, cat_studies.preparation, insumos.name AS study')
        ->join('insumos', 'insumos.id_product = cat_studies.id')
        ->like('insumos.name_table', 'cat_studies')   
        ->like('insumos.name', $busqueda)
        ->like("cat_studies.deleted_at","0000-00-00 00:00:00")
        ->where('id_category_lab', $category)
        ->findAll(100);
    }
}

?>