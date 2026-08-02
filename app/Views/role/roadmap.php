<?= $this->extend('layouts/main') ?>
<<<<<<< HEAD
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
=======

<?= $this->section('content') ?>
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('role/jelajahi') ?>">Jelajahi Role</a></li>
            <li class="breadcrumb-item active"><?= esc($role->nama_role) ?></li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="fw-bold text-primary mb-2"><?= esc($role->nama_role) ?></h2>
            <p class="text-muted mb-0"><?= esc($role->deskripsi) ?></p>
        </div>
    </div>

    <h4 class="fw-bold mb-3"><i class="bi bi-signpost-split me-2 text-primary"></i>Urutan Modul & Video</h4>

    <div class="row g-3">
        <?php if (!empty($videos)): ?>
            <?php foreach ($videos as $v): ?>
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-primary rounded-circle fs-6 me-3 d-flex align-items-center justify-content-center" style="width:38px; height:38px;">
                                    <?= esc($v->urutan) ?>
                                </span>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark"><?= esc($v->judul) ?></h6>
                                </div>
                            </div>
                            <div>
                                <?php if ($v->is_locked): ?>
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <i class="bi bi-lock-fill me-1"></i> Terkunci
                                    </button>
                                <?php else: ?>
                                    <a href="<?= site_url('video/' . $v->id) ?>" class="btn btn-outline-primary btn-sm fw-bold">
                                        <i class="bi bi-play-circle me-1"></i> Tonton
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">Materi untuk role ini belum diunggah.</div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
>>>>>>> 400a718f959571cc2e2daf8ee4073aeabb66b3c0
