<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CVKelas extends ResourceController
{
    protected $modelName = 'App\Models\MVKelas';
    protected $format    = 'json';
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $dataKelas = $this->model->findAll();
        $message = "OK";
        $code = 200;
        $res = [
            "message" => $message,
            "data" => $dataKelas
        ];
        
        return $this->respond($res, $code);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($kodeKelas = null)
    {
        $whr = [
            'kode_kelas' => $kodeKelas
        ];

        $cek = $this->model->where($whr)->findAll();

        if ($cek) {
            $message = "OK";
            $data = $cek;
            $code = 200;
        }
        else{
            $message = "Kelas tidak dapat ditemukan.";
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
