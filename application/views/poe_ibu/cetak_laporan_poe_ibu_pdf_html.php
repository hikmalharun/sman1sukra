<html>
<head>
    <title>Laporan Poe Ibu</title>
    <style>
        body {
            font-family: Calibri, sans-serif;
            font-size: 5pt;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 5px;
        }

        th {
            background-color: #f2f2f2;
        }

        h2, h4 {
            text-align: center;
            margin: 0;
        }
    </style>
</head>
<body>
    <h2>Laporan Poe Ibu</h2>
    <h4>Kelas: <?php echo $kelas; ?> | Bulan: <?php echo date('F Y', strtotime($bulan.'-01')); ?></h4>
    <br>
    <table>
        <thead style="text-align: center;">
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">NIPD</th>
                <th rowspan="2">Nama</th>
                <th colspan="<?php echo $bln['jumlah_hari']; ?>">Tanggal (<?php echo date('F', strtotime($bulan)); ?> 2025)</th>
                <th rowspan="2">Jumlah Per Siswa (Rp.)</th>
            </tr>
            <tr>
            <?php for ($i = 1; $i <= $bln['jumlah_hari']; ++$i) { ?>
                <th style="width: 25px;"><?php echo $i; ?></th>
            <?php } ?>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
    foreach ($siswa as $s) {
        echo '<tr>';
        echo '<td style="text-align: center;">'.$no++.'</td>';
        echo '<td style="text-align: center;">'.$s['nipd'].'</td>';
        echo '<td>'.$s['nama'].'</td>';

        $total_per_siswa = 0;

        for ($day = 1; $day <= $bln['jumlah_hari']; ++$day) {
            $date_str = sprintf('%s-%02d', $bulan, $day);
            $laporan_harian = array_filter($laporan, function ($lap) use ($s, $date_str) {
                return $lap['nipd'] === $s['nipd'] && $lap['tanggal_laporan'] === $date_str;
            });

            if (!empty($laporan_harian)) {
                $nominal = array_values($laporan_harian)[0]['nominal'];
                echo '<td style="text-align: center;">'.number_format($nominal, 0, ',', '.').'</td>';
                $total_per_siswa += $nominal;
            } else {
                echo '<td style="text-align: center;">0</td>';
            }
        }

        echo '<td style="text-align: center; font-weight: bold;">'.number_format($total_per_siswa, 0, ',', '.').'</td>';
        echo '</tr>';
    }
    ?>
    <tr style="background-color: #f9f9f9;">
        <td colspan="3"><strong>Jumlah Total (Rp.)</strong></td>
        <?php
        for ($day = 1; $day <= $bln['jumlah_hari'];
            ++$day) {
            $date_str = sprintf('%s-%02d', $bulan, $day);
            $total_harian = 0;

            foreach ($laporan as $lap) {
                if ($lap['tanggal_laporan'] === $date_str) {
                    $total_harian += $lap['nominal'];
                }
            }

            echo '<td style="text-align: center; font-weight: bold;">'.number_format($total_harian, 0, ',', '.').'</td>';
        }
    ?>
        <td style="text-align: center; font-weight: bold;">
            <?php
            $grand_total = 0;
    foreach ($laporan as $lap) {
        $grand_total += $lap['nominal'];
    }
    echo number_format($grand_total, 0, ',', '.');
    ?>
        </td>
    </tr>
        </tbody>
    </table>
</html>