
<?php

    //namespace App\Models;
    use CodeIgniter\Model;



    class Model_MarketingGraphs extends Model
    {

        public function get_leads(){
            $db = \Config\Database::connect();
            $builder = $db->table('marketing_campaigns');
            $builder->select('leads,name');
            $query = $builder->getWhere(['status' => 1]);
            return $query->getResult();

        }


        public function get_activo(){
            $db = \Config\Database::connect();
            $builder = $db->table('marketing_campaigns');
            $builder->select('name,status');
            $query = $builder->getWhere(['status' => 1]);
            return $query->getResult();

        }

        public function best_camping(){
            $db = \Config\Database::connect();
            $builder = $db->table('marketing_campaigns');
            $builder->select('name,leads');
            $builder->orderBy('leads', 'DESC');
            $builder->limit(4);
            $query   = $builder->get();
            return $query->getResult();


        }

        public function worse_camping(){
            $db = \Config\Database::connect();
            $builder = $db->table('marketing_campaigns');
            $builder->select('name,leads');
            $builder->orderBy('leads', 'ASC');
            $builder->limit(4);
            $query   = $builder->get();
            return $query->getResult();

        }
    }            
?>    