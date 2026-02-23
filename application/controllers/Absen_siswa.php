<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Load vendor autoload untuk mPDF dan Endroid QR Code
require_once APPPATH.'../vendor/autoload.php';

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

    public function print_report()
    {
        $kode = $this->input->post('kode');
        $kelas = $this->input->post('kelas');

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
            $period_label = 'Bulan: '.htmlspecialchars($dateLike);
        }

        // Ambil data siswa berdasarkan kelas
        $data_siswa = $this->db->get_where('tbl_data_siswa_poe_ibu', ['kelas' => $kelas])->result_array();

        // Gabungkan data siswa dan absen
        $data['absen_siswa'] = [];
        foreach ($data_siswa as $siswa) {
            $found = null;
            foreach ($data_absen as $a) {
                // Cocokkan id_siswa (absen) dengan nisn (siswa)
                if (isset($a['id_siswa']) && $a['id_siswa'] == $siswa['nisn']) {
                    $found = $a;
                    break;
                }
            }
            if ($found) {
                $row = array_merge($siswa, $found);
            } else {
                $row = $siswa;
                $row['tanggal_absen'] = '';
                $row['jam_absen'] = '';
            }
            $data['absen_siswa'][] = $row;
        }

        // Build HTML report
        $html = '<div style="text-align: center;">';
        $html .= '<h2 style="margin:0;">Rekapitulasi Absen Siswa</h2>';
        $html .= '<div style="margin-bottom:8px; font-size:12px;">'.htmlspecialchars('Kelas: '.$kelas).' &nbsp;|&nbsp; '.htmlspecialchars($period_label).'</div>';
        $html .= '</div>';

        $html .= '<table border="1" cellpadding="6" cellspacing="0" width="100%" style="border-collapse: collapse; font-size:12px;">';
        $html .= '<thead><tr style="background:#f0f0f0;"><th style="width:40px;">No</th><th>Nama</th><th>NISN</th><th>Jam</th><th>Terlambat (menit)</th></tr></thead>';
        $html .= '<tbody>';
        $no = 1;
        foreach ($data['absen_siswa'] as $row) {
            $jam_row = htmlspecialchars($row['jam_absen'] ?? ($row['jam'] ?? ''));
            $terlambat_html = '';
            if ($jam_row) {
                // Hitung selisih menit dari 06:30
                $jam_masuk = strtotime('06:30');
                $jam_absen = strtotime($jam_row);
                $selisih = round(($jam_absen - $jam_masuk) / 60);
                if ($selisih > 0) {
                    $terlambat_html = '<span style="color:red;font-weight:bold;">'.$selisih.' menit</span>';
                } else {
                    $terlambat_html = '0';
                }
            } else {
                $jam_row = '<span style="color:red;font-weight:bold;">Tidak Absen</span>';
                $terlambat_html = '<span style="color:red;font-weight:bold;">Tidak Hadir</span>';
            }
            $html .= '<tr>';
            $html .= '<td style="text-align:center;">'.$no.'</td>';
            $html .= '<td>'.htmlspecialchars($row['nama'] ?? '').'</td>';
            $html .= '<td style="text-align:center;">'.htmlspecialchars($row['nisn'] ?? '').'</td>';
            $html .= '<td style="text-align:center;">'.$jam_row.'</td>';
            $html .= '<td style="text-align:center;">'.$terlambat_html.'</td>';
            $html .= '</tr>';
            ++$no;
        }
        $html .= '</tbody></table>';

        // Generate PDF
        try {
            $mpdf = new Mpdf\Mpdf(['format' => 'A4', 'margin_left' => 10, 'margin_right' => 10, 'margin_top' => 10, 'margin_bottom' => 10]);
            $title = 'Rekapitulasi Absen Siswa '.str_replace(['&nbsp;'], ' ', $period_label).' Kelas '.$kelas;
            $mpdf->SetTitle($title);
            $mpdf->WriteHTML($html);
            $safe_period = preg_replace('/[^A-Za-z0-9_\-]/', '_', $period_label);
            $safe_kelas = preg_replace('/[^A-Za-z0-9_\-]/', '_', $kelas);
            $filename = 'Rekapitulasi_Absen_Siswa_'.$safe_period.'_Kelas_'.$safe_kelas.'.pdf';
            $mpdf->Output($filename, 'D');
            exit;
        } catch (Exception $e) {
            $data['error'] = 'Error Generate PDF: '.$e->getMessage();
            $data['title'] = 'Rekap Absen';
            $this->load->view('absen_siswa/print_report', $data);

            return;
        }
    }
}
