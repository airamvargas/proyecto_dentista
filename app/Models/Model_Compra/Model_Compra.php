<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Compra extends Model
{
    protected $table      = 'buys';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['c_date','MODEL','SERIAL_NUMBER','CAPACITY','VOLTAGE', 'COLOR', 'OTHER', 'DELIVERY', 'price','id_compra', 'numero_oc','porcent', 'created_at', 'updated_at', 'deleted_at', 'before_Payment', 'before_Loading','advancePaymentPrice','priceBeforeLoading', 'name_file', 'product_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function get_compra(){
			
        return $this->asArray()
        ->select('buys.*')
        //->join('business', 'business.id = buys.bussiness_id')
        //->join('proveedor_x_products', 'proveedor_x_products.id = buys.pro_x_product')
        //->join('proveedor', 'proveedor.id_proveedor = proveedor_x_products.id_proveedor')
       // ->join('cat_products', 'cat_products.id = proveedor_x_products.id_product')->findAll();
        //->where('buys.deleted_at','0000-00-00 00:00:00')
        ->find();
    }

    public function get_compras($id){
        	
        return $this->asArray()
        ->select('buys.*,cat_products.name')
       //->join('business', 'business.id = buys.bussiness_id')
       // ->join('proveedor_x_products', 'proveedor_x_products.id = buys.pro_x_product')
        ->join('proveedor', 'proveedor.id_proveedor = proveedor_x_products.id_proveedor')
        //->join('cat_products', 'cat_products.id = proveedor_x_products.id_product')
        ->where('buys.id', $id)->first();
    }

    public function get_pdf_compra($id){
        return $this->asArray()
        ->select('buys.*, proveedor.contact, proveedor.name_proveedor, proveedor.phone,proveedor.email,
        proveedor.marca,cat_products.name,cat_products.ability,  cat_products.english_name, cat_products.model_china, cat_products.media_path , clients_data.razon_social, proveedor.contact, business.logo')
        ->join('cotization_x_products', 'cotization_x_products.id = buys.id_compra')
        ->join('cotization', 'cotization_x_products.id_cotization = cotization.id')
        ->join('cat_products', 'cat_products.id = cotization_x_products.id_cat_products')
        ->join('business', 'business.id = cat_products.business_id')
        ->join('proveedor', 'proveedor.id_proveedor = cat_products.proveedor_id')
        ->join('clients_data', 'clients_data.id_user = cotization.id_user_client')
        ->where('buys.id', $id)
        ->first();
    }

    public function get_buys(){
        return $this->asArray()
        ->select('buys.id, buys.c_date, numero_oc, business.business_name, clients_data.razon_social, proveedor.name_proveedor, cat_products.name,
            buys.MODEL, buys.price, buys.DELIVERY')
        ->join('cotization_x_products', 'cotization_x_products.id = buys.id_compra')
        ->join('cotization', 'cotization_x_products.id_cotization = cotization.id')
        ->join('clients_data', 'clients_data.id_user = cotization.id_user_client')
        ->join('cat_products', 'cat_products.id = buys.product_id')
        ->join('business', 'business.id = cat_products.business_id')
        ->join('proveedor', 'proveedor.id_proveedor = cat_products.proveedor_id')
        //->where('buys.deleted_at','0000-00-00 00:00:00')
        ->find();
    }



   












}