<?php $this->load->view('absen_siswa/header'); ?>
<body>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 mb-3 mt-3">
      <nav class="navbar bg-black">
        <div class="container-fluid">
          <a class="navbar-brand text-white"><i class="bi bi-person-circle"></i> <?php echo $this->session->userdata('nama'); ?></a>
          <div class="d-flex">
            <a href="<?php echo base_url('absen_siswa/logout'); ?>" class="btn btn-outline-light" type="submit"><i class="bi bi-box-arrow-left"></i> Logout</a>
          </div>
        </div>
      </nav>
      <?php echo $this->session->flashdata('notifikasi'); ?>
    </div>
    <div class="col-md-12 mb-3">
      <div class="card shadow" style="background-color: black;">
        <div class="card-body text-white text-center fw-bold fs-5">
          <div id="clocks"></div>
        </div>
      </div>
    </div>
    <div class="col-md-12 mb-3">
      <div class="card shadow">
        <div class="card-body">
          <h5 class="card-title fw-bold"><button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#generateToken"><i class="bi bi-arrow-clockwise"></i> Generate Token</button></h5>
          <table class="table table-striped" style="width: 100%;">
            <thead>
              <tr>
                <th class="text-center">Sesi</th>
                <th class="text-center">Token</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($token as $t) { ?>
                <tr>
                  <td class="text-center"><?php echo ucwords($t['sesi']); ?></td>
                  <td class="text-center" id="tokenText<?php echo ($t['sesi'] == 'sesi1') ? '1' : '2'; ?>" style="cursor: pointer;">
                    <button class="btn <?php echo ($t['sesi'] == 'sesi1') ? 'btn-success' : 'btn-warning'; ?>" style="width:100%;"><h3><i class="bi bi-copy"></i> <?php echo $t['token']; ?></h3></button>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <p class="text-sm"><i>Klik token untuk copy</i></p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow">
        <div class="card-header bg-info text-white">
          <h5 class="mb-0">Hasil Absensi</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <a href="<?php echo base_url('absen_siswa/buat_kartu_identitas'); ?>" class="btn btn-outline-secondary" target="_blank"><i class="bi bi-person-badge"></i> Cetak Kartu Siswa</a>
            <!-- <div class="dropdown-center">
              <button class="btn btn-secondary dropdown-toggle mb-3 float-end" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-printer"></i> Print Laporan
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?php echo base_Url('absen_siswa/admin?report_by=tanggal'); ?>">Tanggal</a></li>
                <li><a class="dropdown-item" href="<?php echo base_Url('absen_siswa/admin?report_by=bulan'); ?>">Bulan</a></li>
              </ul>
            </div> -->
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-borderless table-hover table2" id="tabelAbsensiadmin">
              <thead>
                <tr>
                  <th class="text-center">ID Siswa</th>
                  <th>Nama Siswa</th>
                  <th class="text-center">Kelas</th>
                  <th class="text-center">Tanggal Absen</th>
                  <th class="text-center">Jam Absen</th>
                  <th class="text-center">Sesi</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody id="tbodyAbsensiadmin"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="generateToken" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?php echo base_url('absen_siswa/simpan_token'); ?>" method="post">
      <div class="modal-body">
        Apakah anda yakin ingin generate token absensi hari ini? Token yang sudah digenerate tidak bisa diubah kembali.
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-outline-primary"><i class="bi bi-arrow-clockwise"></i> Generate</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="reportBy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formExportPDF" action="<?php echo base_url('absen_siswa/print_report'); ?>" method="post" target="_blank">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">
            <?php if ($report_by == 'tanggal') { ?>
              Print Laporan By Tanggal
            <?php } elseif ($report_by == 'bulan') { ?>
              Print Laporan By Bulan
            <?php } ?>
          </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <?php if ($report_by == 'tanggal') { ?>
              <label for="tanggal">Pilih Tanggal</label>
              <input type="hidden" name="kode" value="<?php echo $report_by; ?>">
              <input type="date" name="tanggal" id="tanggal" class="form-control" required>
            <?php } elseif ($report_by == 'bulan') { ?>
              <label for="bulan">Pilih Bulan</label>
              <input type="hidden" name="kode" value="<?php echo $report_by; ?>">
              <input type="month" name="bulan" id="bulan" class="form-control" required>
            <?php } ?>
          </div>
          <div class="form-group">
            <label for="kelas">Pilih Kelas</label>
            <select name="kelas" id="kelas" class="form-select" required>
              <option value="">Pilih Kelas</option>
              <?php foreach ($kelas as $k) { ?>
              <option value="<?php echo $k['kelas']; ?>"><?php echo $k['kelas']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="bi bi-arrow-right"></i> Kirim</button>
        </form>
        <script>
        document.getElementById('formExportPDF').addEventListener('submit', function() {
          setTimeout(function() {
            window.location.href = '<?php echo base_url('absen_siswa/admin'); ?>';
          }, 1500);
        });
        </script>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  function generateToken(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let token = '';
    for (let i = 0; i < length; i++) {
      const randomIndex = Math.floor(Math.random() * characters.length);
      token += characters[randomIndex];
    }
    return token;
  }
  // fungsi simpan token
  function simpanToken(sesi) {
    const token = generateToken(6);
    fetch('<?php echo base_url('absen_siswa/simpan_token'); ?>', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ sesi: sesi, token: token })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert(data.message);
        location.reload();
      } else {
        alert(data.message);
      }
    });
  }
  document.getElementById('tombol_generate1').addEventListener('click', function() {
    simpanToken('sesi1');
  });
  document.getElementById('tombol_generate2').addEventListener('click', function() {
    simpanToken('sesi2');
  });
