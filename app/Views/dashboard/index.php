<?= $this->extend('layouts/main') ?>
<<<<<<< HEAD
<?= $this->section('content') ?>

<p class="eyebrow cl-mb-2">dashboard</p>
<h2 class="cl-mb-4">Selamat Datang Kembali</h2>

<?php if (!$basic_selesai): ?>
    <div class="cl-card card-pad cl-mb-4" style="border-color: var(--blue-300); background: var(--blue-50);">
        <p style="margin:0;font-weight:600;">Selesaikan Basic Course dulu, yuk!</p>
        <p class="cl-text-muted cl-small" style="margin:6px 0 12px;">Setelah selesai, kamu bisa isi Quiz Role untuk mendapat rekomendasi spesialisasi.</p>
        <a href="<?= base_url('basic-course') ?>" class="cl-btn cl-btn-primary">Lanjutkan Basic Course</a>
    </div>
<?php endif; ?>

<div class="cl-row" style="margin: 0 -12px;">
    <div class="cl-col" style="flex: 1 1 60%; min-width: 300px;">
        <div class="cl-card card-pad cl-mb-3">
            <p class="eyebrow cl-mb-3">role yang sedang dijalani</p>
            <?php if (empty($roles_aktif)): ?>
                <p class="cl-text-muted cl-small">Belum ada role yang dijalani. Isi Quiz Role atau jelajahi role secara manual.</p>
                <a href="<?= base_url('role/jelajahi') ?>" class="cl-btn btn-outline cl-btn-sm">Jelajahi Role</a>
            <?php else: ?>
                <?php foreach ($roles_aktif as $r): ?>
                    <div style="padding: 12px 0; border-bottom: 1px solid var(--border);">
                        <div class="flex-between cl-mb-2">
                            <span style="font-weight:600;"><?= esc($r->nama_role) ?></span>
                            <span class="cl-small cl-text-muted"><?= esc($r->progress_percentage) ?>%</span>
                        </div>
                        <?= view('partials/_progress_bar', ['percentage' => $r->progress_percentage]) ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="cl-col" style="flex: 1 1 35%; min-width: 260px;">
        <div class="cl-card card-pad">
            <p class="eyebrow cl-mb-3">hasil quiz terakhir</p>
            <?php if ($last_quiz_result): ?>
                <h4 style="margin-bottom:4px;"><?= esc($last_quiz_result->nama_role_rekomendasi) ?></h4>
                <span class="cl-badge badge-blue">Match <?= esc(round((float) $last_quiz_result->skor_similarity * 100, 1)) ?>%</span>
                <p class="cl-mb-2" style="margin-top:14px;">
                    <a href="<?= base_url('quiz-role') ?>" class="cl-small">Ulangi Quiz →</a>
                </p>
            <?php else: ?>
                <p class="cl-text-muted cl-small">Kamu belum pernah mengisi Quiz Role.</p>
                <a href="<?= base_url('quiz-role') ?>" class="cl-btn cl-btn-primary cl-btn-sm">Isi Quiz Sekarang</a>
            <?php endif; ?>
=======

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h1 class="fw-bold">Dashboard Pembelajaran</h1>
            <p class="text-muted">Selamat datang kembali! Pantau progres dan perkembangan belajarmu di sini.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <!-- Link ke role/jelajahi -->
            <a href="<?= site_url('role/jelajahi') ?>" class="btn btn-outline-primary fw-bold">
                <i class="bi bi-plus-circle me-1"></i> Pilih Role Baru
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Basic Course -->
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-journal-bookmark fs-3 text-primary me-2"></i>
                            <h5 class="card-title mb-0 fw-bold">Status Basic Course</h5>
                        </div>
                        <p class="card-text text-muted">Selesaikan modul dasar untuk membuka kelas tingkat lanjut.</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <?php if ($basic_selesai): ?>
                            <span class="badge bg-success fs-6 py-2 px-3"><i class="bi bi-check-circle-fill me-1"></i> Selesai</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark fs-6 py-2 px-3"><i class="bi bi-clock-history me-1"></i> Belum Selesai</span>
                        <?php endif; ?>
                        
                        <a href="<?= site_url('basic-course') ?>" class="btn btn-sm btn-primary">
                            <i class="bi bi-play-circle me-1"></i> Masuk Materi
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quiz Role -->
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-trophy fs-3 text-warning me-2"></i>
                            <h5 class="card-title mb-0 fw-bold">Hasil Quiz Terakhir</h5>
                        </div>
                        <?php if ($last_quiz_result): ?>
                            <div class="mt-2">
                                <p class="mb-1 text-muted">Quiz Role: <strong><?= esc($last_quiz_result->nama_role ?? '-') ?></strong></p>
                                <h3 class="fw-bold text-primary mb-0"><?= esc($last_quiz_result->skor ?? $last_quiz_result->nilai ?? 0) ?> <small class="fs-6 text-muted">/ 100</small></h3>
                            </div>
                        <?php else: ?>
                            <p class="card-text text-muted mt-2">Kamu belum pernah mengambil quiz role.</p>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <!-- Link disesuaikan ke quiz-role -->
                        <a href="<?= site_url('quiz-role') ?>" class="btn btn-sm btn-outline-warning text-dark ms-auto">
                            <i class="bi bi-pencil-square me-1"></i> Ambil Quiz
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Learning Path Section -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-briefcase me-2 text-info"></i>Role & Learning Path Aktif</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($roles_aktif)): ?>
                        <div class="row g-3">
                            <?php foreach ($roles_aktif as $role): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="p-3 border rounded">
                                        <h6 class="fw-bold mb-2"><?= esc($role->nama_role) ?></h6>
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <small class="text-muted">Progres</small>
                                            <small class="fw-bold text-primary"><?= esc($role->progress_percentage) ?>%</small>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?= esc($role->progress_percentage) ?>%;"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-muted mb-3">Belum ada role aktif yang kamu ikuti.</p>
                            <a href="<?= site_url('role/jelajahi') ?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle me-1"></i> Pilih Role Pertama Kamu
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
>>>>>>> 400a718f959571cc2e2daf8ee4073aeabb66b3c0
        </div>
    </div>
</div>
<?= $this->endSection() ?>