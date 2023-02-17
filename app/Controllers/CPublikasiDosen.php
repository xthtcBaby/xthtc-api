<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CPublikasiDosen extends ResourceController
{
    protected $modelName = 'App\Models\MPublikasiDosen';
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
                'label' => 'File Publikasi',
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
            $filepath = WRITEPATH . 'uploads/repo/publikasiDsn/';
            $file->move($filepath,$newName);

            $dataInsert = [
                'nid' => esc($this->request->getVar('nid')),
                'judul_publikasi' => esc($this->request->getVar('judul_publikasi')),
                'tahun' => esc($this->request->getVar('tahun')),
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
            $message = "Input publikasi dosen gagal";
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
        $cekPengabdian = $this->model->find($id);

        if($cekPengabdian){
            $validationRule = [
                'file' => [
                    'label' => 'File Publikasi',
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
                $filepath = WRITEPATH . 'uploads/repo/publikasiDsn/';
                $file->move($filepath,$newName);
                $fileLama = $cekPengabdian['file'];
                if (isset($fileLama)) {
                    unlink(WRITEPATH . 'uploads/repo/publikasiDsn/' . $fileLama);
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
                $message = "Update publikasi dosen gagal";
                $code = 400;
            }
        }
        else{
            $message = "Publikasi dosen tidak ditemukan";
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
        $cekPengabdian = $this->model->find($id);

        if($cekPengabdian){
            $dataUpdate = [
                'nid' => esc($this->request->getVar('nid')),
                'judul_publikasi' => esc($this->request->getVar('judul_publikasi')),
                'tahun' => esc($this->request->getVar('tahun')),
            ];
    
            $update = $this->model->update($id,$dataUpdate);

            if ($update) {
                $message = "OK";
                $code = 200;
            }
            else{
                $message = "Update publikasi dosen gagal";
                $code = 400;
            }
        }
        else{
            $message = "Publikasi dosen tidak ditemukan";
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
        $cekPengabdian = $this->model->find($id);

        if($cekPengabdian){
            $fileLama = $cekPengabdian['file'];
            if (isset($fileLama)) {
                unlink(WRITEPATH . 'uploads/repo/publikasiDsn/' . $fileLama);
            }
            $delete = $this->model->delete($id);
    
            if ($delete) {
                $message = "OK";
                $code = 200;
            }
            else{
                $message = "Gagal menghapus publikasi";
                $code = 400;
            }
        }
        else{
            $message = "Publikasi tidak ditemukan";
            $code = 400;
        }

        $res = [
            "message" => $message
        ];
        
        return $this->respond($res, $code);
    }
}
