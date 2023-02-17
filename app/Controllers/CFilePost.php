<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CFilePost extends ResourceController
{
    protected $modelName = 'App\Models\MFiles';
    protected $format    = 'json';

   /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id_post = null)
    {
        $whr = [
            'id_post' => $id_post
        ];
        $cek = $this->model->where($whr)->findAll();

        if ($cek) {
            $message = "OK";
            $data = $cek;
            $code = 200;
        }
        else{
            $message = "No files";
            $data = null;
            $code = 400;
        }

        $res = [
            "message" => $message,
            "data" => $data
        ];
        
        return $this->respond($res, $code);
    } 
}
