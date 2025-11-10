<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Input Harian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/img/logo_sman1sukra.png'); ?>">
  </head>
  <body>
    <div class="container">
      <nav class="navbar bg-primary mb-3">
        <div class="container-fluid">
          <a class="navbar-brand text-white">
            <h3>Input Poe Ibu</h3>
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
            <?php if ($this->session->userdata('kelas') == 'SMA NEGERI 1 SUKRA') { ?>
                <td>Sekolah</td>
                <td>:</td>
                <td><?php echo $this->session->userdata('kelas'); ?></td>
              <?php } else { ?>
                <td>Kelas</td>
                <td>:</td>
                <td><?php echo $this->session->userdata('kelas'); ?></td>
              <?php } ?>
          </tr>
          <tr>
            <td>Bulan</td>
            <td>:</td>
            <td><?php echo date('F Y', strtotime($bulan)); ?></td>
          </tr>
          <tr>
            <td>Jumlah Total</td>
            <td>:</td>
            <td><strong>Rp <?php
    $this->db->select_sum('nominal');
    $this->db->where('kelas', $kelas);
    $this->db->where('tanggal_laporan LIKE', $bulan.'%');
    $total = $this->db->get('tbl_data_poe_ibu')->row_array();
    echo number_format((float) ($total['nominal'] ?? 0));
    ?>
            </strong></td>
          </tr>
        </table>
      </div>
      <?php if ($nipd) { ?>
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
              Update Data Poe Ibu untuk:
              <table>
                <tr>
                  <td width="40%">Nama</td>
                  <td width="1%">:</td>
                  <td><?php echo $update_poe_ibu['nama']; ?></td>
                </tr>
                <tr>
                  <td>NIPD</td>
                  <td>:</td>
                  <td><?php echo $update_poe_ibu['nipd']; ?></td>
                </tr>
                <tr>
                  <td>Kelas</td>
                  <td>:</td>
                  <td><?php echo $update_poe_ibu['kelas']; ?></td>
                </tr>
              </table>
              <form action="<?php echo base_url('poe_ibu/update_poe_ibu'); ?>" method="post" class="mb-3">
                <input type="hidden" name="id" value="<?php echo $update_poe_ibu['id']; ?>">
                <input type="hidden" name="nipd" value="<?php echo $update_poe_ibu['nipd']; ?>">
                <input type="hidden" name="nama" value="<?php echo $update_poe_ibu['nama']; ?>">
                <input type="hidden" name="kelas" value="<?php echo $update_poe_ibu['kelas']; ?>">
                <div class="mt-3 mb-3">
                  <label for="tanggal_laporan">Tanggal Laporan</label>
                  <input type="date" class="form-control" name="tanggal_laporan" id="tanggal_laporan" value="<?php echo $update_poe_ibu['tanggal_laporan']; ?>">
                </div>
                <div class="mb-3">
                  <label for="nominal" class="form-label">Nominal Poe Ibu (Rp)</label>
                  <input type="number" class="form-control" name="nominal" id="nominal" value="<?php echo $update_poe_ibu['nominal']; ?>" required>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                  <a href="<?php echo base_url('poe_ibu/input_harian?kelas='.$update_poe_ibu['kelas'].'&bulan='.substr($update_poe_ibu['tanggal_laporan'], 0, 7)); ?>" class="btn btn-danger btn-sm"><i class="bi bi-x"></i> Batalkan</a>
                  <button class="btn btn-primary btn-sm" type="submit"><i class="bi bi-save"></i> Simpan</button>
                </div>
              </form>
            </div>
            <div class="col-md-3"></div>
          </div>
      <?php } else { ?>
        <div class="d-grid gap-2 d-md-flex justify-content-md-between mb-2">
          <h4>Data Siswa</h4>
            <div class="justify-content-md-end">
            <button class="btn btn-outline-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#input"><i class="bi bi-input-cursor"></i> Input</button>
            <button class="btn btn-outline-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#cetak"><i class="bi bi-printer"></i> Cetak</button>
            <button class="btn btn-outline-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#bulanan"><i class="bi bi-calendar2-week"></i> Bulan</button>
            <!-- Modal Input -->          
            <div class="modal fade" id="cetak" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Cetak Laporan Poe Ibu</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="<?php echo base_url('poe_ibu/cetak_laporan_poe_ibu'); ?>" method="post" target="_blank">
                      <label for="bulan">Pilih Bulan</label>
                      <input type="month" name="bulan" class="form-control mb-2" id="bulan" required>
                      <label for="jenis">Jenis</label>
                      <select type="month" name="jenis" class="form-control mb-2" id="jenis" required>
                        <option value="" disabled selected>-- Pilih Jenis --</option>
                        <option value="pdf">PDF</option>
                        <option value="excel">Excel</option>
                      </select>
                      <input type="hidden" name="kelas" value="<?php echo $this->session->userdata('kelas'); ?>">
                      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-success btn-sm" type="submit">Cetak Laporan</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal Input -->          
            <div class="modal fade" id="input" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Input Poe Ibu</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="<?php echo base_url('poe_ibu/simpan_poe_ibu'); ?>" method="post">
                      <label for="bulan">Pilih Nama</label>
                      <select class="form-control mb-2" id="nipd" name="nipd" required>
                        <option value="" disabled selected>-- Pilih Nama --</option>
                        <?php foreach ($siswa as $s) { ?>
                            <option value="<?php echo $s['nipd']; ?>"><?php echo $s['nama']; ?> - <?php echo $s['nipd']; ?></option>
                        <?php } ?>
                      </select>
                      <label for="tanggal_laporan">Tanggal</label>
                      <input type="date" name="tanggal_laporan" class="form-control mb-3" id="tanggal_laporan" required>
                      <label for="nominal">Nominal</label>
                      <input type="number" name="nominal" class="form-control mb-3" id="nominal" placeholder="1.000" required>
                      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-success btn-sm" type="submit"><i class="bi bi-save"></i> Simpan</button>
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
                    <form action="<?php echo base_url('poe_ibu/input_harian'); ?>" method="get">
                      <label for="bulan">Pilih Bulan</label>
                      <input type="month" name="bulan" class="form-control mb-2" id="bulan" required>
                      <input type="hidden" name="kelas" value="<?php echo $this->session->userdata('kelas'); ?>">
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
        <?php echo $this->session->flashdata('notification'); ?>
        <div class="table-responsive">
          <table class="table table-bordered" style="font-size: 10px;">
            <thead class="text-center">
              <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">NIPD</th>
                <th rowspan="2">Nama</th>
                <th colspan="31">Tanggal (<?php echo date('F', strtotime($bulan)); ?> 2025)</th>
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
                    <a href="<?php echo base_url('poe_ibu/input_harian?nipd='.$poe_ibu['nipd'].'&kelas='.$poe_ibu['kelas'].'&bulan='.$poe_ibu['tanggal_laporan'].'&tanggal='.$tanggal); ?>" class="text-white text-decoration-none">
                      <?php echo number_format($poe_ibu['nominal'], 0, ',', '.'); ?>
                    </a>
                  </td>
              <?php } else { ?>
                  <td class="bg-danger text-center">0</td>
              <?php } ?>
          <?php } ?>
                </tr>
              <?php } ?>
              <tr>
                <td colspan="3" class="text-center"><strong>Total</strong></td>
                <?php for ($k = 1; $k <= $bln['jumlah_hari']; ++$k) {
                    $tanggal_total = date('Y-m-', strtotime($bulan)).sprintf('%02d', $k);
                    $total_harian = $this->db->select_sum('nominal')->get_where('tbl_data_poe_ibu', [
                        'tanggal_laporan' => $tanggal_total,
                        'kelas' => $this->session->userdata('kelas'),
                    ])->row_array();
                    if ($total_harian['nominal'] != null) {
                        echo '<td class="bg-info text-white text-center"><strong>'.number_format($total_harian['nominal'], 0, ',', '.').'</strong></td>';
                    } else {
                        echo '<td class="text-center">0</td>';
                    }
                } ?>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <?php } ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>