<?php $this->load->view('absen_siswa/header'); ?>
<body>
  <div class="container-fluid mt-1">
    <div class="row">
    <div class="col-lg-12">
      <p id="clock" class="text-white text-center fw-bold fs-5" style="padding: 10px; background-color: black;"></p>
    </div>
    <div class="col-lg-12">
      <?php echo $this->session->flashdata('notifikasi'); ?>
    </div>
    <style>
      .blink {
        font-size: 20px;
        font-weight: bold;
        width: 100%;
        color: #ff0000;
        animation: blink-animation 1s steps(2, start) infinite;
      }

      @keyframes blink-animation {
        to {
          visibility: hidden;
        }
      }
    </style>
    <div class="col-md-4 mb-3">
    <?php if ($absen['modal'] == 'show_input') { ?>
      <div class="card shadow">
        <div class="card-header bg-success text-white">
          <h5 class="mb-0">Absensi Siswa dengan QR Code <?php echo ucwords($absen['sesi']); ?></h5>
        </div>
        <div class="card-body text-center">
          <p class="lead">Arahkan kamera ke QR Code siswa untuk melakukan absensi.</p>
          <div id="reader" style="width:100%; margin:auto;"></div>
          <div class="mt-3">
            <button id="startBtn" class="btn btn-success"><i class="bi bi-camera-video"></i> Mulai Scanner</button>
            <button id="stopBtn" class="btn btn-danger" disabled><i class="bi bi-camera-video-off"></i> Hentikan Scanner</button>
            <button id="switchBtn" class="btn btn-primary"><i class="bi bi-phone-flip"></i> Ganti Kamera</button>
          </div>
          <div id="result" class="mt-3"></div>
          <div class="card" style="max-width: 100%; max-height: 100%; border: none;">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="<?php echo base_url('assets/img/foto_siswa/'.$detail_petugas['nisn'].'.jpg'); ?>" class="img-thumbnail rounded" style="max-width: 90%; max-height: 90%; border-radius: 10px;" alt="foto_siswa">
              </div>
              <div class="col-md-8">
                <div class="card-body" style="text-align:left;">
                  <table class="table table-striped">
                    <tr>
                      <td>Nama</td><td>:</td><td><h5 class="card-title"><?php echo $detail_petugas['nama']; ?></h5></td>
                    </tr>
                    <tr>
                      <td>NISN</td><td>:</td><td><?php echo $detail_petugas['nisn']; ?></td>
                    </tr>
                    <tr>
                      <td>Kelas</td><td>:</td><td><?php echo $detail_petugas['kelas']; ?></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } else { ?>
      <div class="d-grid gap-2 text-center">
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalToken"><i class="bi bi-input-cursor"></i> Isi Token</button>
        <span class="blink"><i>Tanyakan kepada admin untuk <br> mendapatkan token hari ini!</i></span>
      </div>
    <?php } ?>
    </div>
    <div class="col-md-8 mb-3">
      <div class="card shadow">
        <div class="card-header bg-info text-white">
          <h5 class="mb-0">Hasil Absensi</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <?php if ($absen['modal'] == 'show_input') { ?>
              <button class="btn btn-outline-info float-end mb-3" data-bs-toggle="modal" data-bs-target="#modalNISN"><i class="bi bi-input-cursor"></i> Masukan NISN</button>
              <?php } else { ?>
              <button class="btn btn-outline-info float-end mb-3"><i class="bi bi-input-cursor"></i> Masukan NISN</button>
              <?php } ?>
              <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#staticRekap"><i class="bi bi-arrow-down-up"></i> Rekapitulasi</button>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-striped table-borderless" id="tabelAbsensi">
                  <thead>
                    <tr>
                      <th>ID Siswa</th>
                      <th>Nama Siswa</th>
                      <th>Kelas</th>
                      <th>Tanggal Absen</th>
                      <th>Jam Absen</th>
                      <th>Sesi</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyAbsensi"></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('absen_siswa/footer'); ?>
<!-- Modal -->
<div class="modal fade" id="modalToken" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo base_url('absen_siswa/index'); ?>" method="get">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Token</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-2">
            <input type="number" class="form-control" name="nisn" id="nisn" placeholder="Masukan NISN Disini" require>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="token" id="token" placeholder="Masukan Token Disini" require>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="bi bi-arrow-right"></i> Kirim</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalNISN" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo base_url('absen_siswa/by_nisn'); ?>" method="post">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Absen Dengan NISN</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" name="nisn" id="nisn" placeholder="Masukan NISN Disini" require>
            <input type="hidden" class="form-control" name="token" id="token" value="<?php echo $absen['token']; ?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="bi bi-arrow-right"></i> Kirim</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticRekap" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Rekapitulasi</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-resposive">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Kelas</th>
                <th>Kelas</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>