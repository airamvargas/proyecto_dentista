<?php 

namespace App\Controllers\Api\Back_office;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
helper('Acceso');
use App\Models\Company_data\Company_data as model;

class Business extends ResourceController 
{
    use ResponseTrait;
    var $model;
    var $db;

    public function __construct() { //Assign global variables
        $this->model = new model();
        $this->db = db_connect();
        helper('messages');
    }

    //FUNCION PARA DATATABLE
    public function readBusiness(){
        $data['data'] = $this->model->getConpany();
        return $this->respond($data);
    }
    
    //CREAR UNA EMPRESA
    public function create(){
        $total = $this->model->getData();
        $request = \Config\Services::request();
        if($total[0]->total == 1){
            $mensaje = [
                'status' => 400,
                'msg' => "YA ESTA REGISTRADA UNA EMPRESA"
            ];
        } else {
            $file = $this->request->getFile('logo');

            if (!$file->isValid()) {
                $nameImg = "";
                $imagen = false;
            } else {
                // image validation
                $validated = $this->validate([
                    'logo' => [
                        'uploaded[logo]',
                        'mime_in[logo,image/jpg,image/jpeg,image/png]',
                        'max_size[logo,4096]',
                        'is_image[logo]'
                    ],
                ]);
    
                if (!$validated) {
                    $mensaje = $this->errors($error = 600);
                    return $this->respond($mensaje);
                } else {
                    $imagen = true;
                }
            }

            if($imagen) {
                $path =  '../assets/img/';
                $nameImg = $file->getName();
                $file->move(WRITEPATH.$path, $nameImg);
            }

            $data = [
                'name' => $request->getPost('name'),
                'tel' => $request->getPost('tel'),
                'address' => $request->getPost('address'),
                'logo' => $nameImg,
                'rfc' => $request->getPost('rfc'),
                'email' => $request->getPost('email'),
                'whatsapp' => $request->getPost('whatsapp')
            ];
            $id = $this->model->insert($data);
            $mensaje = messages($insert = 0, $id);
        }
        
        return $this->respond($mensaje);
    }

    //OBTENER DATOS PARA ACTUALIZAR
    public function readUpdate(){ 
        $id = $_POST['id'];
        $data = $this->model->readUpdate($id);
        return $this->respond($data);
    }

    //EDITAR REGISTRO 
    public function update_(){ 
        $request = \Config\Services::request();

        $file = $this->request->getFile('logo');
        if (!$file->isValid()) {
            $name = $this->model->select('logo')->where('id', $request->getPost('id'))->find();
            $nameImg = $name[0]['logo'];
            $imagen = false;
        } else {
            // image validation
            $validated = $this->validate([
                'logo' => [
                    'uploaded[logo]',
                    'mime_in[logo,image/jpg,image/jpeg,image/png]',
                    'max_size[logo,4096]',
                    'is_image[logo]'
                ],
            ]);

            if (!$validated) {
                $mensaje = $this->errors($error = 600);
                return $this->respond($mensaje);
            } else {
                $imagen = true;
            }
        }

        if($imagen) {
            $path =  '../assets/img/';
            $nameImg = $file->getName();
            $file->move(WRITEPATH . $path, $nameImg);
        }


        $data = [
            'name' => $request->getPost('name'),
            'tel' => $request->getPost('tel'),
            'address' => $request->getPost('address'),
            'logo' => $nameImg,
            'rfc' => $request->getPost('rfc'),
            'email' => $request->getPost('email'),
            'whatsapp' => $request->getPost('whatsapp')
        ];

        $this->model->update($request->getPost('id'), $data);

        //retun affected rows into database
        $affected_rows = $this->db->affectedRows();
        $mensaje = messages($update = 1, $affected_rows);
        return $mensaje;
    }
}