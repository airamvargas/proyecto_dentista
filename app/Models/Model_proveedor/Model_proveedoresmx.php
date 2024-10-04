<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_proveedoresmx extends Model
{

    protected $table      = 'proveedoresmx';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['razon_social', 'nombre_comercial', 'rfc', 'producto_servicio', 
        'pagina_web', 'nombre_contacto', 'telefono', 'movil', 'calle', 'colonia', 'cuidad', 'estado', 
        'exterior', 'interior', 'cp', 'id_user', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function get_proveedoresmx(){
        $query = "SELECT id_user, c_date, users.business_id, (SELECT business_name FROM business WHERE business.id = business_id) AS empresa, razon_social, nombre_comercial, rfc, producto_servicio,
        pagina_web FROM users JOIN proveedoresmx ON proveedoresmx.id_user = users.id WHERE id_group = 16 AND users.deleted_at = '0000-00-00 00:00:00'";
        $query_result = $this->db->query($query);
        return $query_result->getResult();
    }

    public function get_datos($id_user){
        return $this->asArray()
        ->select('*')
        ->where('id_user', $id_user)
        ->findAll();
    }

}
