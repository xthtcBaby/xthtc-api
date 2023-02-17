<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CVPenelitianDosen extends ResourceController
{
    protected $modelName = 'App\Models\MVPenelitianDosen';
    protected $format    = 'json';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $cek = $this->model->findAll();

        if ($cek) {
            $message = "OK";
            $data = $cek;
            $code = 200;
        }
        else{
            $message = "Belum ada penelitian dosen";
            $data = null;
            $code = 400;
        }

        $res = [
            "message" => $message,
            "data" => $data
        ];
        
        return $this->respond($res, $code);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $cek = $this->model->find($id);

        if ($cek) {
            $message = "OK";
            $data = $cek;
            $code = 200;
        }
        else{
            $message = "Penelitian dosen tidak ditemukan";
            $data = null;
            $code = 400;
        }

        $res = [
            "message" => $message,
            "data" => $data
        ];
        
        return $this->respond($res, $code);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function showByNid($nid = null)
    {
        $whr = [
            'nid' => $nid
        ];  
        
        $cek = $this->model->where($whr)->findAll();

        if ($cek) {
            $message = "OK";
            $data = $cek;
            $code = 200;
        }
        else{
            $message = "Penelitian dosen tidak ditemukan";
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
