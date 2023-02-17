<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CVJawaban extends ResourceController
{
    protected $modelName = 'App\Models\MVJawaban';
    protected $format    = 'json';

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id_jawaban = null)
    {
        $cek = $this->model->find($id_jawaban);

        if ($cek) {
            $message = "OK";
            $data = $cek;
            $code = 200;
        }
        else{
            $message = "Jawaban tidak ditemukan";
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
    public function showByIp($id_post = null)
    {
        $whr = [
            'id_post' => $id_post,
        ];

        $cek = $this->model->where($whr)->findAll();

        if ($cek) {
            $message = "OK";
            $data = $cek;
            $code = 200;
        }
        else{
            $message = "Jawaban tidak ditemukan";
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
    public function showByIpMhs($id_post = null, $id_mahasiswa = null)
    {
        $whr = [
            'id_post' => $id_post,
            'id_mahasiswa' => $id_mahasiswa
        ];

        $cek = $this->model->where($whr)->findAll();

        if ($cek) {
            $message = "OK";
            $data = $cek;
            $code = 200;
        }
        else{
            $message = "Jawaban tidak ditemukan";
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
