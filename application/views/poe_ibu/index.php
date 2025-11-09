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
                                <button class="btn btn-primary me-md-2" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-3"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>