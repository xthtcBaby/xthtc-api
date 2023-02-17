<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CPenelitianDosen extends ResourceController
{
    protected $modelName = 'App\Models\MPenelitianDosen';
    protected $format    = 'json';

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $validationRule = [
            'file' => [
                'label' => 'File Penelitian',
                'rules' => 'uploaded[file]'
                    . '|max_size[file,3000]',
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

        $file = $this->request->getFile('file');

        if (! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $filepath = WRITEPATH . 'uploads/repo/penelitianDsn/';
            $file->move($filepath,$newName);

            $dataInsert = [
                'nid' => esc($this->request->getVar('nid')),
                'judul_penelitian' => esc($this->request->getVar('judul_penelitian')),
                'tanggal' => esc($this->request->getVar('tanggal')),
                'file' => $newName,
                'nama_asli' => $file->getClientName()
            ];
    
            $insert = $this->model->insert($dataInsert);
        }

        if ($insert) {
            $message = "OK";
            $code = 200;
        }
        else{
            $message = "Input penelitian dosen gagal";
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
        $cekPenelitian = $this->model->find($id);

        if($cekPenelitian){
            $validationRule = [
                'file' => [
                    'label' => 'File Penelitian',
                    'rules' => 'uploaded[file]'
                        . '|max_size[file,3000]',
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
    
            $file = $this->request->getFile('file');

            if (! $file->hasMoved()) {
                $newName = $file->getRandomName();
                $filepath = WRITEPATH . 'uploads/repo/penelitianDsn/';
                $file->move($filepath,$newName);
                $fileLama = $cekPenelitian['file'];
                if (isset($fileLama)) {
                    unlink(WRITEPATH . 'uploads/repo/penelitianDsn/' . $fileLama);
                }
                $dataUpdate = [
                    'file' => $newName,
                    'nama_asli' => $file->getClientName()
                ];
        
                $update = $this->model->update($id,$dataUpdate);
            }
    
            if ($update) {
                $message = "OK";
                $code = 200;
            }
            else{
                $message = "Update penelitian dosen gagal";
                $code = 400;
            }
        }
        else{
            $message = "Penelitian dosen tidak ditemukan";
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
        $cekPenelitian = $this->model->find($id);

        if($cekPenelitian){
            $dataUpdate = [
                'nid' => esc($this->request->getVar('nid')),
                'judul_penelitian' => esc($this->request->getVar('judul_penelitian')),
                'tanggal' => esc($this->request->getVar('tanggal')),
            ];
    
            $update = $this->model->update($id,$dataUpdate);

            if ($update) {
                $message = "OK";
                $code = 200;
            }
            else{
                $message = "Update penelitian dosen gagal";
                $code = 400;
            }
        }
        else{
            $message = "Penelitian dosen tidak ditemukan";
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
        $cekPenelitian = $this->model->find($id);

        if($cekPenelitian){
            $fileLama = $cekPenelitian['file'];
            if (isset($fileLama)) {
                unlink(WRITEPATH . 'uploads/repo/penelitianDsn/' . $fileLama);
            }
            $delete = $this->model->delete($id);
    
            if ($delete) {
                $message = "OK";
                $code = 200;
            }
            else{
                $message = "Gagal menghapus penelitian";
                $code = 400;
            }
        }
        else{
            $message = "Penelitian dosen tidak ditemukan";
            $code = 400;
        }

        $res = [
            "message" => $message
        ];
        
        return $this->respond($res, $code);
    }
}
