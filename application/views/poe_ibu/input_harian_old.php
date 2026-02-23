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
              <button class="btn btn-outline-light btn-sm" type="button">Logout</button>
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
        </table>
      </div>
      <div class="d-grid gap-2 d-md-flex justify-content-md-between mb-2">
        <h4>Data Siswa</h4>
        <div class="justify-content-md-end">
          <div class="dropdown">
            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Lihat Laporan
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#harian">Harian</a></li>
              <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#bulanan">Bulanan</a></li>
            </ul>
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
                  <form action="<?php echo base_url('poe_ibu/laporan_poe_ibu_harian'); ?>" method="get" target="_blank">
                    <label for="bulan">Pilih Tanggal</label>
                    <input type="date" name="tanggal" class="form-control mb-2" id="tanggal" required>
                    <input type="hidden" name="kelas" value="<?php echo $this->session->userdata('kelas'); ?>">
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
                  <form action="<?php echo base_url('poe_ibu/laporan_poe_ibu_bulanan'); ?>" method="get" target="_blank">
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
      <table class="table table-bordered" style="font-size: 14px;">
        <tr class="text-center">
          <th>No</th>
          <th>NIPD</th>
          <th>Nama Siswa</th>
          <th>Input Poe Ibu</th>
        </tr>
        <?php
      $no = 1;
    foreach ($siswa as $s) { ?>
        <tr>
          <td class="text-center"><?php echo $no++; ?></td>
          <td class="text-center"><?php echo $s['nipd']; ?></td>
          <td><?php echo $s['nama']; ?></td>
          <td>
            <div class="text-center">
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#<?php echo 'static'.$s['nipd']; ?>">
                <i class="bi bi-code-slash"></i>
              </button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="<?php echo 'static'.$s['nipd']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Input Poe Ibu</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <table class="mb-3" width="100%">
                      <tr>
                        <td>Nama Siswa</td>
                        <td>:</td>
                        <td><?php echo $s['nama']; ?></td>
                      </tr>
                      <tr>
                        <td width="30%">NIPD</td>
                        <td width="5%">:</td>
                        <td><?php echo $s['nipd']; ?></td>
                      </tr>
                      <tr>
                        <td>Kelas</td>
                        <td>:</td>
                        <td><?php echo $s['kelas']; ?></td>
                      </tr>
                    </table>
                    <!-- Tambahkan form input harian di sini -->
                    <form action="<?php echo base_url('poe_ibu/simpan_poe_ibu'); ?>" method="post">
                        <label for="date">Tanggal</label>
                        <input type="date" name="tanggal_laporan" class="form-control mb-2" id="date" required>
                        <label for="nominal">Nominal</label>
                        <input type="number" name="nominal" class="form-control mb-2" id="nominal" placeholder="1.000" required>
                        <input type="hidden" name="nipd" value="<?php echo $s['nipd']; ?>">
                        <input type="hidden" name="nama" value="<?php echo $s['nama']; ?>">
                        <input type="hidden" name="kelas" value="<?php echo $s['kelas']; ?>">
                        <input type="hidden" name="tanggal" value="<?php echo date('Y-m-d'); ?>">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                          <button class="btn btn-outline-success" type="submit">Simpan</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>