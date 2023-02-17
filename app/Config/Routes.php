<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->post('/login/','CLogin::index'); //Login
$routes->put('/reg/(:any)','CRegister::reg/$1'); //Regis Mahasiswa = "reg/mhs", Dosen = "reg/dsn"
$routes->patch('/resetPass/(:num)','CRegister::resetPass/$1'); // Reset password mahasiswa & dosen
$routes->patch('/changePass/(:num)','CRegister::changePass/$1'); // Change password mahasiswa & dosen

$routes->get('/mahasiswa/','CDetailMhs::index'); // Get semua mahasiswa
$routes->get('/mahasiswa/(:num)','CDetailMhs::show/$1'); //Get mahasiswa by nim
$routes->put('/mahasiswa/(:num)/isiDataDiri','CDetailMhs::tambahDetailMhs/$1'); // Isi data diri mahasiswa
$routes->patch('/mahasiswa/(:num)/editDataDiri','CDetailMhs::editDetailMhs/$1'); // update data diri mahasiswa
$routes->post('/mahasiswa/(:num)/uploadFoto','CDetailMhs::uploadFoto/$1'); // Mengisi/update foto mahasiswa

$routes->get('/dosen/','CDosen::index'); // Get semua dosen
$routes->get('/dosen/(:num)','CDosen::show/$1'); // Get dosen by nid
$routes->put('/dosen/(:num)/isiDataDiri','CDosen::newDosen/$1'); // Isi data diri dosen
$routes->patch('/dosen/(:num)/editDataDiri','CDosen::edit/$1'); // update data diri dosen
$routes->post('/dosen/(:num)/uploadFoto','CDosen::uploadFoto/$1'); // Mengisi/update foto dosen

$routes->get('/jadwal/','CJadwal::index'); // Get semua jadwal
$routes->get('/jadwal/(:num)','CJadwal::show/$1'); // Get semua jadwal
$routes->put('/jadwal/','CJadwal::new'); // Insert jadwal
$routes->patch('/jadwal/(:num)/edit','CJadwal::update/$1'); // Update jadwal by id

$routes->get('/matkul/','CJadwalMatkul::index'); // Get semua matkul
$routes->get('/matkul/(:num)','CJadwalMatkul::show/$1'); // Get matkul by id
$routes->put('/matkul/(:num)/tambahMatkul','CJadwalMatkul::newJadwalMatku/$1'); // Insert matkul
$routes->patch('/matkul/(:num)/edit','CJadwalMatkul::update/$1'); // update matkul

$routes->get('/kelas/','CVKelas::index'); // Get semua matkul
$routes->get('/kelas/c/(:any)','CVKelas::show/$1'); // Get matkul by kode kelas
$routes->put('/kelas/(:num)/tambahKelas','CKelas::newKelas/$1'); // Insert matkul
$routes->put('/kelas/join','CJoinKelas::new'); // Join kelas
$routes->get('/kelas/(:num)/cekJoin/(:num)','CJoinKelas::cekJoin/$1/$2'); // Cek join kelas
$routes->get('/kelas/mhs/(:num)','CKelasMhs::show/$1'); // get semua kelas mahasiswa(id_mahasiswa)
$routes->get('/kelas/dsn/(:num)','CKelasDsn::show/$1'); // get semua kelas dosen(id_dosen)
$routes->post('/kelas/newPost/','CPost::new'); // Buat post
$routes->get('/kelas/getPost/(:num)','CPost::show/$1'); // Ambil post
$routes->get('/kelas/getPostBK/(:num)','CPost::showByKelas/$1'); // Ambil post by id kelas
$routes->get('/kelas/getFilePost/(:num)','CFilePost::show/$1'); // Ambil post by id post
$routes->patch('/kelas/editPost/(:num)','CPost::edit/$1'); // Edit post
$routes->delete('/kelas/deletePost/(:num)','CPost::delete/$1'); // delete post
$routes->get('/kelas/(:num)/anggota','CAnggotaKelas::show/$1'); // get anggota kelas
$routes->post('/kelas/post/(:num)/jawab','CJawaban::jawab/$1'); // jawab post 
$routes->post('/kelas/editJawaban/(:num)','CJawaban::update/$1'); // Edit jawaban by id jawaban
$routes->patch('/kelas/nilaiJawaban/(:num)','CJawaban::nilai/$1'); // Nilai jawaban by id post
$routes->get('/kelas/getJawaban/(:num)','CVJawaban::show/$1'); // Ambil jawaban by id jawaban
$routes->get('/kelas/getJawabanIp/(:num)','CVJawaban::showByIp/$1'); // Ambil jawaban by id post
$routes->get('/kelas/getJawabanIp/(:num)/mhs/(:num)','CVJawaban::showByIpMhs/$1/$2'); // Ambil jawaban by id post

$routes->put('/absen/','CAbsen::new'); // Insert absen
$routes->get('/absen/(:num)','CDaftarAbsen::show/$1'); // Get absen hari ini by id kelas

