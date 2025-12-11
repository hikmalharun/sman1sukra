<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();
$activeWorksheet->setCellValue('A1', 'Laporan Pe Ibu');
$activeWorksheet->setCellValue('A2', 'Kelas');
$activeWorksheet->setCellValue('B2', ':');
$activeWorksheet->setCellValue('C2', $kelas);
$activeWorksheet->setCellValue('A3', 'Bulan');
$activeWorksheet->setCellValue('B3', ':');
$activeWorksheet->setCellValue('C3', date('F Y', strtotime($bulan.'-01')));
$activeWorksheet->fromArray(
    [
        array_merge([
            'No',
            'NIPD',
            'Nama'],
            range(1, $bln['jumlah_hari']), ['Jumlah Per Siswa (Rp.)']),
    ],
    null,
    'A6'
);
$row = 7;
$no = 1;
foreach ($siswa as $s) {
    $col = 'A';
    $activeWorksheet->setCellValue($col.$row, $no++);
    ++$col;
    $activeWorksheet->setCellValue($col.$row, $s['nipd']);
    ++$col;
    $activeWorksheet->setCellValue($col.$row, $s['nama']);
    ++$col;

    $total_per_siswa = 0;

    for ($day = 1; $day <= $bln['jumlah_hari']; ++$day) {
        $date_str = sprintf('%s-%02d', $bulan, $day);
        $laporan_harian = array_filter($laporan, function ($lap) use ($s, $date_str) {
            return $lap['nipd'] === $s['nipd'] && $lap['tanggal_laporan'] === $date_str;
        });

        if (!empty($laporan_harian)) {
            $nominal = array_values($laporan_harian)[0]['nominal'];
            $activeWorksheet->setCellValue($col.$row, $nominal);
            $total_per_siswa += $nominal;
        } else {
            $activeWorksheet->setCellValue($col.$row, 0);
        }
        ++$col;
    }

    $activeWorksheet->setCellValue($col.$row, $total_per_siswa);
    ++$row;
}
// Menambahkan baris total keseluruhan
$col = 'A';
$activeWorksheet->setCellValue($col.$row, 'Jumlah Total (Rp.)');
$activeWorksheet->mergeCells($col.$row.':C'.$row);
++$col;
// Mulai colomn setelah kolom nama
for ($day = -1; $day <= $bln['jumlah_hari']; ++$day) {
    $date_str = sprintf('%s-%02d', $bulan, $day);
    $total_harian = 0;

    foreach ($laporan as $lap) {
        if ($lap['tanggal_laporan'] === $date_str) {
            $total_harian += $lap['nominal'];
        }
    }
    $activeWorksheet->setCellValue($col.$row, $total_harian);
    ++$col;
}
// Tambah Grand Total
$grand_total = 0;
foreach ($laporan as $lap) {
    $grand_total += $lap['nominal'];
}
$activeWorksheet->setCellValue($col.$row, $grand_total);

$writer = new Xlsx($spreadsheet);
$nama_file = 'laporan_poe_ibu_kelas_'.$kelas.'_bulan_'.date('m_Y', strtotime($bulan)).'.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$nama_file.'"');
// $writer->save($nama_file);
$writer->save('php://output');
exit;
