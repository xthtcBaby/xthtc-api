<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CLogin extends ResourceController
{
    protected $modelName = 'App\Models\MVAkun';
    protected $format    = 'json';

    public function index()
    {
        $noidentitas = esc($this->request->getVar("noidentitas"));
        $password = esc($this->request->getVar("password"));

        if (isset($noidentitas) && isset($password)) {
            $whr = [
                "noidentitas" => $noidentitas,
                "is_active" => 1
            ];
            $dataU = $this->model->where($whr)->findAll();
            if ($dataU && password_verify($password,$dataU[0]['password'])) {
                $message = "OK";
                $data['login'] = [
                    "noidentitas" => $dataU[0]['noidentitas'],
                    "role" => $dataU[0]['role'],
                ];
                $code = 200;
            }
            else{
                $message = "NIM/NID & Password salah";
                $code = 400;
            }
        }
        else{
            $message = "NIM/NID & Password harus diisi";
            $code = 400;
        }

        $res = [
            "message" => $message,
            "data" => (!isset($data)) ? NULL : $data
        ];
        
        return $this->respond($res, $code);
    }
}
