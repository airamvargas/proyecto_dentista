<?php namespace App\Models;

use CodeIgniter\Model;

class Cat_custom_sector extends Model {

	protected $table      = 'hcv_cat_cp_custom';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id','id_hcv_cat_cp', 'id_hcv_cat_sector', 'deleted_at'];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

	public function get_sector($id_cp){
		return $this->asArray()
		->select('hcv_cat_cp_custom.id,hcv_cat_sector.name')
		->join('hcv_cat_sector', 'hcv_cat_sector.id = hcv_cat_cp_custom.id_hcv_cat_sector')
		->where('hcv_cat_cp_custom.id_hcv_cat_cp',$id_cp)->findall();
	}

	public function get_custom($id){
		return $this->asArray()
		->select(' hcv_cat_cp_custom.*, hcv_cat_cp.CP, hcv_cat_sector.description')
		->join('hcv_cat_cp', 'hcv_cat_cp.ID = hcv_cat_cp_custom.id_hcv_cat_cp ')
		->join('hcv_cat_sector', 'hcv_cat_sector.id = hcv_cat_cp_custom.id_hcv_cat_sector')
		->where('hcv_cat_cp_custom.id',$id)->find();
	}

	
	

}