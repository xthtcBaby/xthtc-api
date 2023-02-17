<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CDetailMhs extends ResourceController
{
    protected $modelName = 'App\Models\MDetailMhs';
    protected $format    = 'json';
    protected $helpers = ['form'];

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $dataMhs = $this->model->findAll();
        $message = "OK";
        $code = 200;
        $res = [
            "message" => $message,
            "data" => $dataMhs
        ];
        
        return $this->respond($res, $code);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($nim = null)
    {
        $whr = [
            'nim' => $nim
        ];

        $dataMhs = $this->model->where($whr)->find();
        if ($dataMhs) {
            $message = "OK";
            $dataMhs = $dataMhs[0];
            $code = 200;
        }
        else{
            $message = "Data mahasiswa tidak ditemukan.";
            $dataMhs = NULL;
            $code = 400;
        }
        $res = [
            "message" => $message,
            "data" => $dataMhs
        ];
        
        return $this->respond($res, $code);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function tambahDetailMhs($nim)
    {
        $whr = [
            'nim' => $nim
        ];

        $cekMhs = $this->model->where($whr)->find();

        if(!$cekMhs){
            $dataInsert = [
                'nim' => $nim,
                'nama' => esc($this->request->getVar('nama')),
                'tempat_lahir' => esc($this->request->getVar('tempat_lahir')),
                'tgl_lahir' => esc($this->request->getVar('tgl_lahir')),
                'jenis_kelamin' => esc($this->request->getVar('jenis_kelamin')),
                'agama'  => esc($this->request->getVar('agama')),
                'nik'  => esc($this->request->getVar('nik')),
                'foto' => NULL,
                'kelas' => esc($this->request->getVar('kelas')),
                'angkatan' => esc($this->request->getVar('angkatan')),
                'prodi' => esc($this->request->getVar('prodi')),
                'jurusan' => esc($this->request->getVar('jurusan')),
                'email' => esc($this->request->getVar('email')),
                'telp' => esc($this->request->getVar('telp')),
                'alamat' => esc($this->request->getVar('alamat')),
                'kewarganegaraan' => esc($this->request->getVar('kewarganegaraan')),
                'provinsi' => esc($this->request->getVar('provinsi')),
                'kabupaten' => esc($this->request->getVar('kabupaten')),
                'kecamatan' => esc($this->request->getVar('kecamatan')),
                'kelurahan' => esc($this->request->getVar('kelurahan')),
                'dusun' => esc($this->request->getVar('dusun')),
                'rt' => esc($this->request->getVar('rt')),
                'rw' => esc($this->request->getVar('rw')),
                'jenis_tinggal' => esc($this->request->getVar('jenis_tinggal')),
                'penerima_kps' => esc($this->request->getVar('penerima_kps')),
                'no_kps' => esc($this->request->getVar('no_kps')),
                'nama_ayah' => esc($this->request->getVar('nama_ayah')),
                'tgl_lahir_ayah' => esc($this->request->getVar('tgl_lahir_ayah')),
                'pendidikan_ayah' => esc($this->request->getVar('pendidikan_ayah')),
                'pekerjaan_ayah' => esc($this->request->getVar('pekerjaan_ayah')),
                'penghasilan_ayah' => esc($this->request->getVar('penghasilan_ayah')),
                'nama_ibu' => esc($this->request->getVar('nama_ibu')),
                'tgl_lahir_ibu' => esc($this->request->getVar('tgl_lahir_ibu')),
                'pendidikan_ibu' => esc($this->request->getVar('pendidikan_ibu')),
                'pekerjaan_ibu' => esc($this->request->getVar('pekerjaan_ibu')),
                'penghasilan_ibu' => esc($this->request->getVar('penghasilan_ibu')),
                'nama_wali' => esc($this->request->getVar('nama_wali')),
                'tgl_lahir_wali' => esc($this->request->getVar('tgl_lahir_wali')),
                'pendidikan_wali' => esc($this->request->getVar('pendidikan_wali')),
                'pekerjaan_wali' => esc($this->request->getVar('pekerjaan_wali')),
                'penghasilan_wali' => esc($this->request->getVar('penghasilan_wali'))
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

    public function editDetailMhs($nim)
    {
        $whr = [
            'nim' => $nim
        ];

        $cekMhs = $this->model->where($whr)->find();

        if($cekMhs){
            $dataUpdate = [
                'nama' => esc($this->request->getVar('nama')),
                'tempat_lahir' => esc($this->request->getVar('tempat_lahir')),
                'tgl_lahir' => esc($this->request->getVar('tgl_lahir')),
                'jenis_kelamin' => esc($this->request->getVar('jenis_kelamin')),
                'agama'  => esc($this->request->getVar('agama')),
                'nik'  => esc($this->request->getVar('nik')),
                'kelas' => esc($this->request->getVar('kelas')),
                'angkatan' => esc($this->request->getVar('angkatan')),
                'prodi' => esc($this->request->getVar('prodi')),
                'jurusan' => esc($this->request->getVar('jurusan')),
                'email' => esc($this->request->getVar('email')),
                'telp' => esc($this->request->getVar('telp')),
                'alamat' => esc($this->request->getVar('alamat')),
                'kewarganegaraan' => esc($this->request->getVar('kewarganegaraan')),
                'provinsi' => esc($this->request->getVar('provinsi')),
                'kabupaten' => esc($this->request->getVar('kabupaten')),
                'kecamatan' => esc($this->request->getVar('kecamatan')),
                'kelurahan' => esc($this->request->getVar('kelurahan')),
                'dusun' => esc($this->request->getVar('dusun')),
                'rt' => esc($this->request->getVar('rt')),
                'rw' => esc($this->request->getVar('rw')),
                'jenis_tinggal' => esc($this->request->getVar('jenis_tinggal')),
                'penerima_kps' => esc($this->request->getVar('penerima_kps')),
                'no_kps' => esc($this->request->getVar('no_kps')),
                'nama_ayah' => esc($this->request->getVar('nama_ayah')),
                'tgl_lahir_ayah' => esc($this->request->getVar('tgl_lahir_ayah')),
                'pendidikan_ayah' => esc($this->request->getVar('pendidikan_ayah')),
                'pekerjaan_ayah' => esc($this->request->getVar('pekerjaan_ayah')),
                'penghasilan_ayah' => esc($this->request->getVar('penghasilan_ayah')),
                'nama_ibu' => esc($this->request->getVar('nama_ibu')),
                'tgl_lahir_ibu' => esc($this->request->getVar('tgl_lahir_ibu')),
                'pendidikan_ibu' => esc($this->request->getVar('pendidikan_ibu')),
                'pekerjaan_ibu' => esc($this->request->getVar('pekerjaan_ibu')),
                'penghasilan_ibu' => esc($this->request->getVar('penghasilan_ibu')),
                'nama_wali' => esc($this->request->getVar('nama_wali')),
                'tgl_lahir_wali' => esc($this->request->getVar('tgl_lahir_wali')),
                'pendidikan_wali' => esc($this->request->getVar('pendidikan_wali')),
                'pekerjaan_wali' => esc($this->request->getVar('pekerjaan_wali')),
                'penghasilan_wali' => esc($this->request->getVar('penghasilan_wali'))
            ];

            $id = $cekMhs[0]['id_mahasiswa'];
            $update = $this->model->update($id,$dataUpdate);

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
            $message = "Periksa NIM kembali";
            $code = 400;
        }

        $res = [
            "message" => $message,
        ];
        
        return $this->respond($res, $code);
    }

    public function uploadFoto($nim)
    {
        $whr = [
            'nim' => $nim
        ];

        $cekMhs = $this->model->where($whr)->find();

        if($cekMhs){
            $validationRule = [
                'fotoMhs' => [
                    'label' => 'Foto',
                    'rules' => 'uploaded[fotoMhs]'
                        . '|is_image[fotoMhs]'
                        . '|mime_in[fotoMhs,image/jpg,image/jpeg]'
                        . '|max_size[fotoMhs,3000]',
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
    
            $img = $this->request->getFile('fotoMhs');
    
            if (! $img->hasMoved()) {
                $newName = $img->getRandomName();
                $filepath = WRITEPATH . 'uploads/img/mhs/profile/';
                $img->move($filepath,$newName);
                $dataUpdate = [
                    'foto' => $newName
                ];
                $gambarLama = $cekMhs[0]['foto'];
                if (isset($gambarLama)) {
                    unlink(WRITEPATH . 'uploads/img/mhs/profile/' . $gambarLama);
                }
                $id = $cekMhs[0]['id_mahasiswa'];
                $this->model->update($id,$dataUpdate);

                $res = [
                    "message" => "OK",
                ];
                return $this->respond($res, 200);
            }
    
            $data = ['errors' => 'Foto mahasiswa telah diupload.'];
            return $this->respond($data, 400);
        }
        else{
            $message = "Periksa NIM kembali";
            $code = 400;
        }

        $res = [
            "message" => $message,
        ];

        return $this->respond($res, $code);
    }
}
