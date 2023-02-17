<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CJadwalMatkul extends ResourceController
{
    protected $modelName = 'App\Models\MJadwalMatkul';
    protected $format    = 'json';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $dataJadwalMatkul = $this->model->findAll();
        $message = "OK";
        $code = 200;
        $res = [
            "message" => $message,
            "data" => $dataJadwalMatkul
        ];
        
        return $this->respond($res, $code);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($idMatkul = null)
    {
        $whr = [
            'idmatkul' => $idMatkul
        ];

        $dataJadwalMatkul = $this->model->find($whr);
        $message = "OK";
        $code = 200;
        $res = [
            "message" => $message,
            "data" => $dataJadwalMatkul
        ];
        
        return $this->respond($res, $code);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function newJadwalMatku($idJadwal = null)
    {
        $dataInsert = [
            'idjadwal' => $idJadwal,
            'nama' => esc($this->request->getVar('nama')),
            'hari' => esc($this->request->getVar('hari')),
            'mulai' => esc($this->request->getVar('mulai')),
            'selesai' => esc($this->request->getVar('selesai')),
            'iddosen' => esc($this->request->getVar('iddosen')),
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
    public function update($idMatkul = null)
    {
        $dataUpdate = [
            'nama' => esc($this->request->getVar('nama')),
            'hari' => esc($this->request->getVar('hari')),
            'mulai' => esc($this->request->getVar('mulai')),
            'selesai' => esc($this->request->getVar('selesai')),
            'iddosen' => esc($this->request->getVar('iddosen')),
        ];

        $update = $this->model->update($idMatkul,$dataUpdate);

        if ($update) {
            $message = "OK";
            $code = 200;
        }
        else{
            $message = "Gagal mengubah jadwal";
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
