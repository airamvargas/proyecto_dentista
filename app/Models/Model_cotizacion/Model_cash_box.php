<?php namespace App\Models\Model_cotizacion;

use CodeIgniter\Model;

class Model_cash_box extends Model {

	protected $table = "cash_box";
	protected $primaryKey = "id";
	protected $returnType = "array";
	protected $useSoftDeletes = true;
	protected $allowedFields = ['id_user','date_start', 'id_authorize', 'date_close', 'starting_amount', 'final_amount', 'status_caja', 'name_status','id_close_authorization', 'created_at', 'updated_at', 'deleted_at'];
	protected $useTimestamps = true;
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

	public function findCash($user_id){
        return $this->asArray()
        ->select('id, status_caja')
        ->where('id_user', $user_id)
        //->where('date_start', $date)
		->where('status_caja',1)
        ->find();
    }

	public function readChashbox($id){
		$sql = 'SELECT cash_box.*,
		(SELECT concat(identity_employed.name," ",identity_employed.first_name," ",identity_employed.second_name)  from identity_employed where id_user = cash_box.id_user ) as full_name,
		(SELECT concat(identity_employed.name," ",identity_employed.first_name," ",identity_employed.second_name)  from identity_employed where id_user = cash_box.id_authorize ) as name_autor,
		(SELECT concat(identity_employed.name," ",identity_employed.first_name," ",identity_employed.second_name)  from identity_employed where id_user = cash_box.id_close_authorization ) as name_final,
		(SELECT sum(payments.amount) from payments where id_cash_box = cash_box.id and payments.deleted_at = "0000-00-00 00:00:00") as monto_final
		FROM cash_box where cash_box.id_user =:id: and deleted_at = "0000-00-00 00:00:00"';
        $datos = $this->db->query($sql, ['id' => $id]);
        return $datos->getResult();
	}

	public function getCash($id_cash){
		$sql = 'SELECT cash_box.*,
		(SELECT concat(identity_employed.name," ",identity_employed.first_name," ",identity_employed.second_name)  from identity_employed where id_user = cash_box.id_user ) as recepcionista,
		(SELECT concat(identity_employed.name," ",identity_employed.first_name," ",identity_employed.second_name)  from identity_employed where id_user = cash_box.id_authorize ) as gerente,
		(SELECT concat(identity_employed.name," ",identity_employed.first_name," ",identity_employed.second_name)  from identity_employed where id_user = cash_box.id_close_authorization ) as name_cierre
		FROM cash_box where cash_box.id =:id:';
        $datos = $this->db->query($sql, ['id' => $id_cash]);
        return $datos->getResult();


	}
}