</script>

<script>
  // fungsi copy token ketika diklik
  document.getElementById('tokenText1').addEventListener('click', function() {
    const token = this.innerText.trim();
    if (token && token !== '-') {
      // buat elemen input sementara
      const tempInput = document.createElement('input');
      tempInput.value = "Silahkan klik link berikut : sman1sukra.sch.id/absen_siswa untuk melakukan scan QR Code, dengan token untuk sesi1 adalah : *_" + token + "_*";
      document.body.appendChild(tempInput);
      tempInput.select();
      document.execCommand('copy');
      document.body.removeChild(tempInput);

      alert("Token berhasil dicopy: " + token);
    }
  });
  document.getElementById('tokenText2').addEventListener('click', function() {
    const token = this.innerText.trim();
    if (token && token !== '-') {
      // buat elemen input sementara
      const tempInput = document.createElement('input');
      tempInput.value = "Silahkan klik link berikut : sman1sukra.sch.id/absen_siswa untuk melakukan scan QR Code, dengan token untuk sesi2 adalah : *_" + token + "_*";
      document.body.appendChild(tempInput);
      tempInput.select();
      document.execCommand('copy');
      document.body.removeChild(tempInput);

      alert("Token berhasil dicopy: " + token);
    }
  });
  </script>
  <script>
  function updateClocks() {
    const now = new Date();

    // Format tanggal: YYYY-MM-DD
    const tanggal =
      String(now.getDate()).padStart(2, "0") +
      "-" +
      String(now.getMonth() + 1).padStart(2, "0") +
      "-" +
      now.getFullYear();

    // Format jam: HH:MM:SS
    const jam =
      String(now.getHours()).padStart(2, "0") +
      ":" +
      String(now.getMinutes()).padStart(2, "0") +
      ":" +
      String(now.getSeconds()).padStart(2, "0");

    document.getElementById("clocks").textContent = tanggal + " " + jam;
  }

  // Update setiap 1 detik
  setInterval(updateClocks, 1000);

  // Panggil pertama kali agar langsung tampil
  updateClocks();

  // Fungsi untuk load data absensi dari database
  function loadAbsensiadmin() {
    fetch("<?php echo base_url('absen_siswa/get_absensi_json_admin'); ?>")
      .then((res) => res.json())
      .then((data) => {
        let tbody = document.getElementById("tbodyAbsensiadmin");
        tbody.innerHTML = "";
        data.forEach((row) => {
          let newRow = `<tr>
                          <td class="text-center">${row.id_siswa}</td>
                          <td>${row.nama_siswa}</td>
                          <td class="text-center">${row.kelas}</td>
                          <td class="text-center">${row.tanggal_absen}</td>
                          <td class="text-center">${row.jam_absen}</td>
                          <td class="text-center">${row.sesi}</td>
                          <td class="text-center">
                            <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailModal${row.id_siswa}"><i class="bi bi-eye"></i> Detail</button>
                            <!-- Modal -->
                            <div class="modal fade" id="detailModal${row.id_siswa}" tabindex="-1" aria-labelledby="detailModalLabel${row.id_siswa}" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="detailModalLabel${row.id_siswa}">Detail Absensi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <img src="<?php echo base_url('assets/img/foto_siswa/'); ?>${row.id_siswa}.jpg" class="img-fluid mb-3" style="max-width: 40%; height: auto;">
                                    <div style="text-align: left;">
                                      <table class="table">
                                        <tr>
                                          <th>ID Siswa</th>
                                          <td>${row.id_siswa}</td>
                                        </tr>
                                        <tr>
                                          <th>Nama Siswa</th>
                                          <td>${row.nama_siswa}</td>
                                        </tr>
                                        <tr>
                                          <th>Kelas</th>
                                          <td>${row.kelas}</td>
                                        </tr>
                                        <tr>
                                          <th>Tanggal Absen</th>
                                          <td>${row.tanggal_absen}</td>
                                        </tr>
                                        <tr>
                                          <th>Jam Absen</th>
                                          <td>${row.jam_absen}</td>
                                        </tr>
                                        <tr>
                                          <th>Sesi</th>
                                          <td>${row.sesi}</td>
                                        </tr>
                                      </table>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                        </tr>`;
          tbody.insertAdjacentHTML("beforeend", newRow);
        });
      });
  }
  // Load absensi saat halaman pertama kali dibuka
  loadAbsensiadmin();

  <?php if ($report_by) { ?>
    document.addEventListener("DOMContentLoaded", function() {
      var myModal = new bootstrap.Modal(document.getElementById('reportBy'));
      myModal.show();
    });
  <?php } ?>
</script>
<?php $this->load->view('absen_siswa/footer'); ?>
