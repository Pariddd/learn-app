<?= $this->extend('layouts/main') ?>
<<<<<<< HEAD
<?= $this->section('content') ?>

<p class="eyebrow cl-mb-2">my learning paths</p>
<h2 class="cl-mb-4">Role yang Sedang Kamu Jalani</h2>

<?php if (empty($learning_paths)): ?>
    <div class="cl-card card-pad cl-text-center">
        <p class="cl-text-muted cl-mb-3">Kamu belum menjalani role apapun.</p>
        <a href="<?= base_url('role/jelajahi') ?>" class="cl-btn cl-btn-primary">Jelajahi Role</a>
    </div>
<?php else: ?>
    <div class="grid grid-2">
        <?php foreach ($learning_paths as $lp): ?>
            <div class="cl-card card-pad">
                <div class="flex-between cl-mb-2">
                    <h4 style="margin:0;"><?= esc($lp->nama_role) ?></h4>
                    <span class="cl-badge <?= $lp->sumber === 'quiz' ? 'badge-blue' : 'badge-gray' ?>">
                        <?= $lp->sumber === 'quiz' ? 'via Quiz' : 'Manual' ?>
                    </span>
                </div>
                <?= view('partials/_progress_bar', ['percentage' => $lp->progress_percentage]) ?>
                <div class="flex cl-gap-2 cl-mt-3">
                    <a href="<?= base_url('role/roadmap/' . esc($lp->role_id, 'attr')) ?>" class="cl-btn btn-outline cl-btn-sm">Lanjutkan</a>
                    <a href="<?= base_url('learning-paths/hapus/' . esc($lp->role_id, 'attr')) ?>" class="cl-btn btn-danger-outline cl-btn-sm"
                       onclick="return confirm('Hapus role ini dari daftar yang sedang dijalani? Progress video yang sudah ditonton tetap tersimpan kalau kamu mulai lagi nanti.')">
                        Hapus
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
=======

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
>>>>>>> 400a718f959571cc2e2daf8ee4073aeabb66b3c0
