<?= $this->extend('layout/main') ?> 
<?= $this->section('content') ?> 

<div class='d-flex justify-content-between align-items-center mb-4'> 
    <div> 
        <h2><i class='bi bi-bar-chart-line'></i> Statistik Buku</h2> 
        <p class='text-muted mb-0'>Ringkasan data persediaan buku</p> 
    </div> 
    <a href='<?= base_url('buku') ?>' class='btn btn-secondary'> 
        <i class='bi bi-arrow-left'></i> Kembali ke Daftar Buku 
    </a> 
</div> 

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-journals display-4"></i>
                <h3 class="mt-3"><?= $statistik['total'] ?></h3>
                <p class="mb-0">Total Buku</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-box-seam display-4"></i>
                <h3 class="mt-3"><?= $statistik['total_stok'] ?></h3>
                <p class="mb-0">Total Stok Keseluruhan</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-calculator display-4"></i>
                <h3 class="mt-3"><?= $statistik['rata_stok'] ?></h3>
                <p class="mb-0">Rata-rata Stok per Buku</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Distribusi per Kategori</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Kategori</th>
                                <th class="text-center">Jumlah Buku</th>
                                <th class="text-center">Total Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($statistik['per_kategori'] as $k): ?>
                                <tr>
                                    <td><?= esc($k['nama'] ?? 'Tanpa Kategori') ?></td>
                                    <td class="text-center"><?= $k['jumlah'] ?></td>
                                    <td class="text-center"><?= $k['total_stok'] ?? 0 ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-sort-up"></i> Top 5 Stok Terbanyak</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Judul Buku</th>
                                <th>Kategori</th>
                                <th class="text-center">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($statistik['top_stok'] as $b): ?>
                                <tr>
                                    <td><?= esc($b['judul']) ?></td>
                                    <td><?= esc($b['nama_kategori'] ?? '-') ?></td>
                                    <td class="text-center"><span class="badge bg-success"><?= $b['stok'] ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($statistik['top_stok'])): ?>
                                <tr><td colspan="3" class="text-center text-muted">Belum ada data.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4 border-danger">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Perlu Restock (Stok 0)</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="100">Kode</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th class="text-center">Stok</th>
                        <th width="100" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($statistik['stok_kosong'] as $b): ?>
                        <tr>
                            <td><code><?= esc($b['kode_buku']) ?></code></td>
                            <td><strong><?= esc($b['judul']) ?></strong></td>
                            <td><?= esc($b['penulis']) ?></td>
                            <td><?= esc($b['nama_kategori'] ?? '-') ?></td>
                            <td class="text-center"><span class="badge bg-danger"><?= $b['stok'] ?></span></td>
                            <td class="text-center">
                                <a href="<?= base_url('buku/edit/'.$b['id']) ?>" class="btn btn-sm btn-warning">Restock</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($statistik['stok_kosong'])): ?>
                        <tr><td colspan="6" class="text-center text-muted py-3">Semua buku memiliki stok yang cukup.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
