<?php

namespace App\Models;

use CodeIgniter\Model;

class Orders extends Model
{
    protected $table      = 'orders';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id',
    'product',
    'is_fragil',
    'c_date',
    'recolect_time',
    'status',
    'destination',
    'receiver',
    'c_date_receiver',
    'latitude',
    'length',
    'created_at',
    'updated_at',
    'calle_reference',
    'branch_reference',
    'phone',
    'cargo',
    'deleted_at',
    'id_branch_oficce',
    'numero_interior',
    'n_packages'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'c_date';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    //protected $validationRules    = [];
    // protected $validationMessages = [];
   // protected $skipValidation     = true;


    public function get_order($id){
       $db = \Config\Database::connect();
       $builder = $db->table('orders');
       $builder->select('orders.latitude as destinylatitude, orders.length as destinylongitude,
        branch_office.latitude AS originlatitude, branch_office.length AS originlongitude,orders.*, branch_office.*');
       $builder->join('branch_office', 'branch_office.id = orders.id_branch_oficce');
       $builder->where('orders.id', $id);
       $query = $builder->get();
       return $query->getResult();
   }

   public function get_detalle($id){
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.id as order_id , users.business_name ,  orders.latitude as destinylatitude, orders.length as destinylongitude,
        branch_office.latitude AS originlatitude, branch_office.length AS originlongitude,orders.*, branch_office.* , cat_status.name as text_status');
        $builder->join('branch_office', 'branch_office.id = orders.id_branch_oficce');
        $builder->join('cat_status', 'orders.status = cat_status.id');
        $builder->join('users', 'users.id = branch_office.id_user');
        $builder->where('orders.id', $id);
        $query = $builder->get();
        return $query->getResult();
   }

   public function get_detalle_socio($id){
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.id as FOLIO , orders.product as PAQUETE ,   cat_status.name as ESTATUS ,  branch_office.address  as ORIGEN , orders.destination as DESTINO,orders.numero_interior as NUMERO INTERIOR');
        $builder->join('branch_office', 'branch_office.id = orders.id_branch_oficce');
        $builder->join('cat_status', 'orders.status = cat_status.id');
        $builder->join('users', 'users.id = branch_office.id_user');
        $builder->where('orders.id', $id);
        $query = $builder->get();
        return $query->getResult();
    }

    public function get_detalle_orden_bo($id){
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.id as FOLIO , users.business_name as SOCIO, orders.product as PAQUETE , orders.is_fragil as Fragil , cat_status.name as ESTATUS ,  branch_office.address  as ORIGEN , orders.destination as DESTINO');
        $builder->join('branch_office', 'branch_office.id = orders.id_branch_oficce');
        $builder->join('cat_status', 'orders.status = cat_status.id');
        $builder->join('users', 'users.id = branch_office.id_user');
        $builder->where('orders.id', $id);
        $query = $builder->get();
        return $query->getResult();
    }

   public function get_orders(){
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.id as order_id , users.business_name , DATE_FORMAT(orders.c_date, "%d/%m/%Y") as Fecha , orders.c_date as Fecha_orden, orders.latitude as destinylatitude, orders.length as destinylongitude,
        branch_office.latitude AS originlatitude, branch_office.length AS originlongitude,orders.*, branch_office.* , cat_status.name as text_status');
        $builder->join('branch_office', 'branch_office.id = orders.id_branch_oficce');
        $builder->join('cat_status', 'orders.status = cat_status.id');
        $builder->join('users', 'users.id = branch_office.id_user');
        //$builder->where('orders.id', $id);
        $query = $builder->get();
        return $query->getResult();
    }

    public function get_orders_to_free(){
        // $db = \Config\Database::connect();
        // $builder = $db->table('orders');
        // $builder->select('orders.id as order_id , users.business_name , DATE_FORMAT(orders.c_date, "%d-%m-%Y") as Fecha , orders.latitude as destinylatitude, orders.length as destinylongitude,
        //  branch_office.latitude AS originlatitude, branch_office.length AS originlongitude,orders.*, branch_office.* , cat_status.name as text_status , vehicles.name as vehicle');
        // $builder->join('branch_office', 'branch_office.id = orders.id_branch_oficce');
        // $builder->join('cat_status', 'orders.status = cat_status.id');
        // $builder->join('users', 'users.id = branch_office.id_user');
        // $builder->join('order_x_vehicle', 'orders.id = order_x_vehicle.id_order');
        // $builder->join('vehicles', 'vehicles.id = order_x_vehicle.id_vehicule');
        // $builder->where('status', 5);
        // $query = $builder->get();


        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.id as order_id , users.business_name , DATE_FORMAT(orders.c_date, "%d-%m-%Y") as Fecha , orders.latitude as destinylatitude, orders.length as destinylongitude,
         branch_office.latitude AS originlatitude, branch_office.length AS originlongitude,orders.*, branch_office.* , cat_status.name as text_status ');
        $builder->join('branch_office', 'branch_office.id = orders.id_branch_oficce');
        $builder->join('cat_status', 'orders.status = cat_status.id');
        $builder->join('users', 'users.id = branch_office.id_user');
        //$builder->join('delivery_route', 'delivery_route.order_id = orders.id');
        //$builder->join('cat_route', 'cat_route.id = delivery_route.id_routes');
        //$builder->join('order_x_vehicle', 'orders.id = order_x_vehicle.id_order');
        //$builder->join('vehicles', 'vehicles.id = order_x_vehicle.id_vehicule');
        $builder->where('status', 1);
        //$builder->groupBy('delivery_route.order_id');
        $query = $builder->get();
        return $query->getResult();
    }

    public function get_orders_liberadas($excluded){
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.id as order_id , users.business_name , DATE_FORMAT(orders.c_date, "%d-%m-%Y") as Fecha , orders.latitude as destinylatitude, orders.length as destinylongitude,
         branch_office.latitude AS originlatitude, branch_office.length AS originlongitude,orders.*, branch_office.* , cat_status.name as text_status , vehicles.name as vehicle');
        $builder->join('branch_office', 'branch_office.id = orders.id_branch_oficce');
        $builder->join('cat_status', 'orders.status = cat_status.id');
        $builder->join('users', 'users.id = branch_office.id_user');
        $builder->join('order_x_vehicle', 'orders.id = order_x_vehicle.id_order');
        $builder->join('vehicles', 'vehicles.id = order_x_vehicle.id_vehicule');
        $builder->where('status', 3);
        if($excluded != ""){
            $builder->where('orders.id NOT IN ('.$excluded.')' , NULL);
        }
        
        $query = $builder->get();
        return $query->getResult();
    }

    public function get_orders_liberadas_no_car($excluded , $id_car){
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.id as order_id , users.business_name , DATE_FORMAT(orders.c_date, "%d-%m-%Y") as Fecha , orders.latitude as destinylatitude, orders.length as destinylongitude,
         branch_office.latitude AS originlatitude, branch_office.length AS originlongitude,orders.*, branch_office.* , cat_status.name as text_status , vehicles.name as vehicle');
        $builder->join('branch_office', 'branch_office.id = orders.id_branch_oficce');
        $builder->join('cat_status', 'orders.status = cat_status.id');
        $builder->join('users', 'users.id = branch_office.id_user');
        $builder->join('order_x_vehicle', 'orders.id = order_x_vehicle.id_order');
        $builder->join('vehicles', 'vehicles.id = order_x_vehicle.id_vehicule');
        $builder->where('status', 3);
        $builder->where('vehicles.id', $id_car);
        if($excluded != ""){
            $builder->where('orders.id NOT IN ('.$excluded.')' , NULL);
        }
        
        $query = $builder->get();
        return $query->getResult();
    }

    public function get_orders_transito(){
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.id as order_id , users.business_name , DATE_FORMAT(orders.c_date, "%d-%m-%Y") as Fecha , orders.latitude as destinylatitude, orders.length as destinylongitude,
         branch_office.latitude AS originlatitude, branch_office.length AS originlongitude,orders.*, branch_office.* , cat_status.name as text_status , vehicles.name as vehicle');
        $builder->join('branch_office', 'branch_office.id = orders.id_branch_oficce');
        $builder->join('cat_status', 'orders.status = cat_status.id');
        $builder->join('users', 'users.id = branch_office.id_user');
        $builder->join('order_x_vehicle', 'orders.id = order_x_vehicle.id_order');
        $builder->join('vehicles', 'vehicles.id = order_x_vehicle.id_vehicule');
        $builder->where('status=5 or status=6');
        $query = $builder->get();
        return $query->getResult();
    }

    public function get_orders_entregadas(){
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.id as order_id , users.business_name , DATE_FORMAT(orders.c_date, "%d-%m-%Y") as Fecha , orders.latitude as destinylatitude, orders.length as destinylongitude,
         branch_office.latitude AS originlatitude, branch_office.length AS originlongitude,orders.*, branch_office.* , cat_status.name as text_status , vehicles.name as vehicle');
        $builder->join('branch_office', 'branch_office.id = orders.id_branch_oficce');
        $builder->join('cat_status', 'orders.status = cat_status.id');
        $builder->join('users', 'users.id = branch_office.id_user');
        $builder->join('order_x_vehicle', 'orders.id = order_x_vehicle.id_order');
        $builder->join('vehicles', 'vehicles.id = order_x_vehicle.id_vehicule');
        $builder->where('status', 7);
        $query = $builder->get();
        return $query->getResult();
    }



   public function get_cord($id){
       $db = \Config\Database::connect();
       $builder = $db->table('delivery_route');
       $builder->select('*');
       $builder->where('id', $id);
       $query = $builder->get();
       return $query->getResult();
   }



   public function get_order_delivery($id){
       $db = \Config\Database::connect();
       $builder = $db->table('orders');
       $builder->select('orders.id,orders.product,orders.receiver,orders.latitude as olatitude,orders.length as olength,branch_office.address,branch_office.name as name_sucursal,branch_office.latitude as blatitude,branch_office.length as blength,orders.destination as destination,delivery.*');
       $builder->join('branch_office', 'branch_office.id = orders.id_branch_oficce');
       $builder->join('delivery','orders.id = delivery.id_order');
       $builder->where('orders.id', $id);
       $query = $builder->get();
       return $query->getResult();
   }


   public function get_order_without_delivery($id){
       $db = \Config\Database::connect();
       $builder = $db->table('orders');
       $builder->select('orders.id,orders.product,orders.receiver,orders.latitude as olatitude,orders.length as olength,branch_office.address,branch_office.name as name_sucursal,branch_office.latitude as blatitude,branch_office.length as blength,orders.destination as destination');
       $builder->join('branch_office', 'branch_office.id = orders.id_branch_oficce');
       $builder->where('orders.id', $id);
       $query = $builder->get();
       return $query->getResult();
   }





    public function getOrderDetail($idorder)
    {
        return $this->asArray()
            ->select('*')
            ->where('id', $idorder)
            ->findAll();
    }

    public function get_orders_in_route($id_route){
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.id as order_id , users.business_name , DATE_FORMAT(orders.c_date, "%d-%m-%Y") as Fecha , orders.latitude as destinylatitude, orders.length as destinylongitude,
         branch_office.latitude AS originlatitude, branch_office.length AS originlongitude,orders.*, branch_office.* , cat_status.name as text_status , vehicles.name as vehicle');
        $builder->join('branch_office', 'branch_office.id = orders.id_branch_oficce');
        $builder->join('cat_status', 'orders.status = cat_status.id');
        $builder->join('users', 'users.id = branch_office.id_user');
        $builder->join('delivery_route', 'delivery_route.order_id = orders.id');
        $builder->join('cat_route', 'cat_route.id = delivery_route.id_routes');
        $builder->join('order_x_vehicle', 'orders.id = order_x_vehicle.id_order');
        $builder->join('vehicles', 'vehicles.id = order_x_vehicle.id_vehicule');
        $builder->where('cat_route.id', $id_route);
        $builder->groupBy('delivery_route.order_id');
        $query = $builder->get();
        return $query->getResult();
    }

    public function updateOrderStatus($idorder)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('route');
        $builder->set('status');
        $builder->join('orders', 'route.id_order = orders.id');
        $builder->where(['orders.id' => $idorder]);
        $builder->update();
    }

