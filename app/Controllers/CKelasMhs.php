<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CKelasMhs extends ResourceController
{
    protected $modelName = 'App\Models\MKelasMhs';
    protected $format    = 'json';

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($idMahasiswa = null)
    {
        $whr = [
            'id_mahasiswa' => $idMahasiswa
        ];

        $cek = $this->model->where($whr)->findAll();

        if ($cek) {
            $message = "OK";
            $data = $cek;
            $code = 200;
        }
        else{
            $message = "Belum bergabung di dalam kelas";
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
