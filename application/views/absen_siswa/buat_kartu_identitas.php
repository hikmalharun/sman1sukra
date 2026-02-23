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
                <table class="table table-striped table-hover table1">
                    <thead class="table-dark">
                        <tr>
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
