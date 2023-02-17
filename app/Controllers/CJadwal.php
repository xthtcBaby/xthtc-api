<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CJadwal extends ResourceController
{
    protected $modelName = 'App\Models\MJadwal';
    protected $format    = 'json';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $dataJadwal = $this->model->findAll();
        $message = "OK";
        $code = 200;
        $res = [
            "message" => $message,
            "data" => $dataJadwal
        ];
        
        return $this->respond($res, $code);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($idJadwal = null)
    {
        $whr = [
            'idjadwal' => $idJadwal
        ];

        $dataJadwal = $this->model->find($whr);
        $message = "OK";
        $code = 200;
        $res = [
            "message" => $message,
            "data" => $dataJadwal
        ];
        
        return $this->respond($res, $code);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $dataInsert = [
            'prodi' => esc($this->request->getVar('prodi')),
            'kelas' => esc($this->request->getVar('kelas')),
            'angkatan' => esc($this->request->getVar('angkatan')),
            'semester' => esc($this->request->getVar('semester')),
        ];

        $insert = $this->model->insert($dataInsert);

        if ($insert) {
            $message = "OK";
            $code = 200;
        }
        else{
            $message = "Gagal menambah jadwal";
            $code = 400;
        }

        $res = [
            "message" => $message,
        ];
        
        return $this->respond($res, $code);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($idJadwal = null)
    {
        $whr = [
            'idJadwal' =>  $idJadwal
        ];

        $cekJadwal = $this->model->find($whr);

        if ($cekJadwal) {
            $dataUpdate = [
                'prodi' => esc($this->request->getVar('prodi')),
                'kelas' => esc($this->request->getVar('kelas')),
                'angkatan' => esc($this->request->getVar('angkatan')),
                'semester' => esc($this->request->getVar('semester')),
            ];
    
            $update = $this->model->update($idJadwal,$dataUpdate);
    
            if ($update) {
                $message = "OK";
                $code = 200;
            }
            else{
                $message = "Gagal mengubah jadwal";
                $code = 400;
            }
        }
        else {
            $message = "Jadwal tidak ditemukan";
            $code = 400;
        }

        $res = [
            "message" => $message,
        ];

        return $this->respond($res, $code);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
