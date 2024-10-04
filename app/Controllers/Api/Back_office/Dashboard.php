<?php
/*Desarrollador: José Antonio Flores
Fecha de creacion: 
Fecha de Ultima Actualizacion: 12 - 08 - 2024
Desarrollador actualizo: Airam V. Vargas
Perfil: Back Office
Descripcion:  JS de los datos del inicio*/ 

namespace App\Controllers\Api\Back_office;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Dashboard extends ResourceController
{
    use ResponseTrait;

    public function VentasXDia() {
        $model = model('App\Models\Model_cotization_product\cotization_product');
        $data = $model->totalxDia();
        return $this->respond($data, 200);
    }

    public function VentasXweek() {
        $model = model('App\Models\Model_cotization_product\cotization_product');
        $data = $model->VentasXweek();
        return $this->respond($data, 200);
    }

    public function VentasXMonth() {
        $model = model('App\Models\Model_cotization_product\cotization_product');
        $data = $model->VentasMonth();
        return $this->respond($data, 200);
    }

    public function VentasXYear() {
        $model = model('App\Models\Model_cotization_product\cotization_product');
        $data = $model->getventasYear();
        return $this->respond($data, 200);
    }

    public function graficaPastelProductos(){
        $inputJSON = $this->request->getBody();
        $input = json_decode($inputJSON, TRUE); 
        $fecha_inicial = $input['fecha_inicial'];
        $fecha_final = $input['fecha_final'];
        $model = model('App\Models\Model_cotization_product\cotization_product');
        $data = $model->graficaPastelProductos($fecha_inicial, $fecha_final);
        return $this->respond($data, 200);
    }

   

    public function graficaPastelUnidades(){
        $inputJSON = $this->request->getBody();
        $input = json_decode($inputJSON, TRUE); // Decodificar el JSON en un array asociativo

        // Obtener los valores específicos
        $fecha_inicial = $input['fecha_inicial'];
        $fecha_final = $input['fecha_final'];

        $model = model('App\Models\Model_cotization_product\cotization_product');
        $data = $model->graficaPastelUnidades($fecha_inicial, $fecha_final);
        return $this->respond($data, 200); 
    }

    public function graficaPastelConvenios(){
        $inputJSON = $this->request->getBody();
        $input = json_decode($inputJSON, TRUE); // Decodificar el JSON en un array asociativo
        // Obtener los valores específicos
        $fecha_inicial = $input['fecha_inicial'];
        $fecha_final = $input['fecha_final'];
        $model = model('App\Models\Model_cotization_product\cotization_product');
        $data = $model->graficaPastelConvenios($fecha_inicial, $fecha_final);
        return $this->respond($data, 200);
    }
}