<?php $this->load->view('absen_siswa/header'); ?>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
<div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
    <div class="text-center mb-4">
      <h2 style="font-family: 'Poppins', sans-serif;" class="fw-bold text-primary"><i class="bi bi-person-vcard"></i> Download Kartu</h2>
    </div>
    <?php echo $this->session->flashdata('notifikasi'); ?>
    <form action="<?php echo base_url('absen_siswa/download'); ?>" method="post">
      <div class="mb-3">
        <label for="nisn" class="form-label">NISN</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-key"></i></span>
          <input type="text" class="form-control" name="nisn" id="nisn" placeholder="Masukkan NISN">
        </div>
      </div>
      <div class="mb-3">
        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-calendar"></i></span>
          <input type="number" class="form-control" name="tgl_lahir" id="tgl_lahir" placeholder="Masukkan Tanggal Lahir (ddmmyyyy)">
        </div>
        <span style="font-size: 14px; font-style: italic; color: #6c757d;" class="form-text text-muted">dd:tanggal, mm:bulan, yyyy:tahun</span>
      </div>
      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary"><i class="bi bi-download"></i> Download</button>
        <button type="button" class="btn btn-secondary mt-1" data-bs-toggle="modal" data-bs-target="#gantiFotoModal"><i class="bi bi-image"></i> Ganti Foto</button>
      </div>
    </form>
  </div>
<?php $this->load->view('absen_siswa/footer'); ?>
<!-- Modal -->
<div class="modal fade" id="gantiFotoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo base_url('absen_siswa/ganti_foto'); ?>" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Ganti Foto</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-1">
            <label for="nisn" class="form-label">NISN</label>
            <input type="number" class="form-control" name="nisn" id="nisn" placeholder="Masukkan NISN" required>
          </div>
          <div class="form-group mb-1">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" class="form-control" name="foto" id="foto" accept="image/*" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="bi bi-arrow-right"></i> Kirim</button>
        </div>
      </form>
    </div>
  </div>
</div>
