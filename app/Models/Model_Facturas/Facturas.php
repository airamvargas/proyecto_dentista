<?php

    namespace App\Models\Model_Facturas;

    use CodeIgniter\Model;

    class Facturas extends Model
    {
        protected $table      = 'facturas_provedor';
        protected $primaryKey = 'id';
        protected $useAutoIncrement = true;
        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['id_user','factura_pdf','factura_xml','fecha_upload','origen','destino',
    'concepto','importe','iva','total','fecha_pago','status'];
        protected $useTimestamps = false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';
        protected $validationRules    = [];
        protected $validationMessages = [];
        protected $skipValidation     = false;


        public function get_facturas($id){
            return $this->asArray()
            ->where('id_user',$id)
            ->findall();
        }

        public function get_fact() {
            return $this->asArray()
            ->findall();
        }

        public function get_facturas_pagadas($id){
            return $this->asArray()
            ->where('id_user',$id)
            ->where('status',1)
            ->findall();
        }

        public function get_pagar($id){
            return $this->asArray()
            ->where('id_user',$id)
            ->where('status',0)
            ->findall();
        }

        public function fecha_pago($id, $data){    
            $db = \Config\Database::connect();
            $builder = $db->table('facturas_provedor');
            $builder->set($data);
            $builder->where('id', $id);
            $builder->update();
            //UPDATE business SET $data WHERE id = $id;
        }

        public function estado($id, $data){    
            $db = \Config\Database::connect();
            $builder = $db->table('facturas_provedor');
            $builder->set($data);
            $builder->where('id', $id);
            $builder->update();
            //UPDATE business SET $data WHERE id = $id;
        }



    
    }
