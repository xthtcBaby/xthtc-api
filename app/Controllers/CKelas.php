<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CKelas extends ResourceController
{
    protected $modelName = 'App\Models\MKelas';
    protected $format    = 'json';
    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function newKelas($idmatkul = null)
    {
        $kodeKelas = "xthtc ganteng".date("Y-m-d H:i:s");
        $kodeKelas = substr(sha1($kodeKelas,FALSE),0,7);

        $dataInsert = [
            'idmatkul' => $idmatkul,
            'kode_kelas' => $kodeKelas,
        ];

        $insert = $this->model->insert($dataInsert);

        if ($insert) {
            $message = "OK";
            $code = 200;
        }
        else{
            $message = "Gagal menambah kelas";
            $code = 400;
        }

        $res = [
            "message" => $message,
        ];
        
        return $this->respond($res, $code);
    }
}
