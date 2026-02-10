<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Absensi Siswa</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body>
<div class="container-fluid mt-1">
  <div class="row">
    <div class="col-lg-12">
      <p id="clock" class="text-white text-center fw-bold" style="padding: 5px; background-color: black;"></p>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card shadow">
        <div class="card-header bg-success text-white">
          <h5 class="mb-0">Absensi Siswa dengan QR Code</h5>
        </div>
        <div class="card-body text-center">
          <p class="lead">Arahkan kamera ke QR Code siswa untuk melakukan absensi.</p>
          <div id="reader" style="width:100%; margin:auto;"></div>
          <div class="mt-3">
            <button id="startBtn" class="btn btn-success">Mulai Scanner</button>
            <button id="stopBtn" class="btn btn-danger" disabled>Hentikan Scanner</button>
            <button id="switchBtn" class="btn btn-primary">Ganti Kamera</button>
          </div>
          <div id="result" class="mt-3"></div>
        </div>
      </div>
    </div>
    <div class="col-md-8 mb-3">
      <div class="card shadow">
        <div class="card-header bg-info text-white">
          <h5 class="mb-0">Hasil Absensi</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="tabelAbsensi">
              <thead>
                <tr>
                  <th>ID Siswa</th>
                  <th>Nama Siswa</th>
                  <th>Kelas</th>
                  <th>Tanggal Absen</th>
                  <th>Jam Absen</th>
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

<script>
let html5QrcodeScanner;
let currentFacingMode = "environment"; // default kamera belakang

function startScanner() {
    html5QrcodeScanner = new Html5Qrcode("reader");
    html5QrcodeScanner.start(
        { facingMode: currentFacingMode },
        { fps: 20, qrbox: 270 },
        onScanSuccess
    ).then(() => {
        document.getElementById("startBtn").disabled = true;
        document.getElementById("stopBtn").disabled = false;
    }).catch(err => {
        document.getElementById("result").innerHTML =
            `<div class="alert alert-danger">Tidak dapat mengakses kamera: ${err}</div>`;
    });
}

function stopScanner() {
    if (html5QrcodeScanner) {
        html5QrcodeScanner.stop().then(() => {
            document.getElementById("startBtn").disabled = false;
            document.getElementById("stopBtn").disabled = true;
        }).catch(err => {
            document.getElementById("result").innerHTML =
                `<div class="alert alert-danger">Gagal menghentikan scanner: ${err}</div>`;
        });
    }
}

function switchCamera() {
    currentFacingMode = (currentFacingMode === "environment") ? "user" : "environment";
    stopScanner();
    startScanner();
}

document.getElementById("startBtn").addEventListener("click", startScanner);
document.getElementById("stopBtn").addEventListener("click", stopScanner);
document.getElementById("switchBtn").addEventListener("click", switchCamera);

function onScanSuccess(decodedText, decodedResult) {
    fetch("<?php echo base_url('absen_siswa/simpan'); ?>", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id_siswa: decodedText })
    }).then(res => res.json())
      .then(data => {
          if (data.status === 'success') {
              document.getElementById("result").innerHTML =
                  `<div class="alert alert-success">${data.message}</div>`;
              loadAbsensi(); // refresh tabel dari database
          } else {
              document.getElementById("result").innerHTML =
                  `<div class="alert alert-warning">${data.message}</div>`;
          }
      }).catch(err => {
          document.getElementById("result").innerHTML =
              `<div class="alert alert-danger">Terjadi kesalahan!</div>`;
      });
}

// Fungsi untuk load data absensi dari database
function loadAbsensi() {
    fetch("<?php echo base_url('absen_siswa/get_absensi_json'); ?>")
      .then(res => res.json())
      .then(data => {
          let tbody = document.getElementById("tbodyAbsensi");
          tbody.innerHTML = "";
          data.forEach(row => {
              let newRow = `<tr>
                              <td>${row.id_siswa}</td>
                              <td>${row.nama_siswa}</td>
                              <td>${row.kelas}</td>
                              <td>${row.tanggal_absen}</td>
                              <td>${row.jam_absen}</td>
                            </tr>`;
              tbody.insertAdjacentHTML('beforeend', newRow);
          });
      });
}

// Load absensi saat halaman pertama kali dibuka
loadAbsensi();

function updateClock() {
  const now = new Date();

  // Format tanggal: YYYY-MM-DD
  const tanggal = now.getFullYear() + "-" +
                  String(now.getMonth() + 1).padStart(2, '0') + "-" +
                  String(now.getDate()).padStart(2, '0');

  // Format jam: HH:MM:SS
  const jam = String(now.getHours()).padStart(2, '0') + ":" +
              String(now.getMinutes()).padStart(2, '0') + ":" +
              String(now.getSeconds()).padStart(2, '0');

  document.getElementById("clock").textContent = tanggal + " " + jam;
}

// Update setiap 1 detik
setInterval(updateClock, 1000);

// Panggil pertama kali agar langsung tampil
updateClock();

</script>

</body>
</html>