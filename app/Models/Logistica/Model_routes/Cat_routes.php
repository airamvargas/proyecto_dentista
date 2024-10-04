<?php namespace App\Models;

use CodeIgniter\Model;

class Cat_route extends Model {

	protected $table      = 'cat_route';
	protected $primaryKey = 'id';

	protected $useAutoIncrement = true;

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['id', 'name', 'desc','status','executed_at'];
    protected $createdField  = 'create_at';
    protected $updatedField  = 'update_at';
    protected $deletedField  = 'delete_at';

	protected $useTimestamps = true;

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;


	public function delete_from_route($id_route){
		$db = \Config\Database::connect();
		$query = "DELETE FROM `delivery_route` WHERE `id_routes`=$id_route";
		$db->query($query);
	}

	public function get_rutas_transito(){
		return $this->asArray()
		->select('cat_route.*,users.user_name,')
		->join('delivery_route', 'delivery_route.id_routes = cat_route.id','left')->distinct()
		->join('users', 'users.id = delivery_route.chofer_id')
		->where('cat_route.status', 1)->limit(1)
		->findall();

	}  

}