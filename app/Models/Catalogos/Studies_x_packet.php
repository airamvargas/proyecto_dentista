<?php

namespace App\Models\Catalogos;

use CodeIgniter\Model;

class Products_x_unit extends Model{
    protected $table      = 'studies_x_packet';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_packet', 'id_study', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function show($id){
        $sql = "SELECT studies_x_packet.id, (SELECT name FROM insumos WHERE name_table LIKE '%cat_packets%' AND insumos.id_product = :id:) AS packet, insumos.name 
        AS study, (SELECT name FROM cat_studies JOIN category_lab ON category_lab.id = cat_studies.id_category_lab WHERE 
        cat_studies.id = insumos.id_product) AS category_lab, cat_studies.preparation FROM studies_x_packet JOIN cat_studies ON cat_studies.id = studies_x_packet.id_study JOIN insumos ON 
        insumos.id_product = cat_studies.id WHERE studies_x_packet.id_packet = :id: AND insumos.name_table LIKE '%cat_studies%'
        AND studies_x_packet.deleted_at = '0000-00-00 00:00:00' AND insumos.deleted_at = '0000-00-00 00:00:00'";
        $datos = $this->db->query($sql, ['id' => $id]);
        return $datos->getResult();
    }

    public function sum_studies($id){
        $sql = "SELECT SUM(price) AS suma, (SELECT suma FROM cat_packets WHERE cat_packets.id = :id:) AS bandera, (SELECT price FROM cat_packets WHERE 
        cat_packets.id = :id:) AS price, (SELECT sum_price FROM cat_packets WHERE cat_packets.id = :id:) AS sum_price, (SELECT price_total FROM cat_packets 
        WHERE cat_packets.id = :id:) AS price_total, (SELECT descuento FROM cat_packets WHERE cat_packets.id = :id:) AS descuento FROM studies_x_packet JOIN cat_studies ON studies_x_packet.id_study = cat_studies.id WHERE id_packet = :id: AND 
        studies_x_packet.deleted_at = '0000-00-00 00:00:00'";
        $datos = $this->db->query($sql, ['id' => $id]);
        return $datos->getResult();
    }

    public function repetidos($id_packet, $id_study){
        $sql = "SELECT COUNT(*) AS repetido FROM studies_x_packet WHERE id_packet = :packet: AND id_study = :study: AND deleted_at = '0000-00-00 00:00:00'";
        $datos = $this->db->query($sql, ['packet' => $id_packet, 'study' => $id_study]);
        return $datos->getResult();
    }

    public function studiesPacket($id_packet){
        return $this->asArray()
        ->select('insumos.id AS id_insumo')
        ->join('cat_studies', 'cat_studies.id = studies_x_packet.id_study')
        ->join('insumos', 'insumos.id_product = cat_studies.id')
        ->where('studies_x_packet.id_packet', $id_packet)
        ->like('insumos.name_table', 'cat_studies')
        ->where('insumos.deleted_at', '0000-00-00 00:00:00')
        ->find();
    }
}

?>