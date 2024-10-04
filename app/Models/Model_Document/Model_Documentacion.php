<?php

    namespace App\Models;

    use CodeIgniter\Model;

    class Model_Documentacion extends Model
    {
        public function select_type_document()
        {
            $db = \Config\Database::connect();
            $builder = $db->table('type_files');
            $builder->select('id,type_file');
            $query = $builder->get();
            return $query->getResult();
        }

        public function insert_documentacion($type_file,$path,$id){
            foreach($type_file as $key => $n ) {
                $datafiles[] = array (
                    'type_id' => $n,
                    'name_file' => $path[$key],
                    'business_id' =>$id
                );
            } 
            
            $builder = $this->db->table('cat_files');
            $builder->insertBatch($datafiles);
  
        } 

        public function select_documents($id){
            $db = \Config\Database::connect();
            $builder = $db->table('cat_files');
            $builder->select('cat_files.name_file,type_files.type_file,cat_files.id');
            $builder->join('type_files', 'type_files.id = cat_files.type_id');
            $builder->join('business', 'business.id = cat_files.business_id');
            $builder->where('business.id', $id);
            

            $query = $builder->get();
            return $query->getResult();
        }

        public function dataempresa($id){
            //var_dump($id);
            $db = \Config\Database::connect();
            $builder = $db->table('business');
            $builder->select('*');
            $query = $builder->getWhere(['id' => $id]);
            return $query->getResult();

        }

        public function get_fle($id){
            $db = \Config\Database::connect();
            $builder = $db->table('cat_files');
            $builder->select('cat_files.name_file');
            $query = $builder->getWhere(['id' => $id]);
            return $query->getResult();

        }

        public function delete_file($id){
            $db = \Config\Database::connect();
            $builder = $db->table('cat_files');
            $builder->delete(['id' => $id]);

        }

        public function get_image($id_bussiness){
            $db = \Config\Database::connect();
            $builder = $db->table('cat_files');
            $builder->select('cat_files.name_file');
            $builder->where('business_id', $id_bussiness);
            $builder->where('type_id', 15);
            

            $query = $builder->get();
            return $query->getResult();

        }

        
    }


?>    