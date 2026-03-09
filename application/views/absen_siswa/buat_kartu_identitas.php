<?php $this->load->view('absen_siswa/header'); ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h2><?php echo $title; ?></h2>
            <hr>

            <?php if (isset($error)) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php } ?>

            <?php if (!empty($siswa)) { ?>
            <div class="table-responsive">
                <style>
                    .dataTables_paginate {
                        margin-top: -10px;       /* jarak atas */
                        margin-bottom: 5px;    /* jarak bawah */
                        margin-right: 20%;
                        text-align: center;     /* posisikan di tengah */
                    }
                </style>
                <button class="btn btn-primary mb-3 float-end" id="download-selected"><i class="bi bi-file-pdf"></i> Download PDF Terpilih</button>
                <table class="table table-striped table-hover table4">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>
                                <input type="checkbox" id="select-all" style="width: 15px; height: 15px; margin-top: 5px;">
                            </th>
                            <th>No</th>
                            <th>NISN</th>
                            <th>NIPD</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                foreach ($siswa as $row) { ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="selected_siswa[]" value="<?php echo $row['nisn']; ?>" style="width: 15px; height: 15px; margin-top: 5px;">
                            </td>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($row['nisn']); ?></td>
                            <td><?php echo htmlspecialchars($row['nipd'] ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><?php echo htmlspecialchars($row['kelas']); ?></td>
                            <td>
                                <a href="<?php echo base_url('absen_siswa/buat_kartu_identitas/'.$row['nisn']); ?>" 
                                class="btn btn-sm btn-primary" 
                                target="_blank"
                                title="Download Kartu Identitas PDF">
                                <i class="bi bi-file-pdf"></i> Download PDF
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <script>
                    document.getElementById('select-all').addEventListener('change', function() {
                        var checkboxes = document.querySelectorAll('input[name="selected_siswa[]"]');
                        for (var checkbox of checkboxes) {
                            checkbox.checked = this.checked;
                        }
                    });
                    document.getElementById('download-selected').addEventListener('click', function() {
                        var selected = [];
                        var checkboxes = document.querySelectorAll('input[name="selected_siswa[]"]:checked');
                        for (var checkbox of checkboxes) {
                            selected.push(checkbox.value);
                        }
                        if (selected.length > 0) {
                            var url = "<?php echo base_url('absen_siswa/buat_kartu_identitas_batch'); ?>?nisn=" + selected.join(',');
                            window.open(url, '_blank');
                        } else {
                            alert('Silakan pilih setidaknya satu siswa untuk diunduh.');
                        }
                    });
                </script>
            </div>
            <?php } else { ?>
            <div class="alert alert-info">
                Tidak ada data siswa ditemukan.
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<style>
    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
</style>

<?php $this->load->view('absen_siswa/footer'); ?>
