<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <div class="mb-4">
                <span class="badge bg-success rounded-circle p-3 shadow-lg">
                    <i class="bi bi-trophy fs-1"></i>
                </span>
            </div>

            <h1 class="fw-bold mb-2">Hasil Rekomendasi Role Kamu</h1>
            <p class="text-muted mb-4">Berdasarkan analisis algoritma <em>Cosine Similarity</em>, berikut adalah role spesialisasi yang paling cocok:</p>

            <div class="card border-0 shadow-lg overflow-hidden mb-4">
                <div class="bg-primary text-white py-4 px-3">
                    <h5 class="text-uppercase tracking-wider small fw-bold text-white-50 mb-1">Rekomendasi Utama</h5>
                    <h2 class="fw-bold mb-0"><?= esc($role['nama_role'] ?? $role->nama_role ?? 'Spesialisasi') ?></h2>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="d-inline-block p-3 rounded-circle bg-light border border-3 border-success mb-3">
                        <span class="fs-1 fw-bold text-success"><?= $skor_persen ?>%</span>
                        <small class="d-block text-muted">Kesesuaian (Match)</small>
                    </div>

                    <h5 class="fw-bold text-dark mt-3 mb-2">Deskripsi Role:</h5>
                    <p class="text-muted lead fs-6 mb-4">
                        <?= esc($role['deskripsi'] ?? $role->deskripsi ?? '') ?>
                    </p>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <?php $roleId = $role['id'] ?? $role->id; ?>
                        <!-- Link disesuaikan ke quiz-role/mulai/ -->
                        <a href="<?= site_url('quiz-role/mulai/' . $roleId) ?>" class="btn btn-success btn-lg fw-bold px-4">
                            <i class="bi bi-rocket-takeoff me-2"></i> Mulai Belajar Role Ini
                        </a>
                        <a href="<?= site_url('role/jelajahi') ?>" class="btn btn-outline-primary btn-lg fw-bold px-4">
                            <i class="bi bi-compass me-2"></i> Jelajahi Role Lain
                        </a>
                    </div>
                </div>
            </div>

            <a href="<?= site_url('dashboard') ?>" class="text-decoration-none text-muted">
                <i class="bi bi-house me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>