<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CJawaban extends ResourceController
{
    protected $modelName = 'App\Models\MJawaban';
    protected $format    = 'json';

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function jawab($id_post = null)
    {
        $validationRule = [
            'file_jawaban' => [
                'label' => 'File Jawaban',
                'rules' => 'uploaded[file_jawaban]'
                    . '|max_size[file_jawaban,1500]',
                'errors' => [
                    'uploaded' => '{field} gagal diupload.',
                    'max_size' => 'ukuran maksimal {field} adalah 1,5Mb'
                ]
            ],
        ];

        if (! $this->validate($validationRule)) {
            $data = ['errors' => $this->validator->getErrors()];
            return $this->respond($data, 400);
        }

        $file = $this->request->getFile('file_jawaban');

        if (! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $filepath = WRITEPATH . 'uploads/jawaban/mhs/';
            $file->move($filepath,$newName);

            $dataInsert = [
                'id_post' => esc($id_post),
                'id_mahasiswa' => esc($this->request->getVar('id_mahasiswa')),
                'waktu_pengumpulan' => date("Y-m-d H:i:s"),
                'nilai_jawaban' => null,
                'file_jawaban' => $newName,
                'nama_asli' => $file->getClientName()
            ];
    
            $insert = $this->model->insert($dataInsert);
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
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id_jawaban = null)
    {
        $cekJawaban = $this->model->find($id_jawaban);
        if ($cekJawaban) {
            $validationRule = [
                'file_jawaban' => [
                    'label' => 'File Jawaban',
                    'rules' => 'uploaded[file_jawaban]'
                        . '|max_size[file_jawaban,1500]',
                    'errors' => [
                        'uploaded' => '{field} gagal diupload.',
                        'max_size' => 'ukuran maksimal {field} adalah 1,5Mb'
                    ]
                ],
            ];
    
            if (! $this->validate($validationRule)) {
                $data = ['errors' => $this->validator->getErrors()];
                return $this->respond($data, 400);
            }
    
            $file = $this->request->getFile('file_jawaban');
    
            if (! $file->hasMoved()) {
                $newName = $file->getRandomName();
                $filepath = WRITEPATH . 'uploads/jawaban/mhs/';
                $file->move($filepath,$newName);
    
                $dataUpdate = [
                    'file_jawaban' => $newName,
                    'nama_asli' => $file->getClientName()
                ];

                $fileLama = $cekJawaban['file_jawaban'];
                if (isset($fileLama)) {
                    unlink(WRITEPATH . 'uploads/jawaban/mhs/' . $fileLama);
                }
                $this->model->update($id_jawaban,$dataUpdate);
                $res = [
                    "message" => "OK",
                ];
                $code = 200;
            }
        }
        else {
            $res = [
                "message" => "Jawaban tidak ditemukan",
            ];
            $code = 400;
        }
        return $this->respond($res, $code);
    }

    public function nilai($id_jawaban = null)
    {
        $cekJawaban = $this->model->find($id_jawaban);
        if ($cekJawaban) {
            $dataUpdate = [
                'nilai_jawaban' => $this->request->getVar('nilai_jawaban'),
            ];
            $procNilai = $this->model->update($id_jawaban,$dataUpdate);

            if ($procNilai) {
                $res = [
                    "message" => "OK",
                ];
                $code = 200;
            }
            else{
                $res = [
                    "message" => "Penilaian gagal",
                ];
                $code = 400;
            }
        }
        else {
            $res = [
                "message" => "Jawaban tidak ditemukan",
            ];
            $code = 400;
        }
        return $this->respond($res, $code);
    }
}
