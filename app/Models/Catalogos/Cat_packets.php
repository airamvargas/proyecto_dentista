<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class Cat_packets extends Model{
    protected $table      = 'cat_packets';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['preparation', 'suma', 'sum_price', 'descuento', 'price_total', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function readPackets() {
        $sql = "SELECT (SELECT id FROM insumos WHERE name_table LIKE '%cat_packets%' AND cat_packets.id = insumos.id_product) AS id_insumo, id AS id_product, 
        cat_packets.preparation, (SELECT name FROM insumos WHERE name_table LIKE '%cat_packets%' AND cat_packets.id = insumos.id_product) 
        AS packet, (SELECT COUNT(*) FROM studies_x_packet WHERE id_packet = cat_packets.id AND studies_x_packet.deleted_at = '0000-00-00 00:00:00') 
        AS total_studies,  suma, sum_price, descuento, price_total, preparation
        FROM cat_packets WHERE cat_packets.deleted_at = '0000-00-00 00:00:00'";
        $datos = $this->db->query($sql);
        return $datos->getResult();
    }

    public function readPacket($id){
        $sql = "SELECT (SELECT id FROM insumos WHERE name_table LIKE '%cat_packets%' AND cat_packets.id = insumos.id_product) AS id_insumo, id AS id_product, 
        cat_packets.preparation, (SELECT name FROM insumos WHERE name_table LIKE '%cat_packets%' AND cat_packets.id = insumos.id_product) 
        AS packet, (SELECT id_category FROM insumos WHERE name_table LIKE '%cat_studies%'AND cat_packets.id = insumos.id_product) AS id_category,
        suma, sum_price, descuento, price_total, preparation FROM cat_packets WHERE cat_packets.deleted_at = '0000-00-00 00:00:00' AND cat_packets.id = :id:";
        $datos = $this->db->query($sql, ['id' => $id]);
        return $datos->getResult();
    }
}


?>