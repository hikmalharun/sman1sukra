<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Load vendor autoload untuk mPDF dan Endroid QR Code
require_once realpath(APPPATH.'../vendor/autoload.php');

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
                            ->get_where('tbl_absen_siswa', ['tanggal_absen' => date('Y-m-d')])
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

    // Endpoint JSON untuk load data absensi realtime
    public function get_absensi_json_admin()
    {
        $absensi = $this->db->get('tbl_absen_siswa')->result_array();

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
        $query = 'CREATE TABLE IF NOT EXISTS tbl_token_absen_siswa (
            id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            token VARCHAR(12) NOT NULL,
            tanggal_absen VARCHAR(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
        $this->db->query($query);
        $data['title'] = 'ABSEN SISWA';
        $token = $this->input->get('token');
        $data['token'] = $token;
        $cek_token = $this->db->get_where('tbl_token_absen_siswa', ['tanggal_absen' => date('Y-m-d')])->row_array();
        $data['cek_token'] = $cek_token;
        if ($cek_token) {
            $data['modal'] = 'show_input';
        } else {
            $data['modal'] = 'show_close';
        }
        $this->load->view('absen_siswa/absen_siswa', $data);
    }

    public function by_nisn()
    {
        $nisn = $this->input->post('nisn');

        $cek_data_siswa = $this->db->get_where('tbl_data_siswa_poe_ibu', ['nisn' => $nisn])->row_array();
        $get_token = $this->db->get_where('tbl_token_absen_siswa', ['tanggal_absen' => date('Y-m-d')])->row_array();
        $cek_absen_siswa = $this->db->get_where('tbl_absen_siswa', ['tanggal_absen' => date('Y-m-d'), 'id_siswa' => $nisn])->row_array();
        if ($cek_data_siswa) {
            if ($cek_absen_siswa) {
                $this->session->set_flashdata('notifikasi', '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Data sudah ada.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ');
                redirect('absen_siswa/index?token='.$get_token['token']);
            } else {
                // Simpan absensi baru
                $data = [
                    'id_siswa' => $nisn,
                    'tanggal_absen' => date('Y-m-d'),
                    'jam_absen' => date('H:i:s'),
                ];
                $this->db->insert('tbl_absen_siswa', $data);
                $this->session->set_flashdata('notifikasi', '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Data berhasil disimpan.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ');
                redirect('absen_siswa/index?token='.$get_token['token']);
            }
        } else {
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Data siswa tidak ditemukan
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
            redirect('absen_siswa/index?token='.$get_token['token']);
        }
    }

    // Auth
    public function auth()
    {
        $data['title'] = 'LOGIN';
        $this->load->view('absen_siswa/auth_login', $data);
    }

    // Login
    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $credential = [
            'username' => '69948448',
            'password' => '12345',
        ];

        if ($username == $credential['username']) {
            if ($password == $credential['password']) {
                $data = [
                    'nama' => 'Admin',
                    'jabatan' => 'Admin',
                ];
                $this->session->set_userdata($data);
                $this->session->set_flashdata('notifikasi', '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Selamat datang '.$this->session->userdata('nama').'.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ');
                redirect('absen_siswa/admin');
            } else {
                $this->session->set_flashdata('notifikasi', '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Username dan Password salah.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ');
                redirect('absen_siswa/auth');
                $this->session->set_flashdata('notifikasi', '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Username dan Password salah.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ');
                redirect('absen_siswa/auth');
            }
        } else {
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Username dan Password salah.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
            redirect('absen_siswa/auth');
        }
    }

    // Admin
    public function admin()
    {
        if ($this->session->userdata('nama')) {
            $data['title'] = 'Admin';
            $data['data_absen'] = $this->db->get('tbl_absen_siswa')->result_array();
            $token = $this->db->get_where('tbl_token_absen_siswa', ['tanggal_absen' => date('Y-m-d')])->row_array();
            // var_dump($token);
            // exit;
            if ($token) {
                $data['token'] = $token;
            } else {
                $data['token'] = '';
            }
            $data['report_by'] = $this->input->get('report_by');
            $data['kelas'] = $this->db->get('tbl_kelas')->result_array();
            $this->load->view('absen_siswa/admin', $data);
        } else {
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Anda tidak memiliki izin untuk mengakses halaman ini, silahkan login!.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
            redirect('absen_siswa/auth');
        }
    }

    // Simpan Token
    public function simpan_token()
    {
        // Buat tabel jika belum ada
        $query = 'CREATE TABLE IF NOT EXISTS tbl_token_absen_siswa (
        id_absensi INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        token VARCHAR(12) NOT NULL,
        tanggal_absen DATE NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
        $this->db->query($query);

        $data = json_decode(file_get_contents('php://input'), true);
        $token = $data['token'] ?? null;

        if ($token) {
            $tanggal = date('Y-m-d');

            // cek apakah sudah ada token untuk hari ini
            $cek = $this->db->get_where('tbl_token_absen_siswa', ['tanggal_absen' => $tanggal])->row();

            if ($cek) {
                echo json_encode(['status' => 'error', 'message' => 'Token sudah dibuat hari ini']);

                return;
            }

            $data_token = [
                'token' => $token,
                'tanggal_absen' => $tanggal,
            ];
            $this->db->insert('tbl_token_absen_siswa', $data_token);

            echo json_encode(['status' => 'success', 'token' => $token]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Token kosong']);
        }
    }

    // Logout
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('absen_siswa/auth');
    }

    // Buat Kartu Identitas Siswa
    public function buat_kartu_identitas($nisn = null)
    {
        if (!$this->session->userdata('nama')) {
            $this->session->set_flashdata('notifikasi', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Anda tidak memiliki izin untuk mengakses halaman ini, silahkan login!.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
            redirect('absen_siswa/auth');
        }

        // Jika NISN diberikan, generate PDF kartu identitas
        if ($nisn) {
            $siswa = $this->db->get_where('tbl_data_siswa_poe_ibu', ['nisn' => $nisn])->row_array();

            if (!$siswa) {
                show_404();

                return;
            }

            try {
                // Path ke gambar background
                $card_1_path = FCPATH.'assets/img/card_1.png';
                $card_2_path = FCPATH.'assets/img/card_2.png';

                // Validasi gambar ada
                if (!file_exists($card_1_path) || !file_exists($card_2_path)) {
                    throw new Exception('File gambar card_1.png atau card_2.png tidak ditemukan di assets/img/');
                }

                // Convert gambar ke base64
                $card_1_base64 = base64_encode(file_get_contents($card_1_path));
                $card_2_base64 = base64_encode(file_get_contents($card_2_path));

                // Generate QR Code menggunakan API online
                $qr_url = 'https://api.qrserver.com/v1/create-qr-code/?size=400x400&data='.urlencode($nisn);
                $qr_data = file_get_contents($qr_url);
                $qr_base64 = base64_encode($qr_data);

                // Buat PDF menggunakan mPDF - Ukuran KTP standar (54 x 86 mm)
                $mpdf = new Mpdf\Mpdf([
                    'format' => [54, 86],
                    'margin_left' => 0,
                    'margin_right' => 0,
                    'margin_top' => 0,
                    'margin_bottom' => 0,
                    'default_font' => 'Arial',
                ]);

                // ===== HALAMAN 1: SISI DEPAN (DATA SISWA) =====
                $html_depan = '
                <div style="width: 54mm; height: 86mm; position: relative; background-image: url(data:image/png;base64,'.$card_1_base64.'); background-size: cover; background-position: center; padding: 4mm; box-sizing: border-box;">
                    <div style="font-size: 12px; color: #000653;; text-align: left; margin-top: 1mm; font-weight: bold">KARTU ABSEN SISWA</div>
                    <div style="margin-top: 170px; font-size: 14px; text-align: center; font-weight: bold; color: #000653;">'.htmlspecialchars(strtoupper($siswa['nama'])).'</div>
                    <table width"100%" style="font-size: 10px;">
                        <tr>
                            <td width="40px"></td>
                            <td width="20px">NIPD</td>
                            <td width="5px">:</td>
                            <td>'.htmlspecialchars($siswa['nipd']).'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>NISN</td>
                            <td>:</td>
                            <td>'.htmlspecialchars($siswa['nisn']).'</td>
                        </tr>
                    </table>
                </div>
                ';

                $mpdf->WriteHTML($html_depan);

                // PAGE BREAK - Halaman 2
                $mpdf->AddPage();

                // ===== HALAMAN 2: SISI BELAKANG (QR CODE) =====
                $html_belakang = '
                <div style="width: 54mm; height: 86mm; position: relative; background-image: url(data:image/png;base64,'.$card_2_base64.'); background-size: cover; background-position: center; padding: 3mm; box-sizing: border-box; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                    <div style="text-align: center; margin-top: 60px;">
                        <img src="data:image/png;base64,'.$qr_base64.'" style="width: 36mm; height: 36mm; margin: 2mm 0;" />
                        <div style="font-size: 10px; color: #333; margin-top: 1mm;">'.htmlspecialchars($siswa['nisn']).'</div>
                    </div>
                </div>
                ';

                $mpdf->WriteHTML($html_belakang);

                // Output PDF using mPDF's built-in headers (safer)
                $filename = 'Kartu_Identitas_'.str_replace(' ', '_', $siswa['nama']).'_'.$siswa['nisn'].'.pdf';
                $mpdf->Output($filename, 'I');
                exit;
            } catch (Exception $e) {
                $data['error'] = 'Error Generate PDF: '.$e->getMessage();
                $data['siswa'] = $this->db->get('tbl_data_siswa_poe_ibu')->result_array();
                $this->load->view('absen_siswa/buat_kartu_identitas', $data);

                return;
            }
        }

        // Tampilkan halaman list siswa
        $data['title'] = 'Buat Kartu Identitas Siswa';
        $data['siswa'] = $this->db->get('tbl_data_siswa_poe_ibu')->result_array();
        $this->load->view('absen_siswa/buat_kartu_identitas', $data);
    }

    public function buat_kartu_identitas_batch()
    {
        $nisn_list = $this->input->get('nisn');
        if (!$nisn_list) {
            show_404();

            return;
        }

        $nisn_array = explode(',', $nisn_list);
        $siswa_data = $this->db->where_in('nisn', $nisn_array)->get('tbl_data_siswa_poe_ibu')->result_array();

        if (empty($siswa_data)) {
            show_404();

            return;
        }

        // Generate PDF gabungan untuk semua siswa yang dipilih
        try {
            // Path ke gambar background
            $card_1_path = FCPATH.'assets/img/card_1.png';
            $card_2_path = FCPATH.'assets/img/card_2.png';

            // Validasi gambar ada
            if (!file_exists($card_1_path) || !file_exists($card_2_path)) {
                throw new Exception('File gambar card_1.png atau card_2.png tidak ditemukan di assets/img/');
            }

            // Convert gambar ke base64
            $card_1_base64 = base64_encode(file_get_contents($card_1_path));
            $card_2_base64 = base64_encode(file_get_contents($card_2_path));

            // Buat PDF menggunakan mPDF - Ukuran KTP standar (54 x 86 mm)
            $mpdf = new Mpdf\Mpdf([
                'format' => [210, 297],
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'default_font' => 'Arial',
            ]);

            foreach ($siswa_data as $siswa) {
                // Generate QR Code menggunakan API online
                $qr_url = 'https://api.qrserver.com/v1/create-qr-code/?size=400x400&data='.urlencode($siswa['nisn']);
                $qr_data = file_get_contents($qr_url);
                $qr_base64 = base64_encode($qr_data);

                // ===== HALAMAN 1: SISI DEPAN (DATA SISWA) =====
                $html = '
                <div style="width: 54mm; height: 86mm; position: relative; background-image: url(data:image/png;base64,'.$card_1_base64.'); background-size: cover; background-position: center; padding: 0.2mm; box-sizing: border-box; margin-bottom: 5px; border-radius: 10px;">
                    <div style="font-size: 12px; color: #000653;; text-align: left; padding-left: 4mm; margin-top: 3.2mm; font-weight: bold">KARTU ABSEN SISWA</div>
                    <div style="margin-top: 180px; font-size: 14px; text-align: center; font-weight: bold; color: #000653;">'.htmlspecialchars(strtoupper($siswa['nama'])).'</div>
                    <table width"100%" style="font-size: 10px; margin-left: 3mm;">
                        <tr>
                            <td width="40px"></td>
                            <td width="20px">NIPD</td>
                            <td width="5px">:</td>
                            <td>'.htmlspecialchars($siswa['nipd']).'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>NISN</td>
                            <td>:</td>
                            <td>'.htmlspecialchars($siswa['nisn']).'</td>
                        </tr>
                    </table>
                </div>';

                // ===== HALAMAN 2: SISI BELAKANG (QR CODE) =====
                $html .= '
                <div style="width: 54mm; height: 86mm; position: relative; background-image: url(data:image/png;base64,'.$card_2_base64.'); background-size: cover; background-position: center; padding: 0.2mm; box-sizing: border-box; border-radius: 10px;">
                    <div style="text-align: center; margin-top: 60px;">
                        <img src="data:image/png;base64,'.$qr_base64.'" style="width: 36mm; height: 36mm; margin: 2mm 0;" />
                        <div style="font-size: 10px; color: #333; margin-top: 1mm;">'.htmlspecialchars($siswa['nisn']).'</div>
                    </div>
                </div>';

                $mpdf->WriteHTML($html);
                // Tambahkan page break setelah setiap kartu kecuali yang terakhir
                if ($siswa !== end($siswa_data)) {
                    $mpdf->AddPage();
                }
            }

            // Simpan PDF ke file
            $pdf_name = 'kartu_identitas_siswa.pdf';
            $mpdf->Output($pdf_name, 'I');
        } catch (Exception $e) {
            show_error($e->getMessage());
        }
    }

    public function list_siswa()
    {
        $data['title'] = 'List Siswa';
        $data['siswa'] = $this->db->get('tbl_data_siswa_poe_ibu')->result_array();
        $this->load->view('absen_siswa/list_siswa', $data);
    }

    public function print_report()
    {
        $kode = $this->input->post('kode'); // Kode merupakan tanggal atau bulan
        $kelas = $this->input->post('kelas');
        $data_siswa = $this->db->get_where('tbl_data_siswa_poe_ibu', ['kelas' => $kelas])->result_array();

        // Ambil data berdasarkan kode: 'tanggal' atau 'bulan'
        if ($kode == 'tanggal') {
            $tanggal = $this->input->post('tanggal');
            $data_absen = $this->db->get_where('tbl_absen_siswa', ['tanggal_absen' => $tanggal])->result_array();
            $period_label = 'Tanggal: '.htmlspecialchars($tanggal);
        } else {
            // Terima input bulan dalam format YYYY-MM, MM/YYYY, atau MM
            $bulan_input = $this->input->post('bulan');
            $tahun_input = $this->input->post('tahun') ?: date('Y');
            $month = '';
            $year = $tahun_input;
            if (strpos($bulan_input, '-') !== false) {
                list($year, $month) = explode('-', $bulan_input);
            } elseif (strpos($bulan_input, '/') !== false) {
                list($month, $year) = explode('/', $bulan_input);
            } else {
                $month = $bulan_input;
            }
            $month = str_pad(trim($month), 2, '0', STR_PAD_LEFT);
            $year = trim($year);
            $dateLike = $year.'-'.$month;
            // Gunakan DATE_FORMAT untuk mencocokkan bulan pada kolom tanggal_absen
            $data_absen = $this->db->where("DATE_FORMAT(tanggal_absen, '%Y-%m') = '$dateLike'")->get('tbl_absen_siswa')->result_array();
            // Nama bulan Indonesia
            $nama_bulan = [
                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
            ];
            $period_label = 'Bulan: '.($nama_bulan[$month] ?? $month).' '.$year;
        }

        // Gabungkan data siswa dan absen, sertakan jam absen sesuai tanggal data_absen disetiap jumlah hari pada bulan
        // --- Generate HTML Laporan ---
        $judul = 'LAPORAN ABSEN SISWA';
        $kelas_label = 'Kelas: '.htmlspecialchars($kelas);
        $html = '<h3 style="text-align:center;">'.$judul.'</h3>';
        $html .= '<p style="text-align:center;">'.$kelas_label.'<br>'.$period_label.'</p>';

        // Tabel header
        $html .= '<table border="1" cellpadding="5" cellspacing="0" width="100%" style="border-collapse:collapse;font-size:10px;">';
        $html .= '<thead><tr>';
        $html .= '<th>No.</th><th>NISN</th><th>Nama</th>';
        if ($kode == 'tanggal') {
            $html .= '<th>Jam Absen</th><th>Terlambat</th>';
        } else {
            // Kolom hari di bulan
            $hari = cal_days_in_month(CAL_GREGORIAN, (int) $month, (int) $year);
            for ($d = 1; $d <= $hari; ++$d) {
                $tgl = $year.'-'.$month.'-'.str_pad($d, 2, '0', STR_PAD_LEFT);
                $html .= '<th width="2.3%">'.(int) $d.'</th>';
            }
            $html .= '<th>Terlambat</th>';
        }
        $html .= '</tr></thead><tbody>';

        // Index absen by nisn+date
        $absen_map = [];
        foreach ($data_absen as $absen) {
            $absen_map[$absen['id_siswa']][$absen['tanggal_absen']] = $absen['jam_absen'];
        }

        $no = 1;
        foreach ($data_siswa as $siswa) {
            $html .= '<tr>';
            $html .= '<td style="text-align:center;">'.$no++.'</td>';
            $html .= '<td style="text-align:center;">'.htmlspecialchars($siswa['nisn']).'</td>';
            $html .= '<td>'.htmlspecialchars($siswa['nama']).'</td>';
            if ($kode == 'tanggal') {
                $jam = isset($absen_map[$siswa['nisn']][$tanggal]) ? $absen_map[$siswa['nisn']][$tanggal] : '-';
                $terlambat = '-';
                if ($jam !== '-' && $jam > '06:30:00') {
                    $jam_masuk = strtotime('06:30:00');
                    $jam_absen = strtotime($jam);
                    $diff = $jam_absen - $jam_masuk;
                    $menit = floor($diff / 60);
                    $jam_terlambat = floor($menit / 60);
                    $menit_terlambat = $menit % 60;
                    $terlambat = ($jam_terlambat > 0 ? $jam_terlambat.' jam ' : '').$menit_terlambat.' menit';
                }
                if ($jam > '06.30.00') {
                    $html .= '<td style="text-align:center; color: red;">'.$jam.'</td>';
                } else {
                    $html .= '<td style="text-align:center;">'.$jam.'</td>';
                }
                $html .= '<td style="text-align:center;">'.$terlambat.'</td>';
            } else {
                $total_terlambat = 0;
                $total_terlambat_jam = 0;
                for ($d = 1; $d <= $hari; ++$d) {
                    $tgl = $year.'-'.$month.'-'.str_pad($d, 2, '0', STR_PAD_LEFT);
                    $jam = isset($absen_map[$siswa['nisn']][$tgl]) ? $absen_map[$siswa['nisn']][$tgl] : '-';
                    $cell = $jam;
                    if ($jam !== '-' && $jam > '06:30:00') {
                        $jam_masuk = strtotime('06:30:00');
                        $jam_absen = strtotime($jam);
                        $diff = $jam_absen - $jam_masuk;
                        $menit = floor($diff / 60);
                        $jam_terlambat = floor($menit / 60);
                        $menit_terlambat = $menit % 60;
                        $total_terlambat += $menit;
                        $total_terlambat_jam += $jam_terlambat;
                        // Format jam absen menjadi HH<br>mm<br>ss
                        $jam_parts = explode(':', $jam);
                        $cell = '<span style="color:red;font-weight:bold;">'.($jam_parts[0] ?? '').'<br>'.($jam_parts[1] ?? '').'<br>'.($jam_parts[2] ?? '').'</span>';
                    } elseif ($jam !== '-' && $jam !== '') {
                        // Format jam absen menjadi HH<br>mm<br>ss
                        $jam_parts = explode(':', $jam);
                        $cell = ($jam_parts[0] ?? '').'<br>'.($jam_parts[1] ?? '').'<br>'.($jam_parts[2] ?? '');
                    }
                    $html .= '<td style="text-align:center;">'.$cell.'</td>';
                }
                $terlambat_kumulatif = ($total_terlambat_jam > 0 ? $total_terlambat_jam.' jam ' : '').($total_terlambat % 60).' menit';
                $html .= '<td style="text-align:center;">'.$terlambat_kumulatif.'</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';

        // --- Generate PDF ---
        if ($kode == 'tanggal') {
            $mpdf = new Mpdf\Mpdf([
                'orientation' => 'P',
                'format' => 'A4',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'default_font' => 'Arial Narrow',
            ]);
        } else {
            $mpdf = new Mpdf\Mpdf([
                'orientation' => 'L',
                'format' => 'A4',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'default_font' => 'Arial Narrow',
            ]);
        }
        // Footer kiri: text, kanan bawah: page number
        $footer_html = '<div style="width:100%;font-size:10px;">'
            .'<span style="float:left;">Laporan Absen Siswa Kelas :'.$kelas.' '.$period_label.' | </span>'
            .'<span style="float:right;">Halaman {PAGENO}</span>'
            .'</div>';
        $mpdf->SetHTMLFooter($footer_html);
        $mpdf->WriteHTML($html);
        $filename = 'Laporan_Absen_Siswa_'.$kelas.'_'.($kode == 'tanggal' ? str_replace('-', '', $tanggal) : $dateLike).'.pdf';
        $mpdf->Output($filename, 'I'); // langsung download/new tab
        exit;
    }
}
