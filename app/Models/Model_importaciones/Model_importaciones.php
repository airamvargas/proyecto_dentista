<?php namespace App\Models;

	use CodeIgniter\Model;

	class Model_importaciones extends Model {

		protected $table="importaciones";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=false;
		protected $allowedFields=['numero_importacion', 'id_cotization_x_product', 'id_cliente', 'name_maquina', 'modelo', 'id_proveedor', 
            'domicilio_entrega', 'puerto_origen', 'puerto_destino', 'fecha_zarpe', 'fecha_llegada', 'bill_of_lading', 'invoice', 
            'packing_list', 'tipo_carga', 'largo', 'ancho', 'alto', 'peso', 'fraccion_arancelaria', 'total_pagado', 'real_importacion', 
            'saldo', 'monto_declarado', 'costo_maritimo', 'costo_terrestre', 'pedimento', 'documentos_impo'
        ];
		protected $useTimestamps=false;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;

		public function get_import(){
			return $this->asArray()
            ->select('importaciones.id, numero_importacion, name_maquina, modelo, puerto_origen, tipo_carga, fecha_zarpe, fecha_llegada,
				proveedor.name_proveedor, clients_data.razon_social')
            ->join('proveedor', 'proveedor.id_proveedor = importaciones.id_proveedor')
			->join('clients_data', 'clients_data.id_user = importaciones.id_cliente')
            ->findAll();
		}

		public function get_datos_uptade($id){
			return $this->asArray()
			->select('*, importaciones.id as id_import, proveedor.name_proveedor, cat_products.file_path')
			->join('cotization_x_products','cotization_x_products.id = importaciones.id_cotization_x_product')
			->join('proveedor', 'proveedor.id_proveedor = importaciones.id_proveedor')
			->join('cat_products','cat_products.id = cotization_x_products.id_cat_products')
			->where('importaciones.id', $id)
			->find();
		}

		public function get_docts($id){
			return $this->asArray()
			->select('bill_of_lading, invoice, packing_list, pedimento, documentos_impo')
			->where('id', $id)
			->findAll();
		}
    }

    