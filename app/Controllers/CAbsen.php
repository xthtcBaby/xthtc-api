<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CAbsen extends ResourceController
{
    protected $modelName = 'App\Models\MAbsen';
    protected $format    = 'json';

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $idMhs = esc($this->request->getVar('id_mahasiswa'));
        $whr = [
            'id_mahasiswa' => $idMhs,
            'day(tgl_jam_absen)' => date("d")
        ];

        $cekMhs = $this->model->where($whr)->findAll();
        if (!$cekMhs) {
            $dataInsert = [
                'id_mahasiswa' => $idMhs,
                'id_kelas' => esc($this->request->getVar('id_kelas')),
                'jenis_absen' => esc($this->request->getVar('jenis_absen')),
                'tgl_jam_absen' => date("Y-m-d H:i:s"),
            ];
    
            $insert = $this->model->insert($dataInsert);
    
            if ($insert) {
                $message = "OK";
                $code = 200;
            }
            else{
                $message = "Absen gagal";
                $code = 400;
            }
        }
        else{
            $message = "Telah melakukan absensi";
            $code = 400;
        }

        $res = [
            "message" => $message
        ];
        
        return $this->respond($res, $code);
    }
}
