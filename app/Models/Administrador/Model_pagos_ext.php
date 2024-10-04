<?php

namespace App\Models\Administrador;

use CodeIgniter\Model;

class Model_pagos_ext extends Model{
    protected $table      = 'pagos_extranjero';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['fecha', 'id_empresa', 'referencia', 'banco', 'usd', 'tipo_cambio','pesos', 'id_proveedor', 'proveedor_name', 'porciento', 'id_maquina', 'maquina_name', 'modelo', 'id_cotizaticion_x_producto', 'nombre_cliente', 'pdf', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

  
    public function get_pagos(){
        return $this->asArray()
        ->select('pagos_extranjero.id, fecha, referencia, banco, modelo, tipo_cambio, usd, pesos, porciento, pdf, nombre_cliente,
            proveedor_name, business.business_name, maquina_name')
        ->join('business', 'business.id = pagos_extranajero.id_empresa')
        ->findAll();
    }

    public function get_datos_uptade($id){
        return $this->asArray()
        ->select('pagos_extranjero.id, id_empresa, id_cotizaticion_x_producto, fecha, referencia, banco, modelo, tipo_cambio, usd, pesos, porciento, pdf, nombre_cliente,
        pagos_extranjero.id_proveedor, proveedor_name, business.business_name, id_maquina, maquina_name')
        ->join('business', 'business.id = pagos_extranjero.id_empresa')
        ->where('pagos_extranjero.id', $id)
        ->find();
    }

    public function get_doc($id){
        return $this->asArray()
        ->select('pdf')
        ->where('id', $id)
        ->findAll();
    }

    public function pagos_cliente($id){
        return $this->asArray()
        ->select('*')
        ->where('id_cotizaticion_x_producto', $id)
        ->findAll();
    }

    

}

?>