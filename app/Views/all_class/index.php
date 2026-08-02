<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<p class="eyebrow cl-mb-2">all class</p>
<h2 class="cl-mb-4">Katalog Semua Video</h2>

<form method="get" class="flex cl-gap-2 cl-mb-4" style="flex-wrap:wrap;">
    <input type="text" name="keyword" class="cl-form-control" placeholder="Cari video..."
           value="<?= esc($keyword) ?>" style="flex:1;min-width:200px;">
    <select name="role_id" class="cl-form-control" style="max-width:200px;">
        <option value="">Semua Role</option>
        <?php foreach ($roles_filter as $r): ?>
            <option value="<?= esc($r->id, 'attr') ?>"><?= esc($r->nama_role) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="cl-btn cl-btn-primary">Cari</button>
</form>

<div class="grid grid-3 cl-mb-4">
    <?php foreach ($videos as $v): ?>
        <div class="cl-card" style="overflow:hidden;position:relative;">
            <?php if ($v->is_locked): ?>
                <div style="position:absolute;top:8px;right:8px;z-index:2;">
                    <span class="cl-badge badge-lock">🔒</span>
                </div>
            <?php endif; ?>
            <a href="<?= $v->is_locked ? '#' : base_url('video/' . esc($v->id, 'attr')) ?>" style="display:block;">
                <img src="<?= base_url('uploads/videos/' . esc($v->thumbnail ?? 'default-video.png')) ?>"
                     style="width:100%;height:120px;object-fit:cover;<?= $v->is_locked ? 'filter:grayscale(60%);opacity:.6;' : '' ?>">
            </a>
            <div class="card-pad">
                <?php if ($v->nama_role): ?><span class="cl-badge badge-blue" style="margin-bottom:6px;"><?= esc($v->nama_role) ?></span><?php endif; ?>
                <h4 style="font-size:.95rem;margin:6px 0 0;"><?= esc($v->judul) ?></h4>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($videos)): ?>
        <p class="cl-text-muted">Tidak ada video yang cocok dengan pencarian.</p>
    <?php endif; ?>
</div>

<div class="cl-text-center">
    <?= $pager->links() ?>
</div>

<?= $this->endSection() ?>
