<?php

namespace App\Models;

use CodeIgniter\Model;

class MDetailMhs extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'mahasiswa';
    protected $primaryKey       = 'id_mahasiswa';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nim','nama','tempat_lahir','tgl_lahir','jenis_kelamin','agama','nik','foto','kelas','angkatan','prodi','jurusan','email','telp','alamat','kewarganegaraan','provinsi','kabupaten','kecamatan','kelurahan','dusun','rt','rw','jenis_tinggal','penerima_kps','no_kps','nama_ayah','tgl_lahir_ayah','pendidikan_ayah','pekerjaan_ayah','penghasilan_ayah','nama_ibu','tgl_lahir_ibu','pendidikan_ibu','pekerjaan_ibu','penghasilan_ibu','nama_wali','tgl_lahir_wali','pendidikan_wali','pekerjaan_wali','penghasilan_wali'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
