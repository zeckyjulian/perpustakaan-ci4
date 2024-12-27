<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home/index', 'Home::index');


// Ini adalah coding awal bagian depan untuk login
$routes->get('/admin/login', 'Admin::index');
$routes->get('/admin', 'Admin::index');
$routes->post('/admin/login', 'Admin::dashboard');
$routes->get('/admin/dashboard-admin', 'Admin::dashboard');
$routes->get('/admin', 'Admin::dashboard');
$routes->get('/admin/login-admin', 'Admin::index');
$routes->get('/admin/dashboard-admin', 'Admin::dashboard');
$routes->post('/admin/autentikasi-login', 'Admin::autentikasi');
$routes->get('admin/logout', 'admin::logout');

// Routes untuk master data admin
$routes->get('admin/master-data-admin', 'Admin::master_data_admin');
$routes->get('admin/input-data-admin', 'Admin::input_data_admin');
$routes->post('admin/simpan-admin', 'Admin::simpan_data_admin');
$routes->get('admin/edit-admin/(:alphanum)', 'Admin::edit_data_admin/$1');
$routes->post('admin/update-admin', 'Admin::update_data_admin');
$routes->get('admin/hapus-data-admin/(:alphanum)', 'Admin::hapus_data_admin/$1');

// Routes untuk master data anggota
$routes->get('admin/master-data-anggota', 'Admin::master_data_anggota');
$routes->get('admin/input-data-anggota', 'Admin::input_data_anggota');
$routes->post('admin/simpan-anggota', 'Admin::simpan_data_anggota');
$routes->get('admin/edit-anggota/(:alphanum)', 'Admin::edit_data_anggota/$1');
$routes->post('admin/update-anggota', 'Admin::update_data_anggota');
$routes->get('admin/hapus-data-anggota/(:alphanum)', 'Admin::hapus_data_anggota/$1');

// Routes untuk master data buku
$routes->get('admin/master-data-buku', 'Admin::master_data_buku');
$routes->get('admin/input-data-buku', 'Admin::input_data_buku');
$routes->post('admin/simpan-buku', 'Admin::simpan_data_buku');
$routes->get('admin/edit-buku/(:alphanum)', 'Admin::edit_data_buku/$1');
$routes->post('admin/update-buku', 'Admin::update_data_buku');
$routes->get('admin/hapus-data-buku/(:alphanum)', 'Admin::hapus_data_buku/$1');

// Routes untuk master data kategori
$routes->get('admin/master-data-kategori', 'Admin::master_data_kategori');
$routes->get('admin/input-data-kategori', 'Admin::input_data_kategori');
$routes->post('admin/simpan-kategori', 'Admin::simpan_data_kategori');
$routes->get('admin/edit-kategori/(:alphanum)', 'Admin::edit_data_kategori/$1');
$routes->post('admin/update-kategori', 'Admin::update_data_kategori');
$routes->get('admin/hapus-data-kategori/(:alphanum)', 'Admin::hapus_data_kategori/$1');

// Routes untuk master data Rak
$routes->get('admin/master-data-rak', 'Admin::master_data_rak');
$routes->get('admin/input-data-rak', 'Admin::input_data_rak');
$routes->post('admin/simpan-rak', 'Admin::simpan_data_rak');
$routes->get('admin/edit-rak/(:alphanum)', 'Admin::edit_data_rak/$1');
$routes->post('admin/update-rak', 'Admin::update_data_rak');
$routes->get('admin/hapus-data-rak/(:alphanum)', 'Admin::hapus_data_rak/$1');

// Routes untuk master data Restore
$routes->get('admin/master-data-restoreAdmin', 'Admin::master_data_restore_admin');
$routes->get('admin/restore-data-admin/(:alphanum)', 'Admin::restore_data_admin/$1');
$routes->get('admin/master-data-restoreAnggota', 'Admin::master_data_restore_anggota');
$routes->get('admin/restore-data-anggota/(:alphanum)', 'Admin::restore_data_anggota/$1');
$routes->get('admin/master-data-restoreBuku', 'Admin::master_data_restore_buku');
$routes->get('admin/restore-data-buku/(:alphanum)', 'Admin::restore_data_buku/$1');
$routes->get('admin/master-data-restoreKategori', 'Admin::master_data_restore_kategori');
$routes->get('admin/restore-data-kategori/(:alphanum)', 'Admin::restore_data_kategori/$1');
$routes->get('admin/master-data-restoreRak', 'Admin::master_data_restore_rak');
$routes->get('admin/restore-data-rak/(:alphanum)', 'Admin::restore_data_rak/$1');

// Routes dashboard
$routes->get('/admin/widgets', 'Admin::widgets');
$routes->get('/admin', 'Admin::widgets');
$routes->get('/admin/charts', 'Admin::charts');
$routes->get('/admin', 'Admin::charts');
$routes->get('/admin/tables', 'Admin::tables');
$routes->get('/admin', 'Admin::tables');
$routes->get('/admin/forms', 'Admin::forms');
$routes->get('/admin', 'Admin::forms');
$routes->get('/admin/panels', 'Admin::panels');
$routes->get('/admin', 'Admin::panels');

// ROutes Transaksi
$routes->get('admin/data-transaksi-peminjaman', 'Admin::data_transaksi_peminjaman');
$routes->get('admin/input-data-peminjaman', 'Admin::input_data_peminjaman');
$routes->get('admin/peminjaman-step-2', 'Admin::peminjaman_step2');
$routes->post('admin/peminjaman-step-2', 'Admin::peminjaman_step2');
$routes->get('admin/simpan-temp-pinjam/(:alphanum)', 'Admin::simpan_temp_pinjam/$1');
$routes->get('admin/hapus-temp/(:alphanum)', 'Admin::hapus_temp/$1');
$routes->get('admin/simpan-transaksi-peminjaman', 'Admin::simpan_transaksi_peminjaman');
$routes->get('admin/detail-peminjaman/(:alphanum)', 'Admin::detail_peminjaman/$1');
$routes->get('admin/scanner', 'Admin::scanner');
$routes->get('admin/scanner2', 'Admin::scanner2');
$routes->get('admin/qrcode', 'Admin::qrcode');

// Routes untuk Tugas
$routes->get('/admin/belajar-hitung/(:num)/(:num)', 'Admin::hitung/$1/$2');
$routes->get('/admin/belajar-banding/(:num)/(:num)', 'Admin::pembanding/$1/$2');
$routes->get('/admin/belajar-string', 'Admin::karakter');
$routes->get('/admin/belajar-form', 'Admin::implementasi_form');
$routes->post('/admin/post-form', 'Admin::post_form');
$routes->get('/admin/form-sukses', 'Admin::form_sukses');

// Routes untuk Belajar
$routes->get('/admin/login-page','Admin::login_page' );
$routes->get('/admin/dashboard-page','Admin::dashboard_page' );