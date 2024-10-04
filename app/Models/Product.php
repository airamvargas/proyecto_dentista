<?php 


    namespace App\Models;
    use CodeIgniter\Model;

    class Product extends Model{

        protected $table      = 'cat_products';
        protected $primaryKey = 'id';
        protected $useAutoIncrement = true;
        protected $returnType     = 'array';
        protected $useSoftDeletes = true;
        protected $allowedFields = ['description','media_path', 'stock', 'created_at', 'updated_at', 'deleted_at'];  
        protected $useTimestamps = true;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';
        protected $validationRules    = [];
        protected $validationMessages = [];
        protected $skipValidation     = false;

        public function read($sql_data){
            return $this->db->query($sql_data)->getResult();
        }

        public function readUpdate($id){
            $sql = "SELECT (SELECT id FROM insumos WHERE name_table LIKE '%cat_products%' AND cat_products.id = insumos.id_product) AS id, id AS id_product, 
            cat_products.description, media_path, stock, (SELECT name FROM insumos WHERE name_table LIKE '%cat_products%' AND cat_products.id = 
            insumos.id_product) AS producto, (SELECT id_category FROM insumos WHERE name_table LIKE '%cat_products%' AND cat_products.id = 
            insumos.id_product ) AS id_category, (SELECT cita FROM insumos WHERE name_table LIKE '%cat_products%' AND cat_products.id = 
            insumos.id_product ) AS cita, (SELECT id_discipline FROM medical_consultation_setup WHERE name_table LIKE '%cat_products%' AND 
            id_product = :id:) AS id_discipline, (SELECT duration FROM insumos WHERE name_table LIKE '%cat_products%' AND cat_products.id = 
            insumos.id_product) AS duration FROM cat_products WHERE cat_products.id = :id: AND cat_products.deleted_at = '0000-00-00 00:00:00'";
            $datos = $this->db->query($sql, ['id' => $id]);
            return $datos->getResult();
        }

        public function readProducts($busqueda){
            return $this->asObject()
            ->select('id, name')
            ->like('name', $busqueda)    
            ->like("deleted_at","0000-00-00 00:00:00")
            ->findAll(100);
        }

    }
?>    