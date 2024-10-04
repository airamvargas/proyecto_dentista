<?php

namespace App\Models\Administrador;

use CodeIgniter\Model;

class Pagos extends Model{
    protected $table      = 'customer_payments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['date', 'id_cotization_x_product','concept', 'uds', 'tc','pesos', 'banco', 'proof_of_payment', 'invoice_receipt','porciento'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

   /*  public function getPagos(){
        return $this->asArray()
		->select('customer_payments.*,business.business_name,clients_data.name as cliente,cat_products.type as serie,cat_products.model,cat_products.name')
        ->join('business','business.id=customer_payments.id_bussiness')
        ->join('clients_data','clients_data.id_user=customer_payments.id_user')
        ->join('cat_products','cat_products.id = customer_payments.id_product')
        ->where('customer_payments.deleted_at','0000-00-00 00:00:00')
		->findAll();
    } */

    public function getPagos(){
        return $this->asArray()
		->select('customer_payments.*,cotization.id as idcotizacion,business.business_name,clients_data.razon_social as cliente,cat_products.type as serie,cat_products.model,cat_products.name,cat_products.id as productoid')
        ->join('cotization_x_products','cotization_x_products.id = customer_payments.id_cotization_x_product')
        ->join('cotization','cotization.id = cotization_x_products.id_cotization')
        ->join('cat_products','cat_products.id = cotization_x_products.id_cat_products')
        ->join('business','business.id = cat_products.business_id')
        ->join('clients_data','clients_data.id_user = cotization.id_user_client')
         ->orderBy('customer_payments.id','DESC')
		->findAll();
    }

    public function getPago($id){
        return $this->asArray()
        ->select('customer_payments.*,cotization.id as idcotizacion,business.business_name,clients_data.razon_social as cliente,cat_products.type as serie,cat_products.model,cat_products.name,cat_products.id as productoid')
        ->join('cotization_x_products','cotization_x_products.id = customer_payments.id_cotization_x_product')
        ->join('cotization','cotization.id = cotization_x_products.id_cotization')
        ->join('cat_products','cat_products.id = cotization_x_products.id_cat_products')
        ->join('business','business.id = cat_products.business_id')
        ->join('clients_data','clients_data.id_user = cotization.id_user_client')
        ->where('customer_payments.id',$id)
		->first();

    }

    public function pagos_cliente($id){
        return $this->asArray()
        ->select('*')
        ->where('id_cotization_x_product', $id)
        ->findAll();
    }
}

?>