    public function get_all_orders(){
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('*');
        $builder->where('deleted_at','0000-00-00 00:00:00');
        $builder->orderBy("c_date_receiver", "DESC");
        $query = $builder->get();
        return $query->getResult();
    }


    public function get_all_orders_socio($id){
    //     $db = \Config\Database::connect();
    //     $builder = $db->table('orders');
    //     $builder->select('orders.*');
    //     $builder->join('branch_office', 'orders.id_branch_oficce=branch_office.id');
    //     $builder->join('users', 'users.id=branch_office.id_user');
    //     $builder->where('users.id',$id);
    //     $builder->where('orders.deleted_at','0000-00-00 00:00:00');
    //    // $builder->orderBy("c_date_receiver", "DESC");
    //     $query = $builder->get();
    //     return $query->getResult();

    $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.id as order_id , users.business_name , DATE_FORMAT(orders.c_date, "%d-%m-%Y") as Fecha , orders.latitude as destinylatitude, orders.length as destinylongitude,
         branch_office.latitude AS originlatitude, branch_office.length AS originlongitude,orders.*, branch_office.* , cat_status.name as text_status ');
        $builder->join('branch_office', 'branch_office.id = orders.id_branch_oficce');
        $builder->join('cat_status', 'orders.status = cat_status.id');
        $builder->join('users', 'users.id = branch_office.id_user');
        //$builder->join('delivery_route', 'delivery_route.order_id = orders.id');
        //$builder->join('cat_route', 'cat_route.id = delivery_route.id_routes');
        //$builder->join('order_x_vehicle', 'orders.id = order_x_vehicle.id_order');
        //$builder->join('vehicles', 'vehicles.id = order_x_vehicle.id_vehicule');
        $builder->where('users.id',$id);
        $builder->orderBy('orders.id' , 'desc');
        //$builder->groupBy('delivery_route.order_id');
        $query = $builder->get();
        return $query->getResult();






    }


