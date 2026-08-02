<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <h1 class="fw-bold mb-1">Learning Paths Saya</h1>
    <p class="text-muted mb-4">Daftar role spesialisasi yang sedang kamu jalani saat ini.</p>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <?php if (!empty($learning_paths)): ?>
            <?php foreach ($learning_paths as $lp): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="fw-bold text-dark mb-0"><?= esc($lp->nama_role) ?></h5>
                                    <span class="badge bg-light text-dark border"><?= esc(ucfirst($lp->sumber)) ?></span>
                                </div>
                                <small class="text-muted d-block mb-3">Dimulai: <?= esc($lp->started_at ?? '-') ?></small>

                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <small class="text-muted">Progres Total</small>
                                    <small class="fw-bold text-primary"><?= $lp->progress_percentage ?>%</small>
                                </div>
                                <div class="progress mb-3" style="height: 8px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $lp->progress_percentage ?>%;"></div>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-2">
                                <a href="<?= site_url('role/roadmap/' . $lp->role_id) ?>" class="btn btn-primary btn-sm flex-grow-1 fw-bold">
                                    <i class="bi bi-play-circle me-1"></i> Lanjut Belajar
                                </a>
                                <a href="<?= site_url('learning-paths/hapus/' . $lp->role_id) ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah kamu yakin ingin berhenti dari role ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center py-4">
                    Belum ada learning path aktif. <a href="<?= site_url('role/jelajahi') ?>" class="fw-bold">Pilih Role Sekarang</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>