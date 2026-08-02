<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h1 class="fw-bold mb-1">Jelajahi Role Spesialisasi</h1>
            <p class="text-muted">Temukan jalur karir yang sesuai dengan minat dan hasil quiz kamu.</p>
        </div>
        <?php if (!$has_quiz): ?>
            <div class="col-md-4 text-md-end">
                <!-- Link disesuaikan ke quiz-role -->
                <a href="<?= site_url('quiz-role') ?>" class="btn btn-warning fw-bold">
                    <i class="bi bi-patch-question me-1"></i> Ambil Quiz Rekomendasi
                </a>
            </div>
        <?php endif; ?>
    </div>

    <div class="row g-4">
        <?php if (!empty($roles)): ?>
            <?php foreach ($roles as $r): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden">
                        <div class="position-relative bg-dark text-center" style="height: 160px;">
                            <?php if (!empty($r->thumbnail)): ?>
                                <img src="<?= base_url('uploads/thumbnails/' . $r->thumbnail) ?>" class="w-100 h-100 object-fit-cover" alt="<?= esc($r->nama_role) ?>">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center h-100 text-white">
                                    <i class="bi bi-briefcase fs-1"></i>
                                </div>
                            <?php endif; ?>

                            <?php if ($r->match_percentage !== null): ?>
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-success fs-6 shadow-sm">
                                        <i class="bi bi-stars me-1"></i> Match <?= $r->match_percentage ?>%
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="fw-bold text-dark mb-2"><?= esc($r->nama_role) ?></h5>
                                <p class="text-muted small mb-3"><?= esc($r->deskripsi ?? '') ?></p>
                            </div>
                            <a href="<?= site_url('role/roadmap/' . $r->id) ?>" class="btn btn-primary w-100 fw-bold">
                                <i class="bi bi-diagram-3 me-1"></i> Lihat Roadmap
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>