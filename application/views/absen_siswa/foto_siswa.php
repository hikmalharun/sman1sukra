<?php $this->load->view('absen_siswa/header'); ?>
<body>
<div class="container">
  <h2>Foto Siswa</h2>
  <div class="row">
    <?php foreach ($siswa as $s) {?>
      <?php if ($s['foto'] != '') { ?>
        <div class="col-md-3 mb-3">
          <img src="<?php echo base_url('assets/img/foto_siswa/'.$s['foto']); ?>" id="image" alt="foto_siswa" style="max-width: 100%;">
        </div>
      <?php } ?>
    <?php } ?>
  </div>
</div>
<?php $this->load->view('absen_siswa/footer'); ?>
