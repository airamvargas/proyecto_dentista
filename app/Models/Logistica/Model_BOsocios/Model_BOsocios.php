<?php 

    
    use CodeIgniter\Model;

    class Model_BOsocios extends Model
    {
        protected $table = 'users';
        protected $primaryKey = 'id';
        protected $useAutoIncrement = true;
        protected $returnType     = 'array';
        protected $allowedFields = ['id_group','c_date','user_name','email', 'business_name','activation_token', 'password' ,'phone', 'about'];
        protected $useTimestamps = true;
        protected $useSoftDeletes = true;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';


        public function pass($id){
            return $this->asArray()
            ->select('users.password')
            ->where('id',$id)->findAll();
        }

    }


   

    


?>    