<?php

    namespace App\Models;

    use CodeIgniter\Model;




    class Model_Clientes extends Model
    {
        public function get_clientes(){
            $db = \Config\Database::connect();
            $builder = $db->table('users');
            $builder->select('users.email,clients_data.*');
            $builder->join('clients_data', 'clients_data.id_user = users.id');
            $builder->where('users.id_group', 2);
            $query = $builder->get();
            return $query->getResult();

        }

    }



?>    