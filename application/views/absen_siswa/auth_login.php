<?php $this->load->view('absen_siswa/header'); ?>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
<div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
    <div class="text-center mb-4">
      <a href="<?php echo base_url('absen_siswa'); ?>">
        <img src="<?php echo base_url('assets/img/logo_sman1sukra.png'); ?>" alt="logo" style="width: 100px;">
      </a>
      <h4 class="mt-2">Login</h4>
    </div>
    <?php echo $this->session->flashdata('notifikasi'); ?>
    <form action="<?php echo base_url('absen_siswa/login'); ?>" method="post">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-key"></i></span>
          <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan Username">
        </div>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock"></i></span>
          <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password">
        </div>
      </div>
      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary"><i class="bi bi-box-arrow-right"></i> Login</button>
      </div>
    </form>
  </div>
<?php $this->load->view('absen_siswa/footer'); ?>
