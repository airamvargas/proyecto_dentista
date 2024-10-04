<?php
/*
Desarrollador: Jesus Esteban Sanchez Alcantara
Fecha Creacion: 16-agosto-2023
Fecha de Ultima Actualizacion: 17-agosto-2023
Perfil: Administracion
Descripcion: Catalogo de preguntas
*/

namespace App\Controllers\Api\Catalogos\Laboratorio;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Catalogos\Laboratorio\Preguntas as model;
use App\Models\Catalogos\Laboratorio\Preguntas_valores as opciones;

helper('Acceso');

class Preguntas extends ResourceController
{
    use ResponseTrait;
    var $db;
    var $model;
    var $opciones;

    public function __construct()
    {
        //Assign global variables
        $this->db = db_connect();
        $this->model = new model();
        $this->opciones = new opciones();
        helper('messages');
    }

    //show data on tables
    public function read()
    {
        $preguntas = $this->model->getQuestions();
        $valores = $this->opciones->findAll();
        $columna = null;
        foreach($preguntas as $key=>$question){
           foreach($valores as $value){
            if($question['id'] == $value['id_questions']){
                $columna = $columna.$value['name']."," ." ";
            }
           }
           array_push($preguntas[$key],['values'=>$columna]);  
           $columna = null;
        }
       
        $data['data'] = $preguntas;
        return $this->respond($data);  
    }

    //create a new element
    public function create()
    {
        $request = \Config\Services::request();
        // Uso de explode para obtener los valores del select por separado
        $tipo = explode('|', $_POST['respuesta']);
        $tipo_valor = $tipo[0];
        $tipo_nombre = $tipo[1];
        // Data donde se guarda pregunta y tipo de respuesta
        $data = [
            'question' => $request->getPost('pregunta'),
            'type_name' => $tipo_nombre,
            'type' => $tipo_valor
        ];
        $id = $this->model->insert($data);

        if ($id) {
            if ($tipo_valor != 1) {
                $long = count($_POST["value_checkbox"]);
                //Recorrer el arreglo de respuestas de checkbox
                for ($i = 0; $i <= $long - 1; $i++) {
                    $opcion = $request->getPost('value_checkbox')[$i];
                    //Arreglo para guardar mas de una respuesta de checkbox
                    $data_checkbox = [
                        'name' => $opcion,
                        'id_questions' => $id
                    ];
                    $this->opciones->insert($data_checkbox);
                }
                $mensaje = messages($insert = 0, $id);
                return $this->respond($mensaje);
            } else {
                $mensaje = messages($insert = 0, $id);
                return $this->respond($mensaje);
            }
        } else {
            $mensaje = messages(3, 0);
            return $this->respond($mensaje);
        }
    }

    // get element to modify
    public function getPregunta()
    {
        $request = \Config\Services::request();
        $id_question = $request->getPost('id');
        $data['questions'] = $this->model->getQuestionType($id_question);
        $data['values'] = $this->opciones->getValues($id_question);
        return $this->respond($data);
    }

    //update element
    public function update_()
    {
        $request = \Config\Services::request();
        $id = $request->getVar("id");

        // Uso de explode para obtener los valores del select por separado
        $upd_tipo = explode('|', $_POST['upd_respuesta']);
        $upd_tipo_valor = $upd_tipo[0];
        $upd_tipo_nombre = $upd_tipo[1];
        // Data donde se actualoiza la pregunta y tipo de respuesta
        $data = [
            'question' => $request->getPost('upd_pregunta'),
            'type_name' => $upd_tipo_nombre,
            'type' => $upd_tipo_valor
        ];
        $this->model->update($id, $data);

        $cant = count($_POST["add_value_checkbox"]);
        
        //Recorrer el arreglo de respuestas de checkbox
        for ($i = 0; $i <= $cant - 1; $i++) {
            $new_option = $request->getPost('add_value_checkbox')[$i];
            //Arreglo para guardar mas de una respuesta de checkbox
            $data_checkbox = [
                'name' => $new_option,
                'id_questions' => $id
            ];
            if ($id != 'id') { //si el id no esta repetido inserta
                $this->opciones->insert($data_checkbox);
            }
        }


        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje;
    }

    // delete element 
    public function delete_()
    {
        $request = \Config\Services::request();
        $id_category = $request->getVar("id_delete");
        $this->model->delete($id_category);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje;
    }

    // delete element 
    public function delete_checkbox()
    {
        $request = \Config\Services::request();
        $id_check = $request->getVar("delete_check");
        //var_dump($id_check);
        $this->opciones->delete($id_check);
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($delete = 2, $affected_rows);
        return $mensaje;
    }

    public function updateQuestion()
    {
        $request = \Config\Services::request();
        $upd_tipo = explode('|', $_POST['upd_respuesta']);
        $upd_tipo_valor = $upd_tipo[0];
        $upd_tipo_nombre = $upd_tipo[1];
        $id = $request->getPost('id');
        if (isset($_POST['ids'])) {
            $ids = $_POST['ids'];
            $count = count($ids);
            if (isset($_POST['values'])) {
                $values = $_POST['values'];
            }
        }else{
            $count = 0;
        }

        $data = [
            'question' => $request->getPost('upd_pregunta'),
            'type_name' => $upd_tipo_nombre,
            'type' => $upd_tipo_valor
        ];
        $this->model->update($id, $data);

        //elemento que es de 1 a muchos
        if ($upd_tipo_valor == 2 or $upd_tipo_valor == 3) {
            
            //recorremos el arreglo de los ids
            for ($i = 0; $i <= $count - 1; $i++) {
                //validamos si existe en base para actualizar
                if ($ids[$i] > 0) {
                    $data_checkbox = [
                        'name' => $values[$i]
                    ];
                    $this->opciones->update($ids[$i], $data_checkbox);
                } else {
                    //insertmos si no existe en base
                    $data = [
                        'name' => $values[$i],
                        'id_questions' => $id
                    ];
                    $this->opciones->insert($data);
                }
            }

            $data = [
                "status" => 200,
                "msg" => "ACTUALIZADO CON EXITO"
            ];
            return $this->respond($data);
        }else{
            //si es abierto solo tiene un valor 
            $values = $this->opciones->getValues($id);
            if(count($values) > 0){
                //procedemos a eliminar los valores multi del select
                foreach($values as $key){
                    $this->opciones->delete($key['id']);
                }
                $data = [
                    "status" => 200,
                    "msg" => "ACTUALIZADO CON EXITO"
                ];
                return $this->respond($data);
            }
        }
    }

    public function deleteValue()
    {
        $id = $_POST['id'];
        $this->opciones->delete($id);

        $data = [
            "status" => 200,
            "msg" => "ELIMINADO CON EXITO"
        ];
        return $this->respond($data);
    }
}
