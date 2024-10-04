<?php

namespace App\Models\HCV\Operativo;

use CodeIgniter\Model;

class Disciplina extends Model {
    protected $table = 'hcv_specialtytype';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $allowedFields = ['id','name'];
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    //Nombre de las disciplina guardadas en el catalogo de rol medico
    public function get_speciality(){
        return $this->asArray()
        ->select('*')
        ->where('id between 1 and 5')
        ->findAll();
    }

    //Nombre al escoger el rol medico de laboratorio
    public function get_laboratorio(){
        return $this->asArray()
        ->select('*')
        ->where('id=6')
        ->findAll();
    }
    //Nombre al escoger el rol medico de tomador de muestras
    public function get_tomador(){
        return $this->asArray()
        ->select('*')
        ->where('id=7')
        ->findAll();
    }

}