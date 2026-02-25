    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function() {
          $('.table1').DataTable();
          $('.table2').DataTable();
          $('.table3').DataTable();
      });

      let html5QrcodeScanner;
      let currentFacingMode = "environment"; // default kamera belakang

      function startScanner() {
        html5QrcodeScanner = new Html5Qrcode("reader");
        html5QrcodeScanner
          .start(
            { facingMode: currentFacingMode },
            { fps: 20, qrbox: 270 },
            onScanSuccess,
          )
          .then(() => {
            document.getElementById("startBtn").disabled = true;
            document.getElementById("stopBtn").disabled = false;
          })
          .catch((err) => {
            document.getElementById("result").innerHTML =
              `<div class="alert alert-danger">Tidak dapat mengakses kamera: ${err}</div>`;
          });
      }

      function stopScanner() {
        if (html5QrcodeScanner) {
          html5QrcodeScanner
            .stop()
            .then(() => {
              document.getElementById("startBtn").disabled = false;
              document.getElementById("stopBtn").disabled = true;
            })
            .catch((err) => {
              document.getElementById("result").innerHTML =
                `<div class="alert alert-danger">Gagal menghentikan scanner: ${err}</div>`;
            });
        }
      }

      function switchCamera() {
        currentFacingMode =
          currentFacingMode === "environment" ? "user" : "environment";
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
          body: JSON.stringify({ id_siswa: decodedText }),
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.status === "success") {
              document.getElementById("result").innerHTML =
                `<div class="alert alert-success">${data.message}</div>`;
              loadAbsensi(); // refresh tabel dari database
            } else {
              document.getElementById("result").innerHTML =
                `<div class="alert alert-warning">${data.message}</div>`;
            }
          })
          .catch((err) => {
            document.getElementById("result").innerHTML =
              `<div class="alert alert-danger">Terjadi kesalahan!</div>`;
          });
      }

      // Fungsi untuk load data absensi dari database
      function loadAbsensi() {
        fetch("<?php echo base_url('absen_siswa/get_absensi_json'); ?>")
          .then((res) => res.json())
          .then((data) => {
            let tbody = document.getElementById("tbodyAbsensi");
            tbody.innerHTML = "";
            data.forEach((row) => {
              let newRow = `<tr>
                                    <td>${row.id_siswa}</td>
                                    <td>${row.nama_siswa}</td>
                                    <td>${row.kelas}</td>
                                    <td>${row.tanggal_absen}</td>
                                    <td>${row.jam_absen}</td>
                                  </tr>`;
              tbody.insertAdjacentHTML("beforeend", newRow);
            });
          });
      }

      // Load absensi saat halaman pertama kali dibuka
      loadAbsensi();

      function updateClock() {
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

        document.getElementById("clock").textContent = tanggal + " " + jam;
      }

      // Update setiap 1 detik
      setInterval(updateClock, 1000);

      // Panggil pertama kali agar langsung tampil
      updateClock();

      // Ambil elemen
    const blinkText = document.getElementById("blinkText");
    </script>
  </body>
</html>