<?php

namespace App\Controllers\Administrador;
use App\Controllers\BaseController;

class Imagenes_avance extends BaseController
{

    public function index()
    {
        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();
        //Js Scripts ['script1.js' , 'script2.js' , 'script3.js']
        $data_fotter['scripts'] = ["../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js", "dashboard.js", "Administrador/Imagenes_avance.js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css"];

        //Database
        $data_header['title'] = "Imágenes de avance";
        $data_header['description'] = "Listado de imágenes de avance";
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Administrador/Imagenes_avance');
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
    }

    public function imagenes($id){
        $model = model('App\Models\Model_cotizacion\Cotizacion');
        $name = $model->getCliente($id);
        $data['name'] = $name['razon_social'];
        $data['id'] = $id;

        helper('menu');
        $session = session();
        $data_left['menu'] = get_menu();
        //Js Scripts ['script1.js' , 'script2.js' , 'script3.js']
        $data_fotter['scripts'] = ["../lib/datatables/jquery.dataTables.js", "../lib/datatables-responsive/dataTables.responsive.js", "dashboard.js", "Administrador/Imagenes.js","Generales/Accesos.js"];
        //Css Shets
        $data_header['styles'] = ["starlight.css", "solimaq.css"];

        //Database
        $data_header['title'] = "Imagenes Avance";
        $data_header['description'] = "Main Admin";
        echo view('header', $data_header);
        echo view('left_panel', $data_left);
        echo view('head_panel');
        echo view('Administrador/Imagenes',$data);
        echo view('right_panel');
        echo view('fotter_panel', $data_fotter);
 
    }

    public function getCatimagenes(){
        $model = model('App\Models\Administrador\Cat_imagenes');
        $data = $model->select('id,name')->findAll();
        return json_encode($data);
    }

    public function insert_imagenes(){
        $model = model('App\Models\Administrador\Imagenes_avance');
        $model_pxc = model('App\Models\Model_cotization_product\cotization_product');
        $request = \Config\Services::request();
        $seccion = $request->getPost('seccion');
        $id_cotizacion = $request->getPost('id_cotizacion');
        $id_product_x_cotizacion = $model_pxc->select('id')->where('id_cotization',$id_cotizacion)->first();
        $id_product_x_cotizacion = $id_product_x_cotizacion['id'];
        $totalImg = $model->select('foto')->where('id_cotization_x_product',$id_product_x_cotizacion)->where('id_cat_imagen',$seccion)->findAll();
        $totalImagenes = count($totalImg);
        $path = "../public/ImagenesAvance/";

        if($totalImagenes < 6 ){
            $restantes = 5 - $totalImagenes;
            $files = $this->request->getFiles();
            $longitud = count($files['files']);

            if ($longitud <= $restantes) {

                for ($i = 0; $i <= $longitud - 1; $i++) {
                    if ($files['files'][$i]->isValid() && !$files['files'][$i]->hasMoved()) {
                        $newName = $files['files'][$i]->getRandomName();
                        $files['files'][$i]->move(WRITEPATH . $path, $newName);
                        $name_save = $files['files'][$i]->getName();
    
                        $data = [
                            'id_cotization_x_product' => $id_product_x_cotizacion,
                            'id_cat_imagen' => $seccion,
                            'foto' => $name_save,
                        ];
                        $model->insert($data);
                    }
                }

              $response = [
                    "status" => 200,
                    "msg" => "IMAGENES GURDADAS CORRECTAMENTE"
                ];
                return json_encode($response); 
              
                } else {

                  $response = [
                        "status" => 400,
                        "msg" => "SOLO SE PUEDEN SUBIR $restantes IMAGENES"
                    ];
                    return json_encode($response); 
                } 
            
        }else{
            $response = [
                    "status" => 400,
                    "msg" => "SE HA ALCANZADO EL LIMITE DE IMAGENES"
                ];
            return json_encode($response);
        } 
    }

    public function getImagenes(){
        $model = model('App\Models\Administrador\Imagenes_avance');
        $model_pxc = model('App\Models\Model_cotization_product\cotization_product');
        $request = \Config\Services::request();
        $id_cotizacion = $request->getPost('id_cotizacion');
        $id_product_x_cotizacion = $model_pxc->select('id')->where('id_cotization',$id_cotizacion)->first();
        $id_product_x_cotizacion = $id_product_x_cotizacion['id'];
        $data['china'] = $model->where('id_cotization_x_product',$id_product_x_cotizacion)->where('id_cat_imagen',1)->findAll();
        $data['empaque'] = $model->where('id_cotization_x_product',$id_product_x_cotizacion)->where('id_cat_imagen',2)->findAll();
        $data['placa'] = $model->where('id_cotization_x_product',$id_product_x_cotizacion)->where('id_cat_imagen',3)->findAll();
        $data['aduanas'] = $model->where('id_cotization_x_product',$id_product_x_cotizacion)->where('id_cat_imagen',4)->findAll();
        $data['cliente'] = $model->where('id_cotization_x_product',$id_product_x_cotizacion)->where('id_cat_imagen',5)->findAll();
        return json_encode($data);

    }

    public function deleteImagen(){
        $model = model('App\Models\Administrador\Imagenes_avance');
        $request = \Config\Services::request();
        $id = $request->getPost('id_delete');
        $model->delete($id);

        if($model){
            $data = [
                "status" => 200,
                "msg" => "IMAGEN ELIMINADA CON EXITO"
            ];
            return json_encode($data);

        }else{
            $data = [
                "status" => 400,
                "msg" => "ERROR AL ELIMINAR IMAGEN"
            ];
            return json_encode($data);
        } 

    }

}
