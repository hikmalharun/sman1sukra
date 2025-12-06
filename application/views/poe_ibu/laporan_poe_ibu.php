<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laporan</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/img/logo_sman1sukra.png'); ?>">
    </head>
    <body>
        <div class="container">
        <nav class="navbar bg-primary mb-3">
            <div class="container-fluid">
                <a class="navbar-brand text-white">
                    <h3>Laporan Poe Ibu</h3>
                </a>
                <div class="d-flex">
                    <a href="<?php echo base_url('poe_ibu/auth_logout'); ?>">
                        <button class="btn btn-outline-light btn-sm" type="button"><i class="bi bi-box-arrow-left"></i> Logout</button>
                    </a>
                </div>
            </div>
        </nav>
        <div class="alert alert-info" role="alert">
            <table width="100%">
                <tr>
                    <td width="8%">Nama</td>
                    <td width="1%">:</td>
                    <td><?php echo $this->session->userdata('nama'); ?></td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td><?php echo $this->session->userdata('jabatan'); ?></td>
                </tr>
                <tr>
                    <td>
                        <?php if ($this->session->userdata('kelas') == 'SMA NEGERI 1 SUKRA') { ?>
                            Sekolah
                        <?php } else { ?>
                            Kelas
                        <?php } ?>
                    </td>
                    <td>:</td>
                    <td><?php echo $this->session->userdata('kelas'); ?></td>
                </tr>
            </table>
        </div>
        <div class="mb-3"></div>
        <?php if ($this->session->userdata('kelas') == 'SMA NEGERI 1 SUKRA') { ?>
            <div class="accordion mb-3" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Rekapitulasi Poe Ibu
                    </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Kelas</th>
                                        <th scope="col">Total Nominal (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $kelas_list = [
                                        'X-1', 'X-2', 'X-3',
                                        'XI-1', 'XI-2', 'XI-3', 'XI-4', 'XI-5',
                                        'XII-1', 'XII-2', 'XII-3', 'XII-4',
                                    ];
            foreach ($kelas_list as $kls) {
                $total_kelas = $this->db->query("SELECT SUM(nominal) AS total FROM tbl_data_poe_ibu WHERE kelas = '$kls'")->row_array();
                ?>
                                        <tr>
                                            <td class="text-center" scope="row"><?php echo $kls; ?></td>
                                            <td class="text-center">Rp
                                                <?php if ($total_kelas['total'] != null) {
                                                    echo number_format($total_kelas['total'], 0, ',', '.');
                                                } else {
                                                    echo '0';
                                                } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <th class="text-center">Grand Total</th>
                                        <th class="text-center">
                                            Rp <?php
                                            $grand_total = $this->db->query('SELECT SUM(nominal) AS grand_total FROM tbl_data_poe_ibu')->row_array();
            echo number_format($grand_total['grand_total'], 0, ',', '.');
            ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-between mb-2">
                <h4>Laporan Poe Ibu</h4>
                <div class="justify-content-md-end">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle mb-2" style="width: 120px;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Filter Laporan
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo base_url('poe_ibu/laporan_poe_ibu'); ?>">Reset</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#kelas">Kelas</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#harian">Harian</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#bulanan">Bulanan</a></li>
                        </ul>
                    </div>
                    <?php if ($kelas) { ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle mb-2" style="width: 120px;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Pilih Bulan
                            </button>
                            <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo base_url('poe_ibu/laporan_poe_ibu?kelas='.$kelas.'&bulan='.date('Y').'-01'); ?>">Januari</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('poe_ibu/laporan_poe_ibu?kelas='.$kelas.'&bulan='.date('Y').'-02'); ?>">Februari</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('poe_ibu/laporan_poe_ibu?kelas='.$kelas.'&bulan='.date('Y').'-03'); ?>">Maret</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('poe_ibu/laporan_poe_ibu?kelas='.$kelas.'&bulan='.date('Y').'-04'); ?>">April</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('poe_ibu/laporan_poe_ibu?kelas='.$kelas.'&bulan='.date('Y').'-05'); ?>">Mei</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('poe_ibu/laporan_poe_ibu?kelas='.$kelas.'&bulan='.date('Y').'-06'); ?>">Juni</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('poe_ibu/laporan_poe_ibu?kelas='.$kelas.'&bulan='.date('Y').'-07'); ?>">Juli</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('poe_ibu/laporan_poe_ibu?kelas='.$kelas.'&bulan='.date('Y').'-09'); ?>">Agustus</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('poe_ibu/laporan_poe_ibu?kelas='.$kelas.'&bulan='.date('Y').'-09'); ?>">Setember</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('poe_ibu/laporan_poe_ibu?kelas='.$kelas.'&bulan='.date('Y').'-10'); ?>">Oktober</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('poe_ibu/laporan_poe_ibu?kelas='.$kelas.'&bulan='.date('Y').'-11'); ?>">November</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('poe_ibu/laporan_poe_ibu?kelas='.$kelas.'&bulan='.date('Y').'-12'); ?>">Desember</a></li>
                            </ul>
                        </div>
                    <?php } ?>
                    <!-- Modal Harian -->          
                    <div class="modal fade" id="kelas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Laporan Poe Ibu</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form action="<?php echo base_url('poe_ibu/laporan_poe_ibu'); ?>" method="get">
                                <label for="kelas">Pilih Kelas</label>
                                <select class="form-control mb-3" name="kelas" id="kelas">
                                    <option value="">Pilih Kelas</option>
                                    <option value="X-1">X-1</option>
                                    <option value="X-2">X-2</option>
                                    <option value="X-3">X-3</option>
                                    <option value="XI-1">XI-1</option>
                                    <option value="XI-2">XI-2</option>
                                    <option value="XI-3">XI-3</option>
                                    <option value="XI-4">XI-4</option>
                                    <option value="XI-5">XI-5</option>
                                    <option value="XII-1">XII-1</option>
                                    <option value="XII-2">XII-2</option>
                                    <option value="XII-3">XII-3</option>
                                    <option value="XII-4">XII-4</option>
                                </select>
                                <label for="bulan">Pilih Bulan</label>
                                <input type="month" name="bulan" class="form-control mb-2" id="bulan" required>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button class="btn btn-outline-success btn-sm" type="submit">Lihat Laporan</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Harian -->          
                <div class="modal fade" id="harian" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Laporan Poe Ibu</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form action="<?php echo base_url('poe_ibu/laporan_poe_ibu'); ?>" method="get">
                                <label for="bulan">Pilih Tanggal</label>
                                <input type="date" name="tanggal" class="form-control mb-2" id="tanggal" required>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button class="btn btn-outline-success btn-sm" type="submit">Lihat Laporan</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Bulanan -->          
                <div class="modal fade" id="bulanan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Laporan Poe Ibu</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form action="<?php echo base_url('poe_ibu/laporan_poe_ibu'); ?>" method="get">
                                <label for="bulan">Pilih Bulan</label>
                                <input type="month" name="bulan" class="form-control mb-2" id="bulan" required>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button class="btn btn-outline-success btn-sm" type="submit">Lihat Laporan</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        <?php } else { ?>
            <a href="<?php echo base_url('poe_ibu/input_harian?kelas='.$kelas); ?>">
                <button class="btn btn-outline-primary btn-sm" type="button">Kembali ke Input Harian</button>
            </a>    
        <?php } ?>
        <?php if ($kelas) { ?>
            <table>
                <tr>
                    <td><strong>Kelas</strong></td>
                    <td><strong> : </strong></td>
                    <td><strong><?php echo $kelas; ?></strong></td>
                </tr>
                <tr>
                    <td><strong>Bulan</strong></td>
                    <td><strong> : </strong></td>
                    <td><strong><?php echo date('F', strtotime($bulan)).date('Y'); ?></strong></td>
                </tr>
            </table>
            <div class="table-responsive">
                <table class="table table-bordered" style="font-size: 10px;">
                    <thead class="text-center">
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">NIPD</th>
                        <th rowspan="2">Nama</th>
                        <th colspan="<?php echo $bln['jumlah_hari']; ?>">Tanggal (<?php echo date('F', strtotime($bulan)).date('Y'); ?>)</th>
                    </tr>
                    <tr>
                        <?php for ($i = 1; $i <= $bln['jumlah_hari']; ++$i) { ?>
                            <th><?php echo $i; ?></th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
            $no = 1;
            foreach ($siswa as $s) { ?>
                        <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td class="text-center"><?php echo $s['nipd']; ?></td>
                        <td><?php echo $s['nama']; ?></td>
                        <?php
                for ($j = 1; $j <= $bln['jumlah_hari']; ++$j) {
                    $tanggal = date('Y-m-', strtotime($bulan)).sprintf('%02d', $j);
                    $poe_ibu = $this->db->get_where('tbl_data_poe_ibu', [
                        'nipd' => $s['nipd'],
                        'tanggal_laporan' => $tanggal,
                    ])->row_array(); ?>
                    <?php if ($poe_ibu) { ?>
                        <td class="bg-success text-white text-center">
                            <?php echo number_format($poe_ibu['nominal'], 0, ',', '.'); ?>
                        </td>
                    <?php } else { ?>
                        <td class="bg-danger text-center">0</td>
                    <?php } ?>
                <?php } ?>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="3" class="text-center">Total</th>
                        <?php
            for ($k = 1; $k <= $bln['jumlah_hari']; ++$k) {
                $tanggal_total = date('Y-m-', strtotime($bulan)).sprintf('%02d', $k);
                $total_harian = $this->db->query("SELECT SUM(nominal) AS total FROM tbl_data_poe_ibu WHERE kelas = '$kelas' AND tanggal_laporan = '$tanggal_total'")->row_array();
                ?>
                        <th class="text-center">
                            <?php if ($total_harian['total'] != null) {
                                echo number_format($total_harian['total'], 0, ',', '.');
                            } else {
                                echo '0';
                            } ?>
                        </th>
                        <?php } ?>
                    </tr>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="table-responsive">
                <table width="100%" class="table table-bordered mt-3">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">No</th>
                            <th scope="col">Tanggal Laporan</th>
                            <th scope="col">NIPD</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Nominal (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                    $no = 1;
            $total = 0;
            foreach ($laporan as $l) {
                $total += $l['nominal'];
                ?>
                            <tr>
                                <td class="text-center" scope="row"><?php echo $no++; ?></td>
                                <td class="text-center"><?php echo date('d F Y', strtotime($l['tanggal_laporan'])); ?></td>
                                <td class="text-center"><?php echo $l['nipd']; ?></td>
                                <td><?php echo $l['nama']; ?></td>
                                <td class="text-center"><?php echo $l['kelas']; ?></td>
                                <td class="text-center"><?php echo number_format($l['nominal'], 0, ',', '.'); ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="5" class="text-end">Total</th>
                            <th class="text-center">Rp <?php echo number_format($total, 0, ',', '.'); ?></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php } ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>
