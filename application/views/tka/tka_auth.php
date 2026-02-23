<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sertifikat TKA 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
          <p class="text-center mt-5 text-success" style="font-size: 8rem;">
            <i class="bi bi-file-medical-fill"></i>
          </p>
          <h6 class="text-center mb-4">
            SERTIFIKAT TES KEMAMPUAN AKADEMIK (TKA) <br>
            SMA NEGERI 1 SUKRA <br>
            TAHUN 2025
          </h6>
          <label for="kelas">Kelas</label>
          <select id="kelas" class="form-select">
            <option value="" disabled selected>Pilih Kelas</option>
            <?php foreach ($kelas as $k) { ?>
              <option value="<?php echo $k['kelas']; ?>" <?php echo (isset($kelas_selected) && $kelas_selected == $k['kelas']) ? 'selected' : ''; ?>>
                <?php echo $k['kelas']; ?>
              </option>
            <?php } ?>
          </select>
          <?php
          if (isset($kelas_selected)) {
              echo '<label for="siswa" class="mt-4">Siswa</label>';
              echo '<select id="siswa" class="form-select">';
              echo '<option value="" disabled selected>Pilih Siswa</option>';
              foreach ($siswa as $s) {
                  $selected = (isset($siswa_selected) && $siswa_selected == $s['nama']) ? 'selected' : '';
                  echo '<option value="'.$s['nama'].'" '.$selected.'>'.$s['nama'].'</option>';
              }
              echo '</select>';
          }
            ?>
          <?php if (isset($siswa_selected)) {
              echo '<label for="nisn" class="mt-4">NISN</label>';
              echo '<input type="password" id="nisn" class="form-control" required>';
          } ?>
          <script>
            document.getElementById('kelas').addEventListener('change', function() {
              var selectedKelas = this.value;
              if (selectedKelas) {
                window.location.href = "<?php echo base_url('tka?kelas='); ?>" + selectedKelas;
              }
            });
            document.getElementById('siswa')?.addEventListener('change', function() {
              var selectedSiswa = this.value;
              var selectedKelas = document.getElementById('kelas').value;
              if (selectedSiswa) {
                window.location.href = "<?php echo base_url('tka?kelas='); ?>" + selectedKelas + "&siswa=" + selectedSiswa;
              }
            });
            //Jika Kelas sudah dipilih dan siswa sudah dipilih, kemudian munculkan tombol Download download jika NISN diisi dengan benar, jika salah tombol Download remove, buat secara keyup
            document.getElementById('nisn')?.addEventListener('keyup', function()
            {
              var nisnInput = this.value;
              var selectedKelas = document.getElementById('kelas').value;
              var selectedSiswa = document.getElementById('siswa').value;
              //Cek NISN sesuai dengan database
              var validNisn = false;
              <?php
              if (isset($siswa_selected)) {
                  $siswa_data = $this->db->get_where('tbl_data_siswa_poe_ibu', ['nama' => $siswa_selected])->row_array();
                  if ($siswa_data) {
                      echo 'var correctNisn = "'.$siswa_data['nisn'].'";';
                  } else {
                      echo 'var correctNisn = "";';
                  }
              } else {
                  echo 'var correctNisn = "";';
              }
            ?>
              if (nisnInput === correctNisn) {
                validNisn = true;
              }
              //Jika validNisn true, munculkan tombol download
              var existingButton = document.getElementById('downloadBtn');
              if (validNisn) {
                if (!existingButton) {
                  var downloadBtn = document.createElement('a');
                  downloadBtn.id = 'downloadBtn';
                  downloadBtn.className = 'btn btn-primary w-100 mt-4';
                  downloadBtn.href = "<?php echo base_url('tka?kelas='); ?>" + selectedKelas + "&siswa=" + selectedSiswa + "&nisn=" + nisnInput + "&download=true";
                  downloadBtn.innerText = 'Download Sertifikat';
                  document.getElementById('nisn').after(downloadBtn);
                }
                //kembalikan form ke awal setelah tombol diklik dan file di download
                downloadBtn.addEventListener('click', function() {
                  setTimeout(function() {
                    window.location.href = "<?php echo base_url('tka'); ?>";
                  }, 1000);
                });
              } else {
                if (existingButton) {
                  existingButton.remove();
                }
              }
            });
          </script>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>