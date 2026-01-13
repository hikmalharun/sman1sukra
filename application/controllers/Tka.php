<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Tka extends CI_Controller
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
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('download');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $kelas = $this->input->get('kelas');
        if ($kelas) {
            $data['kelas_selected'] = $kelas;
            $data['siswa'] = $this->db->get_where('tbl_data_siswa_poe_ibu', ['kelas' => $kelas])->result_array();
            $siswa = $this->input->get('siswa');
            if ($siswa) {
                $data['siswa_selected'] = $siswa;
            }
        }
        $nisn = $this->input->get('nisn');
        $download = $this->input->get('download');
        if ($download == 'true') {
            // Download file sertifikat berdasarkan nisn dan siswa
            $siswa_data = $this->db->get_where('tbl_data_siswa_poe_ibu', ['nisn' => $nisn])->row_array();
            $nama_siswa = str_replace(' ', '_', $siswa_data['nama']);
            if ($siswa_data) {
                // $file_path = base_url().'assets/dokumen/sertifikat_tka/'.$nisn;
                // var_dump($file_path);
                // exit;
                if (file_exists('assets/dokumen/tka/'.$nisn.'.pdf')) {
                    force_download('assets/dokumen/tka/'.$nisn.'.pdf', null);
                    redirect('tka');
                } else {
                    echo 'File sertifikat tidak ditemukan.';
                }
            } else {
                echo 'Data siswa tidak ditemukan.';
            }

            return;
        }
        $data['kelas'] = $this->db->get_where('tbl_kelas', ['tingkat' => 12])->result_array();
        $this->load->view('tka/tka_auth', $data);
    }
}
