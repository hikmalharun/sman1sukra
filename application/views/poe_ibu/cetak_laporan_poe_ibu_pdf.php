<?php

use Mpdf\Mpdf;

date_default_timezone_set('Asia/Jakarta');
$mpdf = new Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'default_font_size' => 10,
    'default_font' => 'Calibri',
    'margin_left' => 10,
    'margin_right' => 10,
    'margin_top' => 8,
    'margin_bottom' => 18,
    'margin_header' => 4,
    'margin_footer' => 4,
    'orientation' => 'L',
]);
$mpdf->SetTitle('Laporan Poe Ibu Kelas '.$kelas.' Bulan '.date('F Y', strtotime($bulan.'-01')));
$mpdf->WriteHTML($this->load->view('poe_ibu/cetak_laporan_poe_ibu_pdf_html', $data, true));
$mpdf->Output('Laporan Poe Ibu Kelas '.$kelas.' Bulan '.date('F Y', strtotime($bulan.'-01')), 'I');
