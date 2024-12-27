<?php

namespace App\Controllers;

// Load Models
use App\Models\M_Admin;
use App\Models\M_Anggota;
use App\Models\M_Buku;
use App\Models\M_Kategori;
use App\Models\M_Rak;
use App\Models\M_Peminjaman;

// endroid qr-code
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

// End of Load Models

class Admin extends BaseController
{
    protected $helpers = ['form'];

    public function index()
    {
        return view('Backend/Login/login');
    }

    public function autentikasi() {
        $modelAdmin = new M_Admin; // Proses inisiasi model

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $cekUsername = $modelAdmin->getDataAdmin(['username_admin' => $username, 'is_delete_admin' => '0'])->getNumRows();
        if ($cekUsername == 0) {
            session()->setFlashdata('error', 'Username tidak ditemukan!');
            ?>
                <script>
                    history.go(-1);
                </script>
            <?php
        } else {
            $dataUser = $modelAdmin->getDataAdmin(['username_admin' => $username, 'is_delete_admin' => '0'])->getRowArray();
            $passwordUser = $dataUser['password_admin'];

            $verifikasiPassword = password_verify($password, $passwordUser);
            if (!$verifikasiPassword) {
                session()->setFlashdata('error', 'Password tidak sesuai!');
                ?>
                <script>
                    history.go(-1);
                </script>
                <?php
            } else {
                $dataSession = [
                    'ses_id' => $dataUser['id_admin'],
                    'ses_user' => $dataUser['nama_admin'],
                    'ses_level' => $dataUser['akses_level'],
                ];
                session()->set($dataSession);
                session()->setFlashdata('success', 'Login Berhasil!');
                ?>
                    <script>
                        document.location = "<?= base_url('admin/dashboard-admin');?>";
                    </script>
                <?php
            }
        }
    }

    public function dashboard()
    {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        $uri = service('uri');
        $halaman = $uri ->getSegment(2);
        $data['halaman'] = $halaman;
        $title['title'] = 'Dashboard';
        echo view('Backend/Template/header', $title);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Login/dashboard');
        echo view('Backend/Template/footer');
    }

    public function logout() {
        session()->remove('ses_id');
        session()->setFlashdata('error', 'Anda telah keluar dari sistem!');
        ?>
            <script>
                document.location = "<?= base_url('admin/login-admin');?>";
            </script>
        <?php
    }

    // Awal module untuk data admin
    public function master_data_admin() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelAdmin = new M_Admin;

            $uri = service('uri');
            $halaman = $uri->getSegment(2);
            $dataUser = $modelAdmin->getDataAdmin(['is_delete_admin' => '0', 'akses_level !=' => '1'])->getResultArray();

            $data['data_user'] = $dataUser;

            $data['halaman'] = $halaman;
            $title['title'] = 'Data Admin';
            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterAdmin/master-data-admin', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function input_data_admin() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $uri = service('uri');
            $halaman = $uri ->getSegment(2);
            $data['halaman'] = $halaman;
            $title['title'] = 'Admin';
            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterAdmin/input-admin', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function simpan_data_admin() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelAdmin = new M_Admin;

            $nama = $this->request->getPost('nama');
            $username = $this->request->getPost('username');
            $level = $this->request->getPost('level');

