<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div style="max-width: 520px; margin: 0 auto;">
    <div class="cl-card card-pad cl-text-center" style="padding: 40px 32px;">
        <p class="eyebrow cl-mb-3">hasil rekomendasi</p>

        <img src="<?= base_url('uploads/roles/' . esc($role->thumbnail ?? 'default-role.png')) ?>"
             alt="<?= esc($role->nama_role) ?>"
             style="width:120px;height:120px;object-fit:cover;border-radius:50%;border:3px solid var(--blue-100);margin:0 auto 18px;display:block;">

        <h2 style="color: var(--blue-600);"><?= esc($role->nama_role) ?></h2>

        <div class="cl-mb-3">
            <span class="cl-badge badge-blue" style="font-size:.85rem;padding:6px 14px;">
                Match <?= esc(number_format((float) $skor_persen, 2)) ?>%
            </span>
        </div>

        <p class="cl-text-muted"><?= esc($role->deskripsi ?? '') ?></p>

        <div style="border-top:1px solid var(--border); margin: 24px 0;"></div>

        <div class="flex cl-gap-3" style="justify-content:center;">
            <a href="<?= base_url('quiz-role/mulai/' . esc($role->id, 'attr')) ?>" class="cl-btn cl-btn-primary">Mulai Role Ini</a>
            <a href="<?= base_url('role/jelajahi') ?>" class="cl-btn btn-outline">Jelajahi Role Lain</a>
        </div>

        <p class="cl-mt-3"><a href="<?= base_url('quiz-role') ?>" class="cl-small cl-text-muted">Ulangi Quiz</a></p>
    </div>
</div>

<?= $this->endSection() ?>
