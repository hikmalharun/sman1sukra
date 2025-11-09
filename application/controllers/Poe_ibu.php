<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Poe_ibu extends CI_Controller
{
    public function index()
    {
        $this->load->view('poe_ibu/index');
    }

    public function auth_login()
    {
        // Proses autentikasi login di sini
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        $account = $this->db->get_where('tbl_account_poe_ibu', ['username' => $username])->row_array();

        // Contoh sederhana validasi (ganti dengan logika yang sesuai)
        if ($username === $account['username'] && $password === $account['password_md5']) {
            // Login berhasil
            $data = [
                'nama' => $account['nama'],
                'kelas' => $account['kelas'],
                'jabatan' => $account['jabatan'],
            ];
            $this->session->set_userdata($data);
            if ($username == 'admin' || $username == 'kesiswaan') {
                redirect('poe_ibu/input_harian?username='.$account['username']);
            } else {
                redirect('poe_ibu/input_harian?kelas='.$account['kelas']);
            }
        } else {
            // Login gagal
            $this->session->set_flashdata(
                'notification',
                '
                <div class="alert alert-danger" role="alert">
                    Username atau Password salah!
                </div>
                '
            );
            redirect('poe_ibu/index');
        }
    }

    public function input_harian()
    {
        $kelas = $this->input->get('kelas');
        $username = $this->input->get('username');
        if ($username == 'admin' || $username == 'kesiswaan') {
            redirect('poe_ibu/laporan_poe_ibu?tanggal=&bulan=&kelas=');
        } else {
            $data['siswa'] = $this->db->get_where('tbl_data_siswa_poe_ibu', ['kelas' => $kelas])->result_array();
            $data['poe_ibu'] = $this->db->get_where('tbl_data_poe_ibu', ['kelas' => $kelas])->result_array();
        }
        $this->load->view('poe_ibu/input_harian', $data);
    }

    public function simpan_poe_ibu()
    {
        $tanggal_laporan = $this->input->post('tanggal_laporan');
        $nipd = $this->input->post('nipd');
        $nama = $this->input->post('nama');
        $kelas = $this->input->post('kelas');
        $nominal = $this->input->post('nominal');
        $tanggal = $this->input->post('tanggal');

        $cek_laporan = $this->db->get_where('tbl_data_poe_ibu', [
            'tanggal_laporan' => $tanggal_laporan,
            'nipd' => $nipd,
        ])->row_array();

        if ($cek_laporan) {
            $this->session->set_flashdata(
                'notification',
                '
                <div class="alert alert-danger" role="alert">
                    Data Poe Ibu untuk tanggal tersebut sudah ada.
                </div>
                '
            );
            redirect('poe_ibu/input_harian?kelas='.$kelas);
        } else {
            $data = [
                'tanggal_laporan' => $tanggal_laporan,
                'nipd' => $nipd,
                'nama' => $nama,
                'kelas' => $kelas,
                'nominal' => $nominal,
                'tanggal' => $tanggal,
            ];
            $this->db->insert('tbl_data_poe_ibu', $data);
        }
        $this->session->set_flashdata(
            'notification',
            '
            <div class="alert alert-success" role="alert">
                Berhasil disimpan.
            </div>
            '
        );
        redirect('poe_ibu/input_harian?kelas='.$kelas);
    }

    public function laporan_poe_ibu()
    {
        $kelas = $this->input->get('kelas');
        $tanggal = $this->input->get('tanggal');
        $bulan = $this->input->get('bulan');
        $data['kelas'] = $kelas;
        $data['tanggal'] = $tanggal;
        $data['bulan'] = $bulan;
        if ($kelas == '' && $tanggal == '' && $bulan == '') {
            $data['laporan'] = $this->db->query('SELECT * FROM tbl_data_poe_ibu ORDER BY tanggal_laporan ASC')->result_array();
        } elseif ($kelas) {
            $data['laporan'] = $this->db->query("SELECT * FROM tbl_data_poe_ibu WHERE kelas = '$kelas' ORDER BY tanggal_laporan ASC")->result_array();
        } elseif ($tanggal) {
            $data['laporan'] = $this->db->query("SELECT * FROM tbl_data_poe_ibu WHERE tanggal_laporan = '$tanggal' ORDER BY tanggal_laporan ASC")->result_array();
        } elseif ($bulan) {
            $data['laporan'] = $this->db->query("SELECT * FROM tbl_data_poe_ibu WHERE DATE_FORMAT(tanggal_laporan, '%Y-%m') = '$bulan' ORDER BY tanggal_laporan ASC")->result_array();
        }
        $this->load->view('poe_ibu/laporan_poe_ibu', $data);
    }

    public function laporan_poe_ibu_harian()
    {
        $tanggal = $this->input->get('tanggal');
        $kelas = $this->input->get('kelas');

        $data['laporan'] = $this->db->query("SELECT * FROM tbl_data_poe_ibu WHERE kelas = '$kelas' AND DATE_FORMAT(tanggal_laporan, '%Y-%m-%d') = '$tanggal' ORDER BY tanggal_laporan ASC")->result_array();
        $data['tanggal'] = $tanggal;
        $data['kelas'] = $kelas;

        $this->load->view('poe_ibu/laporan_poe_ibu', $data);
    }

    public function laporan_poe_ibu_bulanan()
    {
        $bulan = $this->input->get('bulan');
        $kelas = $this->input->get('kelas');

        $data['laporan'] = $this->db->query("SELECT * FROM tbl_data_poe_ibu WHERE kelas = '$kelas' AND DATE_FORMAT(tanggal_laporan, '%Y-%m') = '$bulan' ORDER BY tanggal_laporan ASC")->result_array();
        $data['bulan'] = $bulan;
        $data['kelas'] = $kelas;

        $this->load->view('poe_ibu/laporan_poe_ibu', $data);
    }

    public function auth_logout()
    {
        $this->session->sess_destroy();
        redirect('poe_ibu/index');
    }
}
