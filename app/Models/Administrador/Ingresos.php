<?php

namespace App\Models\Administrador;

use CodeIgniter\Model;

class Ingresos extends Model{
    protected $table      = 'ingresos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['fecha_factura','id_cotizacion_x_producto','id_empresa','id_cliente','razon_social','concepto','moneda','tipo_cambio','importe','iva','total','fecha_pago','pdf','xml'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function get_dataTable(){
        return $this->asArray()
        ->select('ingresos.*, business.id as id_empresa, business.business_name, clients_data.razon_social as cliente')
        ->join('business', 'business.id = ingresos.id_empresa')
        ->join('clients_data', 'clients_data.id_user = ingresos.id_cliente')
        ->findAll();
    }

    public function dataIngresos ($id){
        return $this->asArray()
        ->select('ingresos.*, business.id as id_empresa, business.business_name, clients_data.razon_social as cliente')
        ->join('business', 'business.id = ingresos.id_empresa')
        ->join('clients_data', 'clients_data.id_user = ingresos.id_cliente')
        ->where('ingresos.id',$id)
        ->findAll();

    }
}





?>
