<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Poe Ibu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/img/logo_sman1sukra.png'); ?>">
  </head>
  <body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <style>
                    .gambar {
                        display: block;
                        margin: auto;
                    }
                </style>
                <a href="<?php echo base_url('poe_ibu'); ?>">
                    <img src="<?php echo base_url('assets/img/poe_ibu.png'); ?>" alt="Poe Ibu Logo" class="gambar mt-3" width="50%">
                </a>
                <h1 class="text-center">SMA NEGERI 1 SUKRA</h1>
                <div class="row mt-5">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        <?php echo $this->session->flashdata('notification'); ?>
                        <form action="<?php echo base_url('poe_ibu/auth_login'); ?>" method="post">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-fill-lock"></i></span>
                                <input type="text" class="form-control" name="username" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-key-fill"></i></span>
                                <input type="password" class="form-control" name="password" id="myInput" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1" onclick="myFunction()">Show Password</label>
                                <script>
                                    function myFunction() {
                                        var x = document.getElementById("myInput");
                                        if (x.type === "password") {
                                            x.type = "text";
                                        } else {
                                            x.type = "password";
                                        }
                                    }
                                </script>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-primary me-md-2" type="submit"><i class="bi bi-box-arrow-in-right"></i> Login</button>
                            </div>
                        </form>
                        Untuk melihat rekapitulasi data <i>Poe Ibu</i> klik <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#laporan_index">Buat Laporan Poe Ibu</a>!.
                        <!-- Modal Harian -->          
                        <div class="modal fade" id="laporan_index" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Laporan Poe Ibu</h1>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?php echo base_url('poe_ibu/laporan_poe_ibu_public'); ?>" method="post">
                                            <div class="form-group">
                                                <label for="nama">Nama</label>
                                                <input type="text" class="form-control mb-2" id="nama" name="nama" placeholder="Masukkan Nama Anda" required>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="nik">NIK</label>
                                                        <input type="text" class="form-control mb-2" id="nik" name="nik" placeholder="Nomor Induk Kependudukan" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="no_wa">Nomor Whatsapp</label>
                                                        <input type="text" class="form-control mb-2" id="no_wa" name="no_wa" placeholder="Nomor Whatsapp" required>
                                                    </div>
                                                </div>
                                                <label for="alamat">Alamat</label>
                                                <input type="text" class="form-control mb-2" id="alamat" name="alamat" placeholder="Alamat" required>
                                                <label for="jenis_laporan">Pilih Laporan</label>
                                                <select class="form-control mb-2" id="jenis_laporan" name="jenis_laporan" required>
                                                    <option value="" disabled selected>-- Pilih Laporan --</option>
                                                    <option value="harian">Laporan Harian Poe Ibu</option>
                                                    <option value="mingguan">Laporan Mingguan Poe Ibu</option>
                                                    <option value="bulanan">Laporan Bulanan Poe Ibu</option>
                                                    <option value="total">Laporan Total Poe Ibu</option>
                                                </select>
                                                <label for="alasan">Alasan Membuat Laporan</label>
                                                <textarea class="form-control" name="alasan" id="alasan"></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Buat Laporan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="col-sm-3"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>