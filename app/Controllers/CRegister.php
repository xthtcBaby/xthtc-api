<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CRegister extends ResourceController
{
    protected $modelName = 'App\Models\MAkun';
    protected $format    = 'json';

    public function reg ($type)
    {
        if ($type != "mhs" && $type != "dsn") {

            $res = [
                "message" => "Access denied",
            ];
            return $this->respond($res, 400);
        }
        else{
            if ($type == "mhs"){
                $role = 1;
            }
            else{
                $role = 2;
            }
        }

        $noidentitas = esc($this->request->getVar("noidentitas"));
        $password = esc($this->request->getVar("noidentitas")).(($role == 1) ? "!Mhs" : "!Dsn");

        $whr = [
            "noidentitas" => $noidentitas,
        ];

        if (isset($noidentitas)) {
            $dataU = $this->model->where($whr)->findAll();
            if (!$dataU) {
                $dataInsert = [
                    "noidentitas" => $noidentitas,
                    "password" => password_hash($password,PASSWORD_BCRYPT),
                    "role" => $role,
                    "is_active" => 1
                ];

                $insert = $this->model->save($dataInsert);
                if ($insert) {
                    $message = "OK";
                    $code = 200;
                }
                else{
                    $message = "Register gagal";
                    $code = 400;
                }
            }
            else{
                $message = "NIM/NID telah terdaftar";
                $code = 400;
            }
        }
        else{
            $message = "NIM/NID harus diisi";
            $code = 400;
        }

        $res = [
            "message" => $message,
        ];
        
        return $this->respond($res, $code);
    }

    public function resetPass ($noidentitas)
    {
        $noidentitas = esc($noidentitas);
        $whr = [
            "noidentitas" => $noidentitas,
        ];

        $dataU = $this->model->where($whr)->findAll();
        if ($dataU) {
            $password = $noidentitas.(($dataU[0]['role'] == 1) ? "!Mhs" : "!Dsn");

            $dataUpdate = [
                "idakun" => $dataU[0]['idakun'],
                "password" => password_hash($password,PASSWORD_BCRYPT)
            ];

            $save = $this->model->save($dataUpdate);
            if ($save) {
                $message = "OK";
                $code = 200;
            }
            else{
                $message = "Reset password gagal";
                $code = 400;
            }
        }
        else{
            $message = "User tidak dapat ditemukan";
            $code = 400;
        }

        $res = [
            "message" => $message,
        ];
        
        return $this->respond($res, $code);
    }

    public function changePass ($noidentitas)
    {
        $noidentitas = esc($noidentitas);
        $whr = [
            "noidentitas" => $noidentitas,
        ];

        $dataU = $this->model->where($whr)->findAll();
        if ($dataU) {
            $password = $this->request->getVar('oldPass');
            $newPass = $this->request->getVar('newPass');
            $confPass = $this->request->getVar('confPass');
            if (password_verify($password,$dataU[0]['password'])) {
                if ($newPass == $confPass) {
                    $dataUpdate = [
                        "idakun" => $dataU[0]['idakun'],
                        "password" => password_hash($newPass,PASSWORD_BCRYPT)
                    ];
        
                    $save = $this->model->save($dataUpdate);
                    if ($save) {
                        $message = "OK";
                        $code = 200;
                    }
                    else{
                        $message = "Ganti password gagal";
                        $code = 400;
                    }
                }
                else{
                    $message = "Konfirmasi password salah";
                    $code = 400;
                }
            }
            else{
                $message = "Password salah";
                $code = 400;
            }
        }
        else{
            $message = "User tidak dapat ditemukan";
            $code = 400;
        }

        $res = [
            "message" => $message,
        ];
        
        return $this->respond($res, $code);
    }
}
