<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CRenderFile extends ResourceController
{
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function gambar($level = null, $gambar = null)
    {
        if ($level == 'mahasiswa' ) {
            $f = 'mhs';
        }
        else{
            $f = 'dsn';
        }
        $path = WRITEPATH.'uploads/img/'.$f.'/profile/'.$gambar;
        $image = @file_get_contents($path);
        if($image == FALSE)
            return $this->respond(["message"=>"image not found"], 400);
        else
            $cekFiles = new \CodeIgniter\Files\File($path);

        // choose the right mime type
        $mimeType = $cekFiles->getMimeType();

        $this->response
            ->setStatusCode(200)
            ->setContentType($mimeType)
            ->setBody($image)
            ->send();
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function file($type = null, $file = null)
    {
        if ($type == "filePost") {
            $f = "file/post/";
        }
        else if ($type == "fileJawaban") {
            $f = "jawaban/mhs/";
        }
        else if ($type == "fileJawaban") {
            $f = "jawaban/mhs/";
        }
        else if ($type == "penelitianDosen") {
            $f = "repo/penelitianDsn/";
        }
        else if ($type == "pengabdianDosen") {
            $f = "repo/pengabdianDsn/";
        }
        else if ($type == "publikasiDosen") {
            $f = "repo/publikasiDsn/";
        }
        else if ($type == "prestasiMahasiswa") {
            $f = "repo/sertifMhs/";
        }
        else if ($type == "publikasiMahasiswa") {
            $f = "repo/publikasiMhs/";
        }

        $path = WRITEPATH.'uploads/'.$f.$file;
        $cekFile = @file_get_contents($path);
        if($cekFile == FALSE)
            return $this->respond(["message"=>"file not found"], 400);
        else
            return $this->response->download($path, null);
    }

}
