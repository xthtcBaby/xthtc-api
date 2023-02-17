<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CAnggotaKelas extends ResourceController
{
    protected $modelName = 'App\Models\MAnggotaKelas';
    protected $format    = 'json';

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id_kelas = null)
    {
        $whr = [
            'id_kelas' => $id_kelas,
        ];

        $cek = $this->model->where($whr)->findAll();

        if ($cek) {
            $message = "OK";
            $data = $cek;
            $code = 200;
        }
        else{
            $message = "Belum ada anggota kelas";
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
