<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CPrestasiMhs extends ResourceController
{
    protected $modelName = 'App\Models\MPrestasiMhs';
    protected $format    = 'json';

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $validationRule = [
            'sertifikat' => [
                'label' => 'Sertifikat',
                'rules' => 'uploaded[sertifikat]'
                    . '|max_size[sertifikat,3000]',
                'errors' => [
                    'uploaded' => '{field} gagal diupload.',
                    'max_size' => 'ukuran maksimal {field} adalah 3Mb'
                ]
            ],
        ];

        if (! $this->validate($validationRule)) {
            $data = ['errors' => $this->validator->getErrors()];
            return $this->respond($data, 400);
        }

        $file = $this->request->getFile('sertifikat');

        if (! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $filepath = WRITEPATH . 'uploads/repo/sertifMhs/';
            $file->move($filepath,$newName);

            $dataInsert = [
                'nim' => esc($this->request->getVar('nim')),
                'kejuaraan' => esc($this->request->getVar('kejuaraan')),
                'tingkat' => esc($this->request->getVar('tingkat')),
                'juara' => esc($this->request->getVar('juara')),
                'sertifikat' => $newName,
                'nama_asli' => $file->getClientName()
            ];
    
            $insert = $this->model->insert($dataInsert);
        }

        if ($insert) {
            $message = "OK";
            $code = 200;
        }
        else{
            $message = "Input prestasi mahasiswa gagal";
            $code = 400;
        }

        $res = [
            "message" => $message
        ];
        
        return $this->respond($res, $code);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function editFile($id = null)
    {
        $cekPrestasi = $this->model->find($id);

        if($cekPrestasi){
            $validationRule = [
                'sertifikat' => [
                    'label' => 'Sertifikat',
                    'rules' => 'uploaded[sertifikat]'
                        . '|max_size[sertifikat,3000]',
                    'errors' => [
                        'uploaded' => '{field} gagal diupload.',
                        'max_size' => 'ukuran maksimal {field} adalah 3Mb'
                    ]
                ],
            ];
    
            if (! $this->validate($validationRule)) {
                $data = ['errors' => $this->validator->getErrors()];
                return $this->respond($data, 400);
            }
    
            $file = $this->request->getFile('sertifikat');

            if (! $file->hasMoved()) {
                $newName = $file->getRandomName();
                $filepath = WRITEPATH . 'uploads/repo/sertifMhs/';
                $file->move($filepath,$newName);
                $fileLama = $cekPrestasi['sertifikat'];
                if (isset($fileLama)) {
                    unlink(WRITEPATH . 'uploads/repo/sertifMhs/' . $fileLama);
                }
                $dataUpdate = [
                    'sertifikat' => $newName,
                    'nama_asli' => $file->getClientName()
                ];
        
                $update = $this->model->update($id,$dataUpdate);
            }
    
            if ($update) {
                $message = "OK";
                $code = 200;
            }
            else{
                $message = "Update prestasi mahasiswa gagal";
                $code = 400;
            }
        }
        else{
            $message = "Prestasi mahasiswa tidak ditemukan";
            $code = 400;
        }

        $res = [
            "message" => $message
        ];
        
        return $this->respond($res, $code);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $cekPrestasi = $this->model->find($id);

        if($cekPrestasi){
            $dataUpdate = [
                'nim' => esc($this->request->getVar('nim')),
                'kejuaraan' => esc($this->request->getVar('kejuaraan')),
                'tingkat' => esc($this->request->getVar('tingkat')),
                'juara' => esc($this->request->getVar('juara')),
            ];
    
            $update = $this->model->update($id,$dataUpdate);

            if ($update) {
                $message = "OK";
                $code = 200;
            }
            else{
                $message = "Update prestasi dosen gagal";
                $code = 400;
            }
        }
        else{
            $message = "Prestasi tidak ditemukan";
            $code = 400;
        }

        $res = [
            "message" => $message
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
        $cekPrestasi = $this->model->find($id);

        if($cekPrestasi){
            $fileLama = $cekPrestasi['sertifikat'];
            if (isset($fileLama)) {
                unlink(WRITEPATH . 'uploads/repo/sertifMhs/' . $fileLama);
            }
            $delete = $this->model->delete($id);
    
            if ($delete) {
                $message = "OK";
                $code = 200;
            }
            else{
                $message = "Gagal menghapus prestasi mahasiswa";
                $code = 400;
            }
        }
        else{
            $message = "Prestasi mahasiswa tidak ditemukan";
            $code = 400;
        }

        $res = [
            "message" => $message
        ];
        
        return $this->respond($res, $code);
    }
}