    public function get_all_orders_gestor($id){
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.*');
        $builder->join('branch_office', 'orders.id_branch_oficce=branch_office.id');
        $builder->join('managers', 'managers.id_branch_office=branch_office.id');
        $builder->join('users', 'users.id=managers.gestor_id');
        $builder->where('users.id',$id);
        $builder->where('orders.deleted_at','0000-00-00 00:00:00');
       // $builder->orderBy("c_date_receiver", "DESC");
        $query = $builder->get();
        return $query->getResult();
    }

    public function updateDelivery($id, $data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('delivery.*');
        $builder->join('delivery', 'delivery.id_order = orders.id');
        $builder->where('delivery.id_order',$id);
        $builder->update($data);
    }

    public function get_vehiculos(){
        $paciente = $this->db->query('SELECT orders.*,DATE_FORMAT(orders.c_date, "%d/%m/%Y") As Fecha,(
            SELECT order_x_vehicle.id_vehicule FROM order_x_vehicle where orders.id = order_x_vehicle.id_order lIMIT 1) AS ID_VEHICULO,
            (SELECT vehicles.name FROM vehicles where ID_VEHICULO = vehicles.id lIMIT 1) AS VEHICULO,
            (SELECT branch_office.id_user FROM branch_office where orders.id_branch_oficce = branch_office.id) AS id_user,
            (SELECT users.business_name FROM users where users.id = id_user) AS NEGOCIO,
            (SELECT order_x_vehicle.id FROM order_x_vehicle where orders.id = order_x_vehicle.id_order lIMIT 1) AS idtabla
        FROM orders where orders.status <=2 and orders.status < 3 and orders.deleted_at = "0000-00-00 00:00:00" ORDER BY orders.id  DESC 
        ');
        return $paciente->getResult();
    }


