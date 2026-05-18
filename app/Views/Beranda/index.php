<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Beranda</h1>
            <p class="lead"><?php echo $sapaan; ?>, selamat datang di Sistem Manajemen Perpustakaan.</p>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-center h-100 border-primary">
                <div class="card-body">
                    <i class="bi bi-book fs-2 text-primary"></i>
                    <h2 class="my-2"><?php echo $statistik['total_buku']; ?></h2>
                    <p class="text-muted mb-0">Total Buku</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center h-100 border-success">
                <div class="card-body">
                    <i class="bi bi-people fs-2 text-success"></i>
                    <h2 class="my-2"><?php echo $statistik['total_anggota']; ?></h2>
                    <p class="text-muted mb-0">Total Anggota</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center h-100 border-warning">
                <div class="card-body">
                    <i class="bi bi-arrow-up-circle fs-2 text-warning"></i>
                    <h2 class="my-2"><?php echo $statistik['buku_dipinjam']; ?></h2>
                    <p class="text-muted mb-0">Dipinjam</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center h-100 border-info">
                <div class="card-body">
                    <i class="bi bi-check-circle fs-2 text-info"></i>
                    <h2 class="my-2"><?php echo $statistik['buku_tersedia']; ?></h2>
                    <p class="text-muted mb-0">Tersedia</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Buku Terbaru -->
    <h4 class="mb-3">Buku Terbaru Masuk</h4>
    <div class="row g-3">
        <?php foreach ($buku_terbaru as $buku): ?>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo esc($buku['judul']); ?></h5>
                        <p class="card-text text-muted">
                            <i class="bi bi-person"></i> <?php echo esc($buku['penulis']); ?><br>
                            <i class="bi bi-calendar"></i> <?php echo esc($buku['tahun']); ?>
                        </p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="<?php echo base_url('buku'); ?>" class="btn btn-sm btn-outline-primary">
                            Detail <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>
