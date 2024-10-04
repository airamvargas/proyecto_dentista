<?php namespace App\Models;

	use CodeIgniter\Model;

	class Model_actividades extends Model {

		protected $table="actividades";
		protected $primaryKey="id";
		protected $returnType="array";
		protected $useSoftDeletes=true;
		protected $allowedFields=['fecha', 'rubro', 'empresa', 'actividad', 'responsable', 'concluida', 'created_at', 'updated_at', 'deleted_at'];
		protected $useTimestamps=true;
		protected $validationRules=[];
		protected $validationMessages=[];
		protected $skipValidation=false;

		public function get_datos(){
            return $this->asArray()
            ->select('actividades.id, business.marca, actividades.fecha, rubro, actividad, users.user_name,users.photo, concluida')
            ->join('business', 'actividades.empresa = business.id')
            ->join('users', 'actividades.responsable = users.id')
            ->findAll();
        }

        public function get_datos_update($id){
            return $this->asArray()
            ->select('*')
            ->where('id', $id)
            ->findAll();
        }
    }

    