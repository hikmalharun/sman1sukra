<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Absen_siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    // Simpan absensi dari hasil scan QR
    public function simpan()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id_siswa = $input['id_siswa'];

        // Cari data siswa berdasarkan NISN
        $siswa = $this->db->get_where('tbl_data_siswa_poe_ibu', ['nisn' => $id_siswa])->row_array();

        if (!$siswa) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Siswa tidak ditemukan!',
            ]);

            return;
        }

        // Cek apakah sudah absen hari ini
        $cek_absen = $this->db->get_where('tbl_absen_siswa', [
            'id_siswa' => $id_siswa,
            'tanggal_absen' => date('Y-m-d'),
        ])->row_array();

        if ($cek_absen) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Siswa sudah absen hari ini!',
            ]);

            return;
        }

        // Simpan absensi baru
        $data = [
            'id_siswa' => $siswa['nisn'],
            'tanggal_absen' => date('Y-m-d'),
            'jam_absen' => date('H:i:s'),
        ];
        $this->db->insert('tbl_absen_siswa', $data);

        echo json_encode([
            'status' => 'success',
            'message' => 'Absensi berhasil!',
            'id_siswa' => $siswa['nisn'],
            'nama_siswa' => $siswa['nama'],
            'kelas' => $siswa['kelas'],
            'tanggal_absen' => $data['tanggal_absen'],
            'jam_absen' => $data['jam_absen'],
        ]);
    }

    // Endpoint JSON untuk load data absensi realtime
    public function get_absensi_json()
    {
        $absensi = $this->db->order_by('tanggal_absen', 'DESC')
                            ->order_by('jam_absen', 'DESC')
                            ->get('tbl_absen_siswa')
                            ->result_array();

        $result = [];
        foreach ($absensi as $row) {
            $siswa = $this->db->get_where('tbl_data_siswa_poe_ibu', ['nisn' => $row['id_siswa']])->row_array();
            $result[] = [
                'id_siswa' => $row['id_siswa'],
                'nama_siswa' => $siswa ? $siswa['nama'] : '-',
                'kelas' => $siswa ? $siswa['kelas'] : '-',
                'tanggal_absen' => $row['tanggal_absen'],
                'jam_absen' => $row['jam_absen'],
            ];
        }

        echo json_encode($result);
    }

    // Halaman utama absensi
    public function index()
    {
        $query = 'CREATE TABLE IF NOT EXISTS tbl_absen_siswa (
            id_absensi INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            id_siswa VARCHAR(12) NOT NULL,
            tanggal_absen VARCHAR(255) NOT NULL,
            jam_absen VARCHAR(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
        $this->db->query($query);
        $this->load->view('absen_siswa/absen_siswa');
    }
}
