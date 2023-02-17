<?php

namespace App\Controllers;

use App\Models\MFiles;
use CodeIgniter\RESTful\ResourceController;

class CPost extends ResourceController
{
    protected $modelName = 'App\Models\MPost';
    protected $format    = 'json';
    protected $CFiles;

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id_post = null)
    {
        $whr = [
            'id_post' => $id_post,
        ];

        $cek = $this->model->where($whr)->findAll();

        if ($cek) {
            $message = "OK";
            $data = $cek;
            $code = 200;
        }
        else{
            $message = "Postingan tidak ditemukan";
            $data = null;
            $code = 400;
        }

        $res = [
            "message" => $message,
            "data" => $data
        ];
        
        return $this->respond($res, $code);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function showByKelas($id_kelas = null)
    {
        $whr = [
            'id_kelas' => $id_kelas,
        ];

        $cek = $this->model->where($whr)->findAll();

        if ($cek) {
            $message = "OK";
            $data = $cek;
            $code = 200;
        }
        else{
            $message = "Postingan tidak ditemukan";
            $data = null;
            $code = 400;
        }

        $res = [
            "message" => $message,
            "data" => $data
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
            'judul_post' => esc($this->request->getVar('judul_post')),
            'kategori_post' => esc($this->request->getVar('kategori_post')),
            'deskripsi_post' => esc($this->request->getVar('deskripsi_post')),
            'tanggal_post' => esc($this->request->getVar('tanggal_post')),
            'tengat_post' => esc($this->request->getVar('tengat_post')),
            'id_kelas' => esc($this->request->getVar('id_kelas')),
        ];

        $insert = $this->model->insert($dataInsert);
        $files = $this->request->getFileMultiple('file_post');

        if (!empty($files)) {
            $whr = [
                'id_kelas' => $dataInsert['id_kelas']
            ];

            $dataPost = $this->model->where($whr)->orderBy('id_post','DESC')->findAll();
            $id_post = $dataPost[0]['id_post'];
            foreach ($files as $file) {
 
                if ($file->isValid() && ! $file->hasMoved())
                {
                    $newName = $file->getRandomName();
                    $file->move(WRITEPATH . 'uploads/file/post/', $newName);
                    $dataInsert = [
                        'id_post' => $id_post,
                        'nama_file' => $newName,
                        'nama_asli' => $file->getClientName(),
                    ];
                    $fileModel = new MFiles();
                    $fileModel->insert($dataInsert);
                }
                 
            }
        }

        if ($insert) {
            $message = "OK";
            $code = 200;
        }
        else{
            $message = "Buat post gagal";
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
    public function edit($id_post = null)
    {
        $dataUpdate = [
            'judul_post' => esc($this->request->getVar('judul_post')),
            'kategori_post' => esc($this->request->getVar('kategori_post')),
            'deskripsi_post' => esc($this->request->getVar('deskripsi_post')),
            'tanggal_post' => esc($this->request->getVar('tanggal_post')),
            'tengat_post' => esc($this->request->getVar('tengat_post')),
        ];

        $update = $this->model->update($id_post,$dataUpdate);

        if ($update) {
            $message = "OK";
            $code = 200;
        }
        else{
            $message = "Gagal mengupdate postingan";
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
    public function delete($id_post = null)
    {
        $delete = $this->model->delete($id_post);

        if ($delete) {
            $message = "OK";
            $code = 200;
        }
        else{
            $message = "Gagal menghapus postingan";
            $code = 400;
        }

        $res = [
            "message" => $message
        ];
        
        return $this->respond($res, $code);
    }
}