$routes->get('/repo/penelitianDosen','CVPenelitianDosen::index'); // get semua penelitian dosen
$routes->get('/repo/penelitianDosen/(:num)','CVPenelitianDosen::show/$1'); // get semua penelitian dosen by id penelitian
$routes->get('/repo/penelitianDosen/byNid/(:num)','CVPenelitianDosen::showByNid/$1'); // get semua penelitian dosen by nid
$routes->post('/repo/penelitianDosen/insert','CPenelitianDosen::new'); // Insert penelitian dosen
$routes->patch('/repo/penelitianDosen/(:num)/edit','CPenelitianDosen::edit/$1'); // Edit penelitian dosen
$routes->delete('/repo/penelitianDosen/(:num)/delete','CPenelitianDosen::delete/$1'); // Delete penelitian dosen
$routes->post('/repo/penelitianDosen/(:num)/editFile','CPenelitianDosen::editFile/$1'); // Edit file penelitian dosen

$routes->get('/repo/pengabdianDosen','CVPengabdianDosen::index'); // get semua pengabdian dosen
$routes->get('/repo/pengabdianDosen/(:num)','CVPengabdianDosen::show/$1'); // get semua pengabdian dosen by id penelitian
$routes->get('/repo/pengabdianDosen/byNid/(:num)','CVPengabdianDosen::showByNid/$1'); // get semua pengabdian dosen by nid
$routes->post('/repo/pengabdianDosen/insert','CPengabdianDosen::new'); // Insert pengabdian dosen
$routes->post('/repo/pengabdianDosen/(:num)/editFile','CPengabdianDosen::editFile/$1'); // Edit file pengabdian dosen
$routes->patch('/repo/pengabdianDosen/(:num)/edit','CPengabdianDosen::edit/$1'); // Edit pengabdian penelitian dosen
$routes->delete('/repo/pengabdianDosen/(:num)/delete','CPengabdianDosen::delete/$1'); // Delete pengabdian dosen

$routes->get('/repo/publikasiDosen','CVPublikasiDosen::index'); // get semua publikasi dosen
$routes->get('/repo/publikasiDosen/(:num)','CVPublikasiDosen::show/$1'); // get semua publikasi dosen by id publikasi
$routes->get('/repo/publikasiDosen/byNid/(:num)','CVPublikasiDosen::showByNid/$1'); // get semua publikasi dosen by nid
$routes->post('/repo/publikasiDosen/insert','CPublikasiDosen::new'); // Insert publikasi dosen
$routes->post('/repo/publikasiDosen/(:num)/editFile','CPublikasiDosen::editFile/$1'); // Edit file publikasi dosen
$routes->patch('/repo/publikasiDosen/(:num)/edit','CPublikasiDosen::edit/$1'); // Edit publikasi dosen
$routes->delete('/repo/publikasiDosen/(:num)/delete','CPublikasiDosen::delete/$1'); // Delete publikasi dosen

$routes->get('/repo/prestasiMhs','CVPrestasiMhs::index'); // get semua prestasi mahasiswa
$routes->get('/repo/prestasiMhs/(:num)','CVPrestasiMhs::show/$1'); // get semua prestasi mahasiswa by id prestasi
$routes->get('/repo/prestasiMhs/byNim/(:num)','CVPrestasiMhs::showByNim/$1'); // get semua prestasi mahasiswa by nid
$routes->post('/repo/prestasiMhs/insert','CPrestasiMhs::new'); // Insert prestasi mahasiswa
$routes->post('/repo/prestasiMhs/(:num)/editFile','CPrestasiMhs::editFile/$1'); // Edit file prestasi mahasiswa
$routes->patch('/repo/prestasiMhs/(:num)/edit','CPrestasiMhs::edit/$1'); // Edit prestasi mahasiswa
$routes->delete('/repo/prestasiMhs/(:num)/delete','CPrestasiMhs::delete/$1'); // Delete prestasi mahasiswa

$routes->get('/repo/publikasiMhs','CVPublikasiMhs::index'); // get semua publikasi mahasiswa
$routes->get('/repo/publikasiMhs/(:num)','CVPublikasiMhs::show/$1'); // get semua publikasi mahasiswa by id publikasi
$routes->get('/repo/publikasiMhs/byNim/(:num)','CVPublikasiMhs::showByNim/$1'); // get semua publikasi mahasiswa by nid
$routes->post('/repo/publikasiMhs/insert','CPublikasiMhs::new'); // Insert publikasi mahasiswa
$routes->post('/repo/publikasiMhs/(:num)/editFile','CPublikasiMhs::editFile/$1'); // Edit file publikasi mahasiswa
$routes->patch('/repo/publikasiMhs/(:num)/edit','CPublikasiMhs::edit/$1'); // Edit publikasi mahasiswa
$routes->delete('/repo/publikasiMhs/(:num)/delete','CPublikasiMhs::delete/$1'); // Delete publikasi mahasiswa

$routes->match(['get', 'post'], 'imageRender/(:segment)/(:segment)', 'CRenderFile::gambar/$1/$2');
$routes->match(['get', 'post'], 'download/(:segment)/(:segment)', 'CRenderFile::file/$1/$2');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
