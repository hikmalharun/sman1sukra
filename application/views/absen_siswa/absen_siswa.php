<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Absensi QR Code</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-12">

      <!-- Card untuk scanner -->
      <div class="card shadow">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Scan QR Code Siswa</h5>
        </div>
        <div class="card-body text-center">
          <div id="reader" style="width:900px; margin:auto;"></div>
          <div id="result" class="mt-3"></div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
function onScanSuccess(decodedText, decodedResult) {
    fetch("<?php echo base_url('absen_siswa/simpan'); ?>", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id_siswa: decodedText })
    }).then(res => res.json())
      .then(data => {
          document.getElementById("result").innerHTML =
              `<div class="alert alert-success">${data.message}</div>`;
      }).catch(err => {
          document.getElementById("result").innerHTML =
              `<div class="alert alert-danger">Terjadi kesalahan!</div>`;
      });
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", { fps: 20, qrbox: 450 });
html5QrcodeScanner.render(onScanSuccess);
</script>

</body>
</html>