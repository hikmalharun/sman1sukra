<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Absen_siswa extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     *
     * @see https://codeigniter.com/userguide3/general/urls.html
     */
    public function index()
    {
        // Buat query untuk membuat tabel absensi jika belum ada
        $this->db->query('CREATE TABLE IF NOT EXISTS absen_siswa (
          id_absensi INT AUTO_INCREMENT PRIMARY KEY,
          id_siswa VARCHAR(255),
          waktu_absen DATETIME
        )');
        $this->load->view('absen_siswa/absen_siswa');
    }

    public function simpan()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id_siswa = $input['id_siswa'];

        $data = [
            'id_siswa' => $id_siswa,
            'waktu_absen' => date('Y-m-d H:i:s'),
        ];
        // Buat validasi siswa yang sudah absen tidak bisa absen lagi dalam satu hari yang sama
        $today = date('Y-m-d');
        $cek_absen = $this->db->get_where('absen_siswa', [
            'id_siswa' => $id_siswa,
            'waktu_absen >=' => $today.' 00:00:00',
            'waktu_absen <=' => $today.' 23:59:59',
        ])->num_rows();
        if ($cek_absen > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Siswa sudah absen hari ini!']);

            return;
        }
        $this->db->insert('absen_siswa', $data);

        echo json_encode(['status' => 'success', 'message' => 'Absensi berhasil!']);
    }
}
