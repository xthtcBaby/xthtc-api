<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CKelasDsn extends ResourceController
{
    protected $modelName = 'App\Models\MKelasDsn';
    protected $format    = 'json';
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function show($idDosen = null)
    {
        $whr = [
            'id_dosen' => $idDosen
        ];

        $cek = $this->model->where($whr)->findAll();

        if ($cek) {
            $message = "OK";
            $data = $cek;
            $code = 200;
        }
        else{
            $message = "Belum memiliki kelas";
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
