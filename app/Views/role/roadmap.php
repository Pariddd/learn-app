<?= $this->extend('layouts/main') ?>

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