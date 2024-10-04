<?php namespace App\Models;

use CodeIgniter\Model;

class Sector extends Model {

	protected $table      = 'hcv_cat_sector';
	protected $primaryKey = 'id';

	protected $useAutoIncrement = true;

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['id','name', 'description'];

	protected $useTimestamps = false;

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;
	protected $deletedField  = 'deleted_at';



	public function get_table(){
		$db      = \Config\Database::connect();
        $builder = $db->table('hcv_cat_cp_custom');
        $builder->select('hcv_cat_cp_custom.id,hcv_cat_cp.cp, hcv_cat_sector.description,hcv_cat_cp.ESTADO,hcv_cat_cp.MUNICIPIO,hcv_cat_cp.TIPO,hcv_cat_cp.ASENTAMIENTO');
        $builder->join('hcv_cat_sector', 'hcv_cat_sector.id=hcv_cat_cp_custom.id_hcv_cat_sector');
        $builder->join('hcv_cat_cp', 'hcv_cat_cp.id=hcv_cat_cp_custom.id_hcv_cat_cp');
		$builder->where('deleted_at', null);
        $data = $builder->get()->getResultArray();
        return $data;
	}

	public function get_sector($id){
		return $this->asArray()
		->select('hcv_cat_sector.description')
		->where('id', $id)->find();
	}

	public function get_tipo_sectores(){
		return $this->asArray()
	   ->select('*')
	   ->findAll();
   }

}