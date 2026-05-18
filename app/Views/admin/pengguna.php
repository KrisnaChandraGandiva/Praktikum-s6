<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people"></i> Manajemen Pengguna</h2>
</div>

<?php if (session()->getFlashdata('sukses')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> <?= esc(session()->getFlashdata('sukses')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-x-circle"></i> <?= esc(session()->getFlashdata('error')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Pengguna</th>
                        <th>Status</th>
                        <th>Terakhir Login</th>
                        <th class="text-center">Role</th>
                        <th class="text-center pe-4">Aksi Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($users as $u): ?>
                    <?php $isSelf = ($u['id'] == session()->get('user_id')); ?>
                    <tr>
                        <td class="ps-4"><?= $no++ ?></td>
                        <td>
                            <strong><?= esc($u['nama_lengkap']) ?></strong><br>
                            <small class="text-muted">
                                <i class="bi bi-person"></i> <?= esc($u['username']) ?> &nbsp;|&nbsp; 
                                <i class="bi bi-envelope"></i> <?= esc($u['email']) ?>
                            </small>
                        </td>
                        <td>
                            <?php if ($u['aktif']): ?>
                                <span class="badge bg-success rounded-pill px-3">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-danger rounded-pill px-3">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= $u['last_login'] ? date('d M Y H:i', strtotime($u['last_login'])) : '<span class="text-muted fst-italic">Belum pernah</span>' ?>
                        </td>
                        <td class="text-center">
                            <?php if ($isSelf): ?>
                                <span class="badge bg-primary px-3 py-2 rounded-pill"><?= esc(ucfirst($u['role'])) ?></span>
                            <?php else: ?>
                                <form action="<?= base_url('admin/pengguna/ubah-role/' . $u['id']) ?>" method="post" class="d-flex justify-content-center">
                                    <?= csrf_field() ?>
                                    <select name="role" class="form-select form-select-sm" style="width: 120px;" onchange="this.form.submit()">
                                        <option value="admin" <?= $u['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="petugas" <?= $u['role'] == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                                        <option value="anggota" <?= $u['role'] == 'anggota' ? 'selected' : '' ?>>Anggota</option>
                                    </select>
                                </form>
                            <?php endif; ?>
                        </td>
                        <td class="text-center pe-4">
                            <?php if ($isSelf): ?>
                                <button class="btn btn-sm btn-secondary" disabled>Anda Saat Ini</button>
                            <?php else: ?>
                                <form action="<?= base_url('admin/pengguna/toggle-aktif/' . $u['id']) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <?php if ($u['aktif']): ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Nonaktifkan Pengguna">
                                            <i class="bi bi-person-x"></i> Nonaktifkan
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Aktifkan Pengguna">
                                            <i class="bi bi-person-check"></i> Aktifkan
                                        </button>
                                    <?php endif; ?>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if(empty($users)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada pengguna terdaftar.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
