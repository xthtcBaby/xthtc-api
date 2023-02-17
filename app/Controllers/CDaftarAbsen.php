<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CDaftarAbsen extends ResourceController
{
    protected $modelName = 'App\Models\MDaftarAbsen';
    protected $format    = 'json';

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $whr = [
            'id_kelas' => $id,
            'DAY(tgl_jam_absen)' => date("d"),
        ];

        $cek = $this->model->where($whr)->findAll();

        if ($cek) {
            $message = "OK";
            $data = $cek;
            $code = 200;
        }
        else{
            $message = "Belum ada yang melakukan absensi";
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
