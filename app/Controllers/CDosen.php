<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CDosen extends ResourceController
{
    protected $modelName = 'App\Models\MDosen';
    protected $format    = 'json';
    protected $helpers = ['form'];

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $dataDsn = $this->model->findAll();
        $message = "OK";
        $code = 200;
        $res = [
            "message" => $message,
            "data" => $dataDsn
        ];
        
        return $this->respond($res, $code);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($nid = null)
    {
        $whr = [
            'nid' => $nid
        ];

        $dataDsn = $this->model->where($whr)->find();
        if ($dataDsn) {
            $message = "OK";
            $dataDsn = $dataDsn[0];
            $code = 200;
        }
        else{
            $message = "Data dosen tidak ditemukan.";
            $dataDsn = NULL;
            $code = 400;
        }
        $res = [
            "message" => $message,
            "data" => $dataDsn
        ];
        
        return $this->respond($res, $code);
    }

    public function newDosen($nid)
    {
        $whr = [
            'nid' => $nid
        ];

        $cekDsn = $this->model->where($whr)->find();
        if(!$cekDsn){
            $dataInsert = [
                'nid' => $nid,
                'nama' => esc($this->request->getVar('nama')),
                'tempat_lahir' => esc($this->request->getVar('tempat_lahir')),
                'tgl_lahir' => esc($this->request->getVar('tgl_lahir')),
                'jenis_kelamin'=> esc($this->request->getVar('jenis_kelamin')),
                'agama' => esc($this->request->getVar('agama')),
                'nik' => esc($this->request->getVar('nik')),
                'foto' => esc($this->request->getVar('foto'))
            ];

            $insert = $this->model->insert($dataInsert,false);

            if ($insert) {
                $message = "OK";
                $code = 200;
            }
            else{
                $message = "Gagal menambah data diri";
                $code = 400;
            }
        }
        else{
            $message = "Data diri telah diisi";
            $code = 400;
        }

        $res = [
            "message" => $message,
        ];
        
        return $this->respond($res, $code);
    }

    public function edit($nid = null)
    {
        $whr = [
            'nid' => $nid
        ];

        $cekDsn = $this->model->where($whr)->find();
        if($cekDsn){
            $dataUpdate = [
                'nama' => esc($this->request->getVar('nama')),
                'tempat_lahir' => esc($this->request->getVar('tempat_lahir')),
                'tgl_lahir' => esc($this->request->getVar('tgl_lahir')),
                'jenis_kelamin'=> esc($this->request->getVar('jenis_kelamin')),
                'agama' => esc($this->request->getVar('agama')),
                'nik' => esc($this->request->getVar('nik'))
            ];

            $id = $cekDsn[0]['id_dosen'];
            $update = $this->model->update($id,$dataUpdate);;

            if ($update) {
                $message = "OK";
                $code = 200;
            }
            else{
                $message = "Gagal mengubah data diri";
                $code = 400;
            }
        }
        else{
            $message = "Periksa NID kembali";
            $code = 400;
        }

        $res = [
            "message" => $message,
        ];
        
        return $this->respond($res, $code);
    }

    public function uploadFoto($nid)
    {
        $whr = [
            'nid' => $nid
        ];

        $cekDsn = $this->model->where($whr)->find();

        if($cekDsn){
            $validationRule = [
                'fotoDsn' => [
                    'label' => 'Foto',
                    'rules' => 'uploaded[fotoDsn]'
                        . '|is_image[fotoDsn]'
                        . '|mime_in[fotoDsn,image/jpg,image/jpeg]'
                        . '|max_size[fotoDsn,30003]',
                    'errors' => [
                        'uploaded' => '{field} gagal diupload.',
                        'is_image' => '{field} bukan berupa gambar.',
                        'mime_in' => '{field} bukan berupa JPG/JPEG.',
                    ]
                ],
            ];
    
            if (! $this->validate($validationRule)) {
                $data = ['errors' => $this->validator->getErrors()];
                return $this->respond($data, 400);
            }
    
            $img = $this->request->getFile('fotoDsn');
    
            if (! $img->hasMoved()) {
                $newName = $img->getRandomName();
                $filepath = WRITEPATH . 'uploads/img/dsn/profile/';
                $img->move($filepath,$newName);
                $dataUpdate = [
                    'foto' => $newName
                ];
                $gambarLama = $cekDsn[0]['foto'];
                if (isset($gambarLama)) {
                    unlink(WRITEPATH . 'uploads/img/dsn/profile/' . $gambarLama);
                }
                $id = $cekDsn[0]['id_dosen'];
                $this->model->update($id,$dataUpdate);

                $res = [
                    "message" => "OK",
                ];
                return $this->respond($res, 200);
            }
    
            $data = ['errors' => 'Foto dosen telah diupload.'];
            return $this->respond($data, 400);
        }
        else{
            $message = "Periksa NID kembali";
            $code = 400;
        }

        $res = [
            "message" => $message,
        ];

        return $this->respond($res, $code);
    }
}
