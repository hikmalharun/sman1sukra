<?php $this->load->view('absen_siswa/header'); ?>
<body>
<div class="container-fluid">
  <div class="row mt-3">
    <div class="col-lg-4">
      <div class="card shadow">
        <div class="card-header bg-success text-white">
          <h5 class="mb-0">Absensi Siswa dengan QR Code <?php echo ucwords($detail_absen['sesi']); ?></h5>
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
    </div>
    <div class="col-lg-8">
      <div class="card shadow">
        <div class="card-header">
          <h5 class="mb-0">Hasil Absensi</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>NISN</th>
                  <th>Kelas</th>
                  <th>Sesi</th>
                  <th>Jam</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('absen_siswa/footer'); ?>