            $cekUsername = $modelAdmin->getDataAdmin(['username_admin' => $username])->getNumRows();
            if($cekUsername > 0) {
                session()->setFlashData('error', 'Username sudah Digunakan!');
                ?>
                    <script>
                        history.go(-1);
                    </script>
                <?php
            } else {
                $hasil = $modelAdmin->autoNumber()->getRowArray();
                if(!$hasil) {
                    $id = 'ADM001';
                } else {
                    $kode = $hasil['id_admin'];
                    $noUrut = (int) substr($kode, -3);
                    $noUrut++;
                    $id = 'ADM'.sprintf('%03s', $noUrut);
                }

                $dataSimpan = [
                    'id_admin' => $id,
                    'nama_admin' => $nama,
                    'username_admin' => $username,
                    'password_admin' => password_hash('pass_admin', PASSWORD_DEFAULT),
                    'akses_level' => $level,
                    'is_delete_admin' => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $modelAdmin->saveDataAdmin($dataSimpan);
                session()->setFlashData('success', 'Data Admin Berhasil Ditambah!');
                ?>
                    <script>
                        document.location = "<?= base_url('admin/master-data-admin');?>";
                    </script>
                <?php
            }
        }
    }

    public function edit_data_admin() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $modelAdmin = new M_Admin;

            $uri = service('uri');
            $halaman = $uri->getSegment(2);
            $idEdit = $uri->getSegment(3);
            $dataEdit = $modelAdmin->getDataAdmin(['is_delete_admin' => '0', 'sha1(id_admin)' => $idEdit])->getRowArray();

            session()->set(['idUpdate' => $dataEdit['id_admin']]);
            $data['halaman'] = $halaman;
            $data['data_edit'] = $dataEdit;
            $title['title'] = 'Edit Data Admin';
            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterAdmin/edit-admin', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function update_data_admin() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelAdmin = new M_Admin;

            $nama = $this->request->getPost('nama');
            $username = $this->request->getPost('username');
            $level = $this->request->getPost('level');

            $idUpdate = session()->get('idUpdate');

            $dataSimpan = [
                'nama_admin' => $nama,
                'akses_level' => $level,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $modelAdmin->updateDataAdmin($dataSimpan, ['id_admin' => $idUpdate]);
            session()->remove('idUpdate');
            session()->setFlashData('success', 'Data Admin Berhasil Diperbarui!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/master-data-admin');?>";
                </script>
            <?php
        }
    }

    public function hapus_data_admin() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelAdmin = new M_Admin;

            $uri = service('uri');
            $idHapus = $uri->getSegment(3);

            $dataSimpan = [
                'is_delete_admin' => '1',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $modelAdmin->updateDataAdmin($dataSimpan, ['sha1(id_admin)' => $idHapus]);
            session()->setFlashData('success', 'Data Admin Berhasil Dihapus!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/master-data-admin');?>";
                </script>
            <?php
        }
    }

    // Akhir module data admin

    // Awal module data Anggota
    public function master_data_anggota() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $modelAnggota = new M_Anggota;

            $uri = service('uri');
            $halaman = $uri->getSegment(2);
            $dataUser = $modelAnggota->getDataAnggota(['is_delete_anggota' => '0'])->getResultArray();

            $data['data_user'] = $dataUser;
            $data['halaman'] = $halaman;
            $title['title'] = ' Data Anggota';
            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterAnggota/master-data-anggota', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function input_data_anggota() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $uri = service('uri');
            $halaman = $uri ->getSegment(2);
            $data['halaman'] = $halaman;
            $title['title'] = 'Input Anggota';
            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterAnggota/input-anggota', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function simpan_data_anggota() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelAnggota = new M_Anggota;

            $nama = $this->request->getPost('nama');
            $jekel = $this->request->getPost('jekel');
            $telp = $this->request->getPost('telp');
            $alamat = $this->request->getPost('alamat');
            $email = $this->request->getPost('email');

            $cekEmail = $modelAnggota->getDataAnggota(['email' => $email])->getNumRows();
            if($cekEmail > 0) {
                session()->setFlashData('error', 'E-mail sudah Digunakan!');
                ?>
                    <script>
                        history.go(-1);
                    </script>
                <?php
            } else {
                $hasil = $modelAnggota->autoNumber()->getRowArray();
                if(!$hasil) {
                    $id = 'MBR001';
                } else {
                    $kode = $hasil['id_anggota'];
                    $noUrut = (int) substr($kode, -3);
                    $noUrut++;
                    $id = 'MBR'.sprintf('%03s', $noUrut);
                }

                $dataSimpan = [
                    'id_anggota' => $id,
                    'nama_anggota' => $nama,
                    'jenis_kelamin' => $jekel,
                    'no_tlp' => $telp,
                    'alamat' => $alamat,
                    'email' => $email,
                    'password_anggota' => password_hash('pass_anggota', PASSWORD_DEFAULT),
                    'is_delete_anggota' => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $modelAnggota->saveDataAnggota($dataSimpan);
                session()->setFlashData('success', 'Data Anggota Berhasil Ditambah!');
                ?>
                    <script>
                        document.location = "<?= base_url('admin/master-data-anggota');?>";
                    </script>
                <?php
            }
        }
    }

    public function edit_data_anggota() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $modelAnggota = new M_Anggota;

            $uri = service('uri');
            $halaman = $uri->getSegment(2);
            $idEdit = $uri->getSegment(3);
            $dataEdit = $modelAnggota->getDataAnggota(['is_delete_anggota' => '0', 'sha1(id_anggota)' => $idEdit])->getRowArray();

            session()->set(['idUpdate' => $dataEdit['id_anggota']]);
            $data['halaman'] = $halaman;
            $data['data_edit'] = $dataEdit;
            $title['title'] = 'Edit Anggota';
            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterAnggota/edit-anggota', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function update_data_anggota() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelAnggota = new M_Anggota;

            $nama = $this->request->getPost('nama');
            $jekel = $this->request->getPost('jekel');
            $telp = $this->request->getPost('telp');
            $alamat = $this->request->getPost('alamat');
            $email = $this->request->getPost('email');
            $idUpdate = session()->get('idUpdate');

            $dataSimpan = [
                'nama_anggota' => $nama,
                'jenis_kelamin' => $jekel,
                'no_tlp' => $telp,
                'alamat' => $alamat,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $modelAnggota->updateDataAnggota($dataSimpan, ['id_anggota' => $idUpdate]);
            session()->remove('idUpdate');
            session()->setFlashData('success', 'Data Anggota Berhasil Diperbarui!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/master-data-anggota');?>";
                </script>
            <?php
        }
    }

    public function hapus_data_anggota() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelAnggota = new M_Anggota;

            $uri = service('uri');
            $idHapus = $uri->getSegment(3);

            $dataSimpan = [
                'is_delete_anggota' => '1',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $modelAnggota->updateDataAnggota($dataSimpan, ['sha1(id_anggota)' => $idHapus]);
            session()->setFlashData('success', 'Data Anggota Berhasil Dihapus!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/master-data-anggota');?>";
                </script>
            <?php
        }
    }

    // Akhir module data Anggota

    // Awal module data Buku
    public function master_data_buku() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $modelBuku = new M_Buku;

            $uri = service('uri');
            $halaman = $uri->getSegment(2);
            $dataUser = $modelBuku->getDataBukuJoin(['is_delete_buku' => '0'])->getResultArray();

            $data['data_user'] = $dataUser;
            $data['halaman'] = $halaman;
            $title['title'] = 'Data Buku';
            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterBuku/master-data-buku', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function input_data_buku() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $modelKategori = new M_Kategori;
            $modelRak = new M_Rak;

            $uri = service('uri');
            $halaman = $uri ->getSegment(2);
            $data['halaman'] = $halaman;
            $title['title'] = 'Input Buku';

            $data['data_kategori'] = $modelKategori->getDataKategori(['is_delete_kategori' => '0'])->getResultArray();
            $data['data_rak'] = $modelRak->getDataRak(['is_delete_rak' => '0'])->getResultArray();

            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterBuku/input-buku', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function simpan_data_buku() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelBuku = new M_Buku;

            $judul = $this->request->getPost('judul');
            $pengarang = $this->request->getPost('pengarang');
            $penerbit = $this->request->getPost('penerbit');
            $tahun = $this->request->getPost('tahun');
            $eksemplar = $this->request->getPost('eksemplar');
            $kategori = $this->request->getPost('idkategori');
            $keterangan = $this->request->getPost('keterangan');
            $rak = $this->request->getPost('idrak');

            $cover = $this->request->getFile('cover');
            $cover->move('img');
            $namaCover = $cover->getName();

            $ebook = $this->request->getFile('ebook');
            $ebook->move('e-book');
            $namaEbook = $ebook->getName();

            $cekJudul = $modelBuku->getDataBuku(['judul_buku' => $judul])->getNumRows();
            if($cekJudul > 0) {
                session()->setFlashData('error', 'Judul Sudah Ada!');
                ?>
                    <script>
                        history.go(-1);
                    </script>
                <?php
            } else {
                $hasil = $modelBuku->autoNumber()->getRowArray();
                if(!$hasil) {
                    $id = 'BKU001';
                } else {
                    $kode = $hasil['id_buku'];
                    $noUrut = (int) substr($kode, -3);
                    $noUrut++;
                    $id = 'BKU'.sprintf('%03s', $noUrut);
                }

                $dataSimpan = [
                    'id_buku' => $id,
                    'judul_buku' => $judul,
                    'pengarang' => $pengarang,
                    'penerbit' => $penerbit,
                    'tahun' => $tahun,
                    'jumlah_eksemplar' => $eksemplar,
                    'id_kategori' => $kategori,
                    'keterangan' => $keterangan,
                    'id_rak' => $rak,
                    'cover_buku' => $namaCover,
                    'e_book' => $namaEbook,
                    'is_delete_buku' => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $modelBuku->saveDataBuku($dataSimpan);
                session()->setFlashData('success', 'Data Buku Berhasil Ditambah!');
                ?>
                    <script>
                        document.location = "<?= base_url('admin/master-data-buku');?>";
                    </script>
                <?php
            }
        }
    }

    public function edit_data_buku() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $modelBuku = new M_Buku;
            $modelKategori = new M_Kategori;
            $modelRak = new M_Rak;

            $uri = service('uri');
            $halaman = $uri->getSegment(2);
            $idEdit = $uri->getSegment(3);
            $dataEdit = $modelBuku->getDataBuku(['is_delete_buku' => '0', 'sha1(id_buku)' => $idEdit])->getRowArray();

            session()->set(['idUpdate' => $dataEdit['id_buku']]);
            $data['halaman'] = $halaman;
            $data['data_edit'] = $dataEdit;
            $data['data_kategori'] = $modelKategori->getDataKategori(['is_delete_kategori' => '0'])->getResultArray();
            $data['data_rak'] = $modelRak->getDataRak(['is_delete_rak' => '0'])->getResultArray();
            $title['title'] = 'Edit Buku';

            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterBuku/edit-buku', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function update_data_buku() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelBuku = new M_Buku;

            $judul = $this->request->getPost('judul');
            $pengarang = $this->request->getPost('pengarang');
            $penerbit = $this->request->getPost('penerbit');
            $tahun = $this->request->getPost('tahun');
            $eksemplar = $this->request->getPost('eksemplar');
            $kategori = $this->request->getPost('idkategori');
            $keterangan = $this->request->getPost('keterangan');
            $rak = $this->request->getPost('idrak');
            $cover = $this->request->getPost('cover');
            $ebook = $this->request->getPost('ebook');
            $idUpdate = session()->get('idUpdate');

            $dataSimpan = [
                'judul_buku' => $judul,
                'pengarang' => $pengarang,
                'penerbit' => $penerbit,
                'tahun' => $tahun,
                'jumlah_eksemplar' => $eksemplar,
                'id_kategori' => $kategori,
                'keterangan' => $keterangan,
                'id_rak' => $rak,
                'cover_buku' => $cover,
                'e_book' => $ebook,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $modelBuku->updateDataBuku($dataSimpan, ['id_buku' => $idUpdate]);
            session()->remove('idUpdate');
            session()->setFlashData('success', 'Data Buku Berhasil Diperbarui!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/master-data-buku');?>";
                </script>
            <?php
        }
    }

    public function hapus_data_buku() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $modelBuku = new M_Buku;

            $uri = service('uri');
            $idHapus = $uri->getSegment(3);

            $dataSimpan = [
                'is_delete_buku' => '1',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $modelBuku->updateDataBuku($dataSimpan, ['sha1(id_buku)' => $idHapus]);
            session()->setFlashData('success', 'Data Buku Berhasil Dihapus!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/master-data-buku');?>";
                </script>
            <?php
        }
    }

    // Akhir module data Buku

    // Awal Module data Kategori

    public function master_data_kategori() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $modelKategori = new M_Kategori;

            $uri = service('uri');
            $halaman = $uri->getSegment(2);
            $dataUser = $modelKategori->getDataKategori(['is_delete_kategori' => '0'])->getResultArray();

            $data['data_user'] = $dataUser;
            $data['halaman'] = $halaman;
            $title['title'] = 'Data Kategori';
            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterKategori/master-data-kategori', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function input_data_kategori() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $uri = service('uri');
            $halaman = $uri ->getSegment(2);
            $data['halaman'] = $halaman;
            $title['title'] = 'Input Kategori';
            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterKategori/input-kategori', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function simpan_data_kategori() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelKategori = new M_Kategori;

            $kategori = $this->request->getPost('kategori');

            $cekKategori = $modelKategori->getDataKategori(['nama_kategori' => $kategori])->getNumRows();
            if($cekKategori > 0) {
                session()->setFlashData('error', 'Nama Kategori sudah Digunakan!');
                ?>
                    <script>
                        history.go(-1);
                    </script>
                <?php
            } else {
                $hasil = $modelKategori->autoNumber()->getRowArray();
                if(!$hasil) {
                    $id = 'KTG001';
                } else {
                    $kode = $hasil['id_kategori'];
                    $noUrut = (int) substr($kode, -3);
                    $noUrut++;
                    $id = 'KTG'.sprintf('%03s', $noUrut);
                }

                $dataSimpan = [
                    'id_kategori' => $id,
                    'nama_kategori' => $kategori,
                    'is_delete_kategori' => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $modelKategori->saveDataKategori($dataSimpan);
                session()->setFlashData('success', 'Data Kategori Berhasil Ditambah!');
                ?>
                    <script>
                        document.location = "<?= base_url('admin/master-data-kategori');?>";
                    </script>
                <?php
            }
        }
    }

    public function edit_data_kategori() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $modelKategori = new M_Kategori;

            $uri = service('uri');
            $halaman = $uri->getSegment(2);
            $idEdit = $uri->getSegment(3);
            $dataEdit = $modelKategori->getDataKategori(['is_delete_kategori' => '0', 'sha1(id_kategori)' => $idEdit])->getRowArray();

            session()->set(['idUpdate' => $dataEdit['id_kategori']]);
            $data['halaman'] = $halaman;
            $data['data_edit'] = $dataEdit;
            $title['title'] = 'Edit Kategori';

            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterKategori/edit-kategori', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function update_data_kategori() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelKategori = new M_Kategori;

            $kategori = $this->request->getPost('kategori');
            $idUpdate = session()->get('idUpdate');

            $dataSimpan = [
                'nama_kategori' => $kategori,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $modelKategori->updateDataKategori($dataSimpan, ['id_kategori' => $idUpdate]);
            session()->remove('idUpdate');
            session()->setFlashData('success', 'Data Kategori Berhasil Diperbarui!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/master-data-kategori');?>";
                </script>
            <?php
        }
    }

    public function hapus_data_kategori() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelKategori = new M_Kategori;

            $uri = service('uri');
            $idHapus = $uri->getSegment(3);

            $dataSimpan = [
                'is_delete_kategori' => '1',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $modelKategori->updateDataKategori($dataSimpan, ['sha1(id_kategori)' => $idHapus]);
            session()->setFlashData('success', 'Data Kategori Berhasil Dihapus!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/master-data-kategori');?>";
                </script>
            <?php
        }
    }

    // Akhir Module data Kategori

    // Awal Module data Rak

    public function master_data_rak() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $modelRak = new M_Rak;

            $uri = service('uri');
            $halaman = $uri->getSegment(2);
            $dataUser = $modelRak->getDataRak(['is_delete_rak' => '0'])->getResultArray();

            $data['data_user'] = $dataUser;
            $data['halaman'] = $halaman;
            $title['title'] = 'Data Rak';
            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterRak/master-data-rak', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function input_data_rak() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $uri = service('uri');
            $halaman = $uri ->getSegment(2);
            $data['halaman'] = $halaman;
            $title['title'] = 'Input Rak';
            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterRak/input-rak', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function simpan_data_rak() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelRak = new M_Rak;

            $rak = $this->request->getPost('rak');

            $cekRak = $modelRak->getDataRak(['nama_rak' => $rak])->getNumRows();
            if($cekRak > 0) {
                session()->setFlashData('error', 'Nama Rak sudah Digunakan!');
                ?>
                    <script>
                        history.go(-1);
                    </script>
                <?php
            } else {
                $hasil = $modelRak->autoNumber()->getRowArray();
                if(!$hasil) {
                    $id = 'RAK001';
                } else {
                    $kode = $hasil['id_rak'];
                    $noUrut = (int) substr($kode, -3);
                    $noUrut++;
                    $id = 'RAK'.sprintf('%03s', $noUrut);
                }

                $dataSimpan = [
                    'id_rak' => $id,
                    'nama_rak' => $rak,
                    'is_delete_rak' => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $modelRak->saveDataRak($dataSimpan);
                session()->setFlashData('success', 'Data Rak Berhasil Ditambah!');
                ?>
                    <script>
                        document.location = "<?= base_url('admin/master-data-rak');?>";
                    </script>
                <?php
            }
        }
    }

    public function edit_data_rak() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $modelRak = new M_Rak;

            $uri = service('uri');
            $halaman = $uri->getSegment(2);
            $idEdit = $uri->getSegment(3);
            $dataEdit = $modelRak->getDataRak(['is_delete_rak' => '0', 'sha1(id_rak)' => $idEdit])->getRowArray();

            session()->set(['idUpdate' => $dataEdit['id_rak']]);
            $data['halaman'] = $halaman;
            $data['data_edit'] = $dataEdit;
            $title['title'] = 'Edit Data Rak';

            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterRak/edit-rak', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function update_data_rak() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelRak = new M_Rak;

            $rak = $this->request->getPost('rak');
            $idUpdate = session()->get('idUpdate');

            $dataSimpan = [
                'nama_rak' => $rak,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $modelRak->updateDataRak($dataSimpan, ['id_rak' => $idUpdate]);
            session()->remove('idUpdate');
            session()->setFlashData('success', 'Data Rak Berhasil Diperbarui!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/master-data-rak');?>";
                </script>
            <?php
        }
    }

    public function hapus_data_rak() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelRak = new M_Rak;

            $uri = service('uri');
            $idHapus = $uri->getSegment(3);

            $dataSimpan = [
                'is_delete_rak' => '1',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $modelRak->updateDataRak($dataSimpan, ['sha1(id_rak)' => $idHapus]);
            session()->setFlashData('success', 'Data Rak Berhasil Dihapus!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/master-data-rak');?>";
                </script>
            <?php
        }
    }

    // Akhir Module data Rak

    // Awal Module Restore Data

    public function master_data_restore_admin() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelAdmin = new M_Admin;

            $uri = service('uri');
            $halaman = $uri->getSegment(2);
            $dataUser = $modelAdmin->getDataAdmin(['is_delete_admin' => '1'])->getResultArray();

            $data['data_user'] = $dataUser;

            $data['halaman'] = $halaman;
            $title['title'] = 'Master Restore Data Admin';
            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterRestore/master-data-restoreAdmin', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function restore_data_admin() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelAdmin = new M_Admin;

            $uri = service('uri');
            $idHapus = $uri->getSegment(3);

            $dataSimpan = [
                'is_delete_admin' => '0',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $modelAdmin->updateDataAdmin($dataSimpan, ['sha1(id_admin)' => $idHapus]);
            session()->setFlashData('success', 'Data Admin Berhasil Direstore!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/master-data-restoreAdmin');?>";
                </script>
            <?php
        }
    }

    public function master_data_restore_anggota() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $modelAnggota = new M_Anggota;

            $uri = service('uri');
            $halaman = $uri->getSegment(2);
            $dataUser = $modelAnggota->getDataAnggota(['is_delete_anggota' => '1'])->getResultArray();

            $data['data_user'] = $dataUser;
            $data['halaman'] = $halaman;
            $title['title'] = 'Master Data Restore Anggota';
            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterRestore/master-data-restoreAnggota', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function restore_data_anggota() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelAnggota = new M_Anggota;

            $uri = service('uri');
            $idHapus = $uri->getSegment(3);

            $dataSimpan = [
                'is_delete_anggota' => '0',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $modelAnggota->updateDataAnggota($dataSimpan, ['sha1(id_anggota)' => $idHapus]);
            session()->setFlashData('success', 'Data Anggota Berhasil Direstore!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/master-data-restoreAnggota');?>";
                </script>
            <?php
        }
    }

    public function master_data_restore_buku() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $modelBuku = new M_Buku;

            $uri = service('uri');
            $halaman = $uri->getSegment(2);
            $dataUser = $modelBuku->getDataBukuJoin(['is_delete_buku' => '1'])->getResultArray();

            $data['data_user'] = $dataUser;
            $data['halaman'] = $halaman;
            $title['title'] = 'Master Data Restore Buku';
            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterRestore/master-data-restoreBuku', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function restore_data_buku() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $modelBuku = new M_Buku;

            $uri = service('uri');
            $idHapus = $uri->getSegment(3);

            $dataSimpan = [
                'is_delete_buku' => '0',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $modelBuku->updateDataBuku($dataSimpan, ['sha1(id_buku)' => $idHapus]);
            session()->setFlashData('success', 'Data Buku Berhasil Direstore!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/master-data-restoreBuku');?>";
                </script>
            <?php
        }
    }

    public function master_data_restore_kategori() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $modelKategori = new M_Kategori;

            $uri = service('uri');
            $halaman = $uri->getSegment(2);
            $dataUser = $modelKategori->getDataKategori(['is_delete_kategori' => '1'])->getResultArray();

            $data['data_user'] = $dataUser;
            $data['halaman'] = $halaman;
            $title['title'] = 'Master Data Restore Kategori';
            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterRestore/master-data-restoreKategori', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function restore_data_kategori() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelKategori = new M_Kategori;

            $uri = service('uri');
            $idHapus = $uri->getSegment(3);

            $dataSimpan = [
                'is_delete_kategori' => '0',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $modelKategori->updateDataKategori($dataSimpan, ['sha1(id_kategori)' => $idHapus]);
            session()->setFlashData('success', 'Data Kategori Berhasil Direstore!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/master-data-restoreKategori');?>";
                </script>
            <?php
        }
    }

    public function master_data_restore_rak() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        } else {
            $modelRak = new M_Rak;

            $uri = service('uri');
            $halaman = $uri->getSegment(2);
            $dataUser = $modelRak->getDataRak(['is_delete_rak' => '1'])->getResultArray();

            $data['data_user'] = $dataUser;
            $data['halaman'] = $halaman;
            $title['title'] = 'Master Data Restore Rak';
            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterRestore/master-data-restoreRak', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function restore_data_rak() {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashData('error', 'Silahkan login terlebih dahulu!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/login-admin');?>";
                </script>
            <?php
        }
        else {
            $modelRak = new M_Rak;

            $uri = service('uri');
            $idHapus = $uri->getSegment(3);

            $dataSimpan = [
                'is_delete_rak' => '0',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $modelRak->updateDataRak($dataSimpan, ['sha1(id_rak)' => $idHapus]);
            session()->setFlashData('success', 'Data Rak Berhasil Direstore!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/master-data-restoreRak');?>";
                </script>
            <?php
        }
    }

    // Akhir Module Restore Data

    // Awal Modul Peminjaman

    public function data_transaksi_peminjaman()
    {
        $modelPeminjaman = new M_Peminjaman;

        $dataPeminjaman = $modelPeminjaman->getDataPeminjamanJoin()->getResultArray();

        $uri = service('uri');
        $halaman = $uri->getSegment(2);

        $data['data_pinjam'] = $dataPeminjaman;
        $data['halaman'] = $halaman;
        $title['title'] = 'Data Peminjaman Buku';
        echo view('Backend/Template/header', $title);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Transaksi/data-transaksi-peminjaman', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function input_data_peminjaman()
    {
        $uri = service('uri');
        $halaman = $uri ->getSegment(2);
        $data['halaman'] = $halaman;
        $title['title'] = 'Input Data Peminjaman';
        echo view('Backend/Template/header', $title);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Transaksi/input-data-peminjaman', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function peminjaman_step2()
    {
        $modelAnggota = new M_Anggota;
        $modelBuku = new M_Buku;
        $modelPeminjaman = new M_Peminjaman;
        $uri = service('uri');
        $halaman = $uri->getSegment(2);

        if($this->request->getPost('id_anggota')){
            $idAnggota = $this->request->getPost('id_anggota');
            session()->set(['idAgt' => $idAnggota]);
        }
        else{
            $idAnggota = session()->get('idAgt');
        }

        $cekPeminjaman = $modelPeminjaman->getDataPeminjaman(['id_anggota' => $idAnggota, 'status_transaksi' => "Berjalan"])->getNumRows();
        if($cekPeminjaman > 0){
            session()->setFlashdata('error','Transaksi Tidak Dapat Dilakukan, Masih Ada Transaksi Peminjaman yang Belum Diselesaikan!!');
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
        }
        else{
            $dataAnggota = $modelAnggota->getDataAnggota(['id_anggota' => $idAnggota])->getRowArray();
            $dataBuku = $modelBuku->getDataBukuJoin(['is_delete_buku' => '0'])->getResultArray();
    
            $jumlahTemp = $modelPeminjaman->getDataTemp(['id_anggota' => $idAnggota])->getNumRows();
            $data['jumlahTemp'] = $jumlahTemp;
            // Mengambil data keseluruhan buku dari table buku di database
    
            $dataTemp = $modelPeminjaman->getDataTempJoin(['tb_temp_peminjaman.id_anggota' => $idAnggota])->getResultArray();
    
            $data['halaman'] = $halaman;
            $data['title'] = "Transaksi Peminjaman";
            $data['data_anggota'] = $dataAnggota;
            $data['data_buku'] = $dataBuku;
            $data['dataTemp'] = $dataTemp;
    
            echo view('Backend/Template/header', $title);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/Transaksi/peminjaman-step-2', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function simpan_temp_pinjam()
    {
        $modelPeminjaman = new M_Peminjaman;
        $modelBuku = new M_Buku;

        $uri = service('uri');
        $idBuku = $uri->getSegment(3);
        $dataBuku = $modelBuku->getDataBuku(['sha1(id_buku)' => $idBuku])->getRowArray();

        $adaTemp = $modelPeminjaman->getDataTemp(['sha1(id_buku)' => $idBuku])->getNumRows();
        $adaBerjalan = $modelPeminjaman->getDataPeminjaman(['id_anggota' => session()->get('idAgt'), 'status_transaksi' => "Berjalan"])->getNumRows();
        if($adaTemp){
            session()->setFlashdata('error','Satu Anggota Hanya Bisa Meminjam 1 Buku dengan Judul yang Sama!')
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
        }
        elseif($adaBerjalan){
            session()->setFlashdata('error','Masih ada transaksi peminjaman yang belum diselesaikan, silakan selesaikan peminjaman sebelumnya terlebih dahulu!')
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
        }
        else{
            $dataSimpanTemp = [
                'id_anggota' => session()->get('idAgt'),
                'id_buku' => $dataBuku['id_buku'],
                'jumlah_temp' => '1'
            ];
            $modelPeminjaman->saveDataTemp($dataSimpanTemp);
            $stok = $dataBuku['jumlah_eksemplar']-1;
            $dataUpdate = [
                'jumlah_eksemplar' => $stok
            ];
            $modelBuku->updateDataBuku($dataUpdate,['sha1(id_buku)' => $idBuku]);
            ?>
            <script>
                document.location = "<?= base_url('admin/peminjaman-step-2');?>";
            </script>
            <?php
        }
    }

    public function hapus_temp()
    {
        $modelPeminjaman = new M_Peminjaman;
        $modelBuku = new M_Buku;

        $uri = service('uri');
        $idBuku = $uri->getSegment(3);
        $dataBuku = $modelBuku->getDataBuku(['sha1(id_buku)' => $idBuku])->getRowArray();

        $modelPeminjaman->hapusDataTemp(['sha1(id_buku)' => $idBuku, 'id_anggota' => session()->get('idAgt')]);
        $stok = $dataBuku['jumlah_eksemplar']+1;
        $dataUpdate = [
            'jumlah_eksemplar' => $stok
        ];
        $modelBuku->updateDataBuku($dataUpdate,['sha1(id_buku)' => $idBuku]);
        ?>
        <script>
            document.location = "<?= base_url('admin/peminjaman-step-2');?>";
        </script>
        <?php
    }

    public function simpan_transaksi_peminjaman()
    {
        $modelPeminjaman = new M_Peminjaman;
        $idPeminjaman = date("ymdHis");
        $time_sekarang = time();
        $kembali = date("Y-m-d", strtotime("+7 days", $time_sekarang));
        $jumlahPinjam = $modelPeminjaman->getDataTemp(['id_anggota' => session()->get('idAgt')])->getNumRows();

        $dataQR = $idPeminjaman;
        $labelQR = $idPeminjaman;
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data('http://localhost:8080/admin/detail-peminjaman/'.$dataQR)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->logoPath(FCPATH.'/Assets/Dio-logo.png')
            ->logoResizeToWidth(50)
            ->logoPunchoutBackground(true)
            ->labelText($labelQR)
            ->labelFont(new NotoSans(20))
            ->labelAlignment(LabelAlignment::Center)
            ->validateResult(false)
            ->build();

        // Directly output the QR code
        header('Content-Type: '.$result->getMimeType());

        // Save it to a file
        $namaQR = "qr_".$idPeminjaman.".png";
        $result->saveToFile(FCPATH.'/Assets/qr-code/'.$namaQR);

        $dataSimpan = [
            'no_peminjaman' => $idPeminjaman,
            'id_anggota' => session()->get('idAgt'),
            'tgl_pinjam' => date("Y-m-d"),
            'total_pinjam' => $jumlahPinjam,
            'id_admin' => '-',
            'status_transaksi' => "Berjalan",
            'status_ambil_buku' => "Sudah Diambil",
            'qr_code' => $namaQR
        ];
        $modelPeminjaman->saveDataPeminjaman($dataSimpan);

        $dataTemp = $modelPeminjaman->getDataTemp(['id_anggota' => session()->get('idAgt')])->getResultArray();
        foreach($dataTemp as $sementara){
            $simpanDetail = [
                'no_peminjaman' => $idPeminjaman,
                'id_buku' => $sementara['id_buku'],
                'status_pinjam' => "Sedang Dipinjam",
                'perpanjangan' => "2",
                'tgl_kembali' => $kembali
            ];
            $modelPeminjaman->saveDataDetail($simpanDetail);
        }

        $modelPeminjaman->hapusDataTemp(['id_anggota' => session()->get('idAgt')]);
        session()->remove('idAgt');
        session()->setFlashdata('success','Data Peminjaman Buku Berhasil Disimpan!')
        ?>
        <script>
            document.location = "<?= base_url('admin/detail-peminjaman/'. $idPeminjaman);?>";
        </script>
        <?php
    }

    public function qrcode()
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data('https://youtu.be/dQw4w9WgXcQ?si=Ghf-AFZ86LfjK1O9')
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->logoPath(FCPATH.'/qr-code/DioBrando-modified.png')
            ->logoResizeToWidth(80)
            ->logoPunchoutBackground(true)
            ->labelText('')
            ->labelFont(new NotoSans(20))
            ->labelAlignment(LabelAlignment::Center)
            ->validateResult(false)
            ->build();

            
        // Directly output the QR code
        header('Content-Type: '.$result->getMimeType());
        // echo $result->getString();

        // Save it to a file
        $result->saveToFile(FCPATH.'/qr-code/qrcode.png');
        echo "<img src='/qr-code/qrcode.png'></img>";

        // Generate a data URI to include image data inline (i.e. inside an <img> tag)
        $dataUri = $result->getDataUri();
    }

    public function detail_peminjaman()
    {
        $uri = service('uri');
        $idPeminjaman = $uri->getSegment(3);
        $modelPeminjaman = new M_Peminjaman;
        $cekPeminjaman = $modelPeminjaman->getDataPeminjamanJoin(['no_peminjaman' => $idPeminjaman])->getNumRows();

        if ($cekPeminjaman > 0) {
            $tampilData = $modelPeminjaman->getDataPeminjamanJoin(['no_peminjaman' => $idPeminjaman])->getResultArray();
            $tampilData2 = $modelPeminjaman->getDetailPeminjamanJoin(['no_peminjaman' => $idPeminjaman])->getResultArray();
            $getNama = $modelPeminjaman->getDataPeminjamanJoin(['no_peminjaman' => $idPeminjaman])->getResultArray();

            $data['noPeminjaman'] = $idPeminjaman;
            $data['dataPeminjaman'] = $tampilData;

            $data['dataPeminjaman2'] = $tampilData2;
            echo view('Backend/Transaksi/detail-peminjaman', $data);
        } else {
            echo 'Data tidak ditemukan';
        }
    }

    public function scanner()
    {
        echo view('Backend/Transaksi/coba-scan');
    }

    public function scanner2()
    {
        echo view('Backend/Transaksi/scanner2');
    }

    // Akhir Modul Peminjaman

    public function widgets()
    {
        $uri = service('uri');
        $halaman = $uri ->getSegment(2);
        $data['halaman'] = $halaman;
        $title['title'] = 'Widgets';
        echo view('Backend/Template/header', $title);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Login/widgets');
        echo view('Backend/Template/footer');
    }
    public function charts()
    {
        $uri = service('uri');
        $halaman = $uri ->getSegment(2);
        $data['halaman'] = $halaman;
        $title['title'] = 'Charts';
        echo view('Backend/Template/header', $title);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Login/charts');
        echo view('Backend/Template/footer');
    }
    public function tables()
    {
        $uri = service('uri');
        $halaman = $uri ->getSegment(2);
        $data['halaman'] = $halaman;
        $title['title'] = 'Tables';
        echo view('Backend/Template/header', $title);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Login/tables');
        echo view('Backend/Template/footer');
    }
    public function forms()
    {
        $uri = service('uri');
        $halaman = $uri ->getSegment(2);
        $data['halaman'] = $halaman;
        $title['title'] = 'Forms';
        echo view('Backend/Template/header', $title);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Login/forms');
        echo view('Backend/Template/footer');
    }
    public function panels()
    {
        $uri = service('uri');
        $halaman = $uri ->getSegment(2);
        $data['halaman'] = $halaman;
        $title['title'] = 'Panels';
        echo view('Backend/Template/header', $title);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Login/panels');
        echo view('Backend/Template/footer');
    }

    public function hitung() {
        $uri = service('uri');
        $halaman = $uri->getSegment(2);
        $parameter1 = $uri->getSegment(3);
        $parameter2 = $uri->getSegment(4);

        // Operator Aritmatika Penjumlahan
        $hasilJumlah = $parameter1 + $parameter2;

        // Operator Aritmatika Pengurangan
        $hasilKurang = $parameter1 - $parameter2;

        // Operator Aritmatika Perkalian
        $hasilKali = $parameter1 * $parameter2;

        // Operator Aritmatika Pembagian
        $hasilBagi = $parameter1 / $parameter2;

        $data['parameter1'] = $parameter1;
        $data['parameter2'] = $parameter2;
        $data['hasilJumlah'] = $hasilJumlah;
        $data['hasilKurang'] = $hasilKurang;
        $data['hasilKali'] = $hasilKali;
        $data['hasilBagi'] = $hasilBagi;

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Latihan/aritmatika', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function pembanding() {
        $uri = service('uri');
        $halaman = $uri->getSegment(2);
        $para1 = $uri->getSegment(3);
        $para2 = $uri->getSegment(4);

        // Operator Perbandingan Sama Dengan
        $hasilSama = $para1 == $para2;

        // Operator Perbandingan Tidak Sama Dengan
        $hasilTidak = $para1 != $para2;

        // Operator Perbandingan Lebih Besar
        $hasilBesar = $para1 > $para2;

        // Operator Perbandingan Lebih Kecil
        $hasilKecil = $para1 < $para2;

        $data['para1'] = $para1;
        $data['para2'] = $para2;
        $data['hasilSama'] = $hasilSama;
        $data['hasilTidak'] = $hasilTidak;
        $data['hasilBesar'] = $hasilBesar;
        $data['hasilKecil'] = $hasilKecil;

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Latihan/perbandingan', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function implementasi_form() {
        $uri = service('uri');
        $halaman = $uri ->getSegment(2);
        $data['halaman'] = $halaman;
        $title['title'] = 'Forms';
        echo view('Backend/Template/header', $title);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Latihan/belajar-form');
        echo view('Backend/Template/footer');
    }

    public function post_form() {
        $uri = service('uri');
        $halaman = $uri ->getSegment(2);
        $data['halaman'] = $halaman;
        $title['title'] = 'Forms';
        $rules = [
            'nim' => ['label' => 'NIM', 'rules' => 'required|max_length[8]|min_length[8]|numeric'],
            'nama' => ['label' => 'NAMA', 'rules' => 'required|max_length[255]'],
            'email' => ['label' => 'EMAIL', 'rules' => 'required|max_length[254]|valid_email'],
            'jekel' => ['label' => 'JENIS KELAMIN', 'rules' => 'required|max_length[25]|min_length[0]'],
            'kode_cabang' => ['label' => 'KODE CABANG', 'rules' => 'required|max_length[5]|min_length[1]'],
            'kelas' => ['label' => 'KELAS', 'rules' => 'required|max_length[25]|min_length[5]'],
            'alamat' => ['label' => 'ALAMAT', 'rules' => 'required|max_length[255]'],
        ];

        if (!$this->request->is('post')) {
            session()->set(['error_list' => validation_list_errors()]);
            ?>
                <script>
                    history.go(-1);
                </script>
            <?php
        }
        else if (!$this->validate($rules)) {
            session()->set(['error_list' => validation_list_errors()]);
            ?>
                <script>
                    history.go(-1);
                </script>
            <?php
        }
        else {
            session()->remove('error_list');
            $session = session();
            // If you want to get the validated data.
            $validData = $this->validator->getValidated();

            if ($validData['kode_cabang'] == '01') {
                $kampus = 'Kampus Margonda';
            } else if ($validData['kode_cabang'] == '02') {
                $kampus = 'Kampus Fatmawati';
            } else if ($validData['kode_cabang'] == '03') {
                $kampus = 'Kampus Tangerang';
            } else if ($validData['kode_cabang'] == '04') {
                $kampus = 'Kampus Bekasi';
            } else {
                $kampus = 'Tidak Ada Kampus';
            }

            $biodata = [
                'nim' => $validData['nim'],
                'nama' => $validData['nama'],
                'email' => $validData['email'],
                'jekel' => $validData['jekel'],
                'kodecabang' => $validData['kode_cabang'],
                'kampus' => $kampus,
                'kelas' => $validData['kelas'],
                'alamat' => $validData['alamat'],
            ];

            $session->set($biodata);
            ?>
                <script>
                    document.location = "<?= base_url('admin/form-sukses') ?>";
                </script>
            <?php
        }
    }

    public function form_sukses() {
        $uri = service('uri');
        $halaman = $uri ->getSegment(2);
        $data['halaman'] = $halaman;
        $title['title'] = 'Forms';
        echo view('Backend/Template/header', $title);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Latihan/form-sukses');
        echo view('Backend/Template/footer');
    }

    public function login_page()
    {
        return view('Backend/Belajar/Login-page/login-page');
    }

    public function dashboard_page()
    {
        return view('Backend/Belajar/Dashboard-page/dashboard-page');
    }
}
