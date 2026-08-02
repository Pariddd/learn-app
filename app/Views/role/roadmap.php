<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<p class="eyebrow cl-mb-2">roadmap</p>
<h2 class="cl-mb-2"><?= esc($role->nama_role) ?></h2>
<p class="cl-text-muted cl-mb-4" style="max-width:560px;margin-left:auto;margin-right:auto;text-align:center;">
    <?= esc($role->deskripsi ?? '') ?>
</p>

<div class="roadmap-track">
    <?php foreach ($videos as $v): ?>
        <div class="roadmap-node <?= $v->is_locked ? 'is-locked' : '' ?>">
            <div class="cl-card card-pad flex-between">
                <div style="display:flex;align-items:center;gap:14px;">
                    <img src="<?= base_url('uploads/videos/' . esc($v->thumbnail ?? 'default-video.png')) ?>"
                         style="width:60px;height:44px;object-fit:cover;border-radius:6px;flex-shrink:0;">
                    <div>
                        <p class="eyebrow" style="margin-bottom:2px;">video <?= esc($v->urutan) ?></p>
                        <h4 style="margin:0;font-size:.95rem;"><?= esc($v->judul) ?></h4>
                    </div>
                </div>
                <?php if ($v->is_locked): ?>
                    <span class="cl-badge badge-lock">🔒 Terkunci</span>
                <?php else: ?>
                    <a href="<?= base_url('video/' . esc($v->id, 'attr')) ?>" class="cl-btn cl-btn-primary cl-btn-sm">Mulai</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($videos)): ?>
        <p class="cl-text-muted cl-text-center">Belum ada video untuk role ini.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