    public function get_all_orders_gestor_2($id_sucursal){
       
    
        $db = \Config\Database::connect();
            $builder = $db->table('orders');
            $builder->select('orders.id as order_id , users.business_name , DATE_FORMAT(orders.c_date, "%d-%m-%Y") as Fecha , orders.latitude as destinylatitude, orders.length as destinylongitude,
             branch_office.latitude AS originlatitude, branch_office.length AS originlongitude,orders.*, branch_office.* , cat_status.name as text_status ');
            $builder->join('branch_office', 'branch_office.id = orders.id_branch_oficce');
            $builder->join('cat_status', 'orders.status = cat_status.id');
            $builder->join('users', 'users.id = branch_office.id_user');
            //$builder->join('delivery_route', 'delivery_route.order_id = orders.id');
            //$builder->join('cat_route', 'cat_route.id = delivery_route.id_routes');
            //$builder->join('order_x_vehicle', 'orders.id = order_x_vehicle.id_order');
            //$builder->join('vehicles', 'vehicles.id = order_x_vehicle.id_vehicule');
            $builder->where('branch_office.id',$id_sucursal);
            $builder->orderBy('orders.id' , 'desc');
            //$builder->groupBy('delivery_route.order_id');
            $query = $builder->get();
            return $query->getResult();
    
    
    
    
    
    
    }

   

}