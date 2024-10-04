<?php
/*
Desarrollador: Airam Valeria Vargas López
Fecha Creacion: 07 - 09 - 2023
Fecha de Ultima Actualizacion: 
Perfil: Administracion
Descripcion: Catalogo de los rangos de edades 
*/
namespace App\Models\Catalogos\Laboratorio;

use CodeIgniter\Model;

class Age_range extends Model{

    protected $table = 'crm_cat_age_range';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['min', 'max', 'description', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function showRanges(){
        return $this->asArray()
        ->findAll();
    }

    public function readRange($id){
        return $this->asArray()
        ->where('id', $id)
        ->findAll();
    }

    public function ageRange($edad){
        $rango = $this->asArray()
        ->where("$edad >= min")
        ->where("$edad <= max" )
        ->where('id !=', 1)
        ->find();

        if(empty($rango)){
            return $this->asArray()
            ->where('id',1)
            ->find();
        }else{
            return $rango;
        }
    }

    

    public function ageRange2($edad){
        return $this->asArray()
        ->where('min >=', $edad)
        ->where('min <=', $edad)
        ->where('id', 1)
        ->find();
    }

    public function rangosEdad($edad){
        $sql = "SELECT crm_cat_age_range.* FROM crm_cat_age_range WHERE :edad: between min AND max AND deleted_at IS NULL AND id != :id:";
        $query = $this->db->query($sql, ['edad' => $edad, 'id' => 1]);
        return $query->getResult();
    }

    public function getMax(){
        return $this->asArray()
        ->select('id, MAX(max) AS maximo')
        ->where('deleted_at IS NULL')
        ->where('id !=', 1)
        ->find();
    }

}