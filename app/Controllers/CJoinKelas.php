<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CJoinKelas extends ResourceController
{
    
    protected $modelName = 'App\Models\MJoinKelas';
    protected $format    = 'json';

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $dataInsert = [
            'id_mahasiswa' => esc($this->request->getVar('id_mahasiswa')),
            'id_kelas' => esc($this->request->getVar('id_kelas')),
        ];

        $insert = $this->model->insert($dataInsert);

        if ($insert) {
            $message = "OK";
            $code = 200;
        }
        else{
            $message = "Gagal bergabung di kelas";
            $code = 400;
        }

        $res = [
            "message" => $message,
        ];
        
        return $this->respond($res, $code);
    }

    public function cekJoin($idMahasiswa = null, $idKelas = null)
    {
        $whr = [
            'id_mahasiswa' => $idMahasiswa,
            'id_kelas' => $idKelas
        ];

        $cek = $this->model->where($whr)->findAll();

        if ($cek) {
            $message = "Telah bergabung di kelas";
            $code = 200;
        }

        else{
            $message = "Belum bergabung di kelas";
            $code = 200;
        }

        $res = [
            "message" => $message,
        ];
        
        return $this->respond($res, $code);
    }
}
