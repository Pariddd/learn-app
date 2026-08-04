<?= $this->extend('layouts/main') ?>
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
        </div>
    </div>
</div>
<?= $this->endSection() ?>