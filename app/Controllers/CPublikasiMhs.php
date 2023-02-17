<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CPublikasiMhs extends ResourceController
{
    protected $modelName = 'App\Models\MPublikasiMhs';
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
                'label' => 'File',
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
            $filepath = WRITEPATH . 'uploads/repo/publikasiMhs/';
            $file->move($filepath,$newName);

            $dataInsert = [
                'nim' => esc($this->request->getVar('nim')),
                'judul_publikasi' => esc($this->request->getVar('judul_publikasi')),
                'jenis_publikasi' => esc($this->request->getVar('jenis_publikasi')),
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
            $message = "Input publikasi mahasiswa gagal";
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
        $cekPublikasi = $this->model->find($id);

        if($cekPublikasi){
            $validationRule = [
                'file' => [
                    'label' => 'File',
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
                $filepath = WRITEPATH . 'uploads/repo/publikasiMhs/';
                $file->move($filepath,$newName);
                $fileLama = $cekPublikasi['file'];
                if (isset($fileLama)) {
                    unlink(WRITEPATH . 'uploads/repo/publikasiMhs/' . $fileLama);
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
                $message = "Update publikasi mahasiswa gagal";
                $code = 400;
            }
        }
        else{
            $message = "Publikasi mahasiswa tidak ditemukan";
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
        $cekPublikasi = $this->model->find($id);

        if($cekPublikasi){
            $dataUpdate = [
                'nim' => esc($this->request->getVar('nim')),
                'judul_publikasi' => esc($this->request->getVar('judul_publikasi')),
                'jenis_publikasi' => esc($this->request->getVar('jenis_publikasi')),
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
            $message = "Publikasi tidak ditemukan";
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
        $cekPublikasi = $this->model->find($id);

        if($cekPublikasi){
            $fileLama = $cekPublikasi['file'];
            if (isset($fileLama)) {
                unlink(WRITEPATH . 'uploads/repo/publikasiMhs/' . $fileLama);
            }
            $delete = $this->model->delete($id);
    
            if ($delete) {
                $message = "OK";
                $code = 200;
            }
            else{
                $message = "Gagal menghapus publikasi mahasiswa";
                $code = 400;
            }
        }
        else{
            $message = "Publikasi mahasiswa tidak ditemukan";
            $code = 400;
        }

        $res = [
            "message" => $message
        ];
        
        return $this->respond($res, $code);
    }
}
