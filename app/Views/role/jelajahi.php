<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<p class="eyebrow cl-mb-2">jelajahi role</p>
<h2 class="cl-mb-2">Temukan Spesialisasi Cybersecurity</h2>
<p class="cl-text-muted cl-mb-4">
    <?php if ($has_quiz): ?>
        Badge "Match" menunjukkan skor kecocokan berdasarkan hasil quiz terakhirmu.
    <?php else: ?>
        Belum isi quiz? <a href="<?= base_url('quiz-role') ?>">Isi Quiz Role</a> untuk lihat skor kecocokanmu.
    <?php endif; ?>
</p>

<div class="grid grid-3">
    <?php foreach ($roles as $role): ?>
        <a href="<?= base_url('role/roadmap/' . esc($role->id, 'attr')) ?>" style="text-decoration:none;color:inherit;">
            <?= view('partials/_card_role', ['role' => $role]) ?>
        </a>
    <?php endforeach; ?>
    <?php if (empty($roles)): ?>
        <p class="cl-text-muted">Belum ada role yang tersedia.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
