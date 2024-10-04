<?php namespace App\Models;

	use CodeIgniter\Model;

	class Model_import_x_images extends Model {

		protected $table="importaciones_x_imagenes";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=true;
		protected $allowedFields=['id_importacion', 'name',  'created_at', 'updated_at', 'deleted_at'];
		protected $useTimestamps=true;
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
			->select('*, importaciones.id, proveedor.name_proveedor, cat_products.file_path')
			->join('cotization_x_products','cotization_x_products.id = importaciones.id_cotization_x_product')
			->join('proveedor', 'proveedor.id_proveedor = importaciones.id_proveedor')
			->join('cat_products','cat_products.id = cotization_x_products.id_cat_products')
			->where('importaciones.id', $id)
			->find();
		}

		public function get_images($id){
			return $this->asArray()
			->select('importaciones_x_imagenes.id, id_importacion, name')
			->join('importaciones', 'importaciones_x_imagenes.id_importacion = importaciones.id')
			->where('importaciones_x_imagenes.id_importacion', $id)
			->findAll();
		}
    }

    