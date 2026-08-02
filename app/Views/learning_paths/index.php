<?= $this->extend('layouts/main') ?>
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