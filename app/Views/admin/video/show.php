<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex-between cl-mb-4">
    <h3>Detail Video</h3>
    <div class="flex cl-gap-2">
        <a href="<?= base_url('admin/video/edit/' . esc($video->id, 'attr')) ?>" class="cl-btn btn-outline">Edit</a>
        <a href="<?= base_url('admin/video') ?>" class="cl-btn btn-outline">← Kembali</a>
    </div>
</div>

<div class="cl-row">
    <div class="cl-col" style="flex: 0 0 320px;">
        <div class="cl-card" style="overflow:hidden;">
            <?php if (!empty($video->thumbnail)): ?>
                <img src="<?= base_url('uploads/videos/' . esc($video->thumbnail)) ?>" style="width:100%;height:180px;object-fit:cover;">
            <?php else: ?>
                <div style="width:100%;height:180px;background:var(--blue-50);display:flex;align-items:center;justify-content:center;color:var(--ink-muted);">
                    Tidak ada thumbnail
                </div>
            <?php endif; ?>
            <div class="card-pad">
                <span class="cl-badge <?= $video->tipe === 'basic' ? 'badge-gray' : 'badge-blue' ?>"><?= esc($video->tipe) ?></span>
            </div>
        </div>
    </div>

    <div class="cl-col" style="flex: 1;">
        <div class="cl-card card-pad cl-mb-3">
            <p class="eyebrow cl-mb-2">informasi utama</p>
            <table class="data-table">
                <tr><td class="cl-text-muted" style="width:160px;">Judul</td><td><?= esc($video->judul) ?></td></tr>
                <tr><td class="cl-text-muted">Deskripsi</td><td><?= esc($video->deskripsi ?? '-') ?></td></tr>
                <tr><td class="cl-text-muted">Role</td><td><?= $role ? esc($role->nama_role) : '- (Basic Course)' ?></td></tr>
                <tr><td class="cl-text-muted">URL Video</td><td><a href="<?= esc($video->video_url) ?>" target="_blank"><?= esc($video->video_url) ?></a></td></tr>
                <tr><td class="cl-text-muted">Durasi</td><td><?= esc(gmdate('H:i:s', (int) $video->durasi_detik)) ?></td></tr>
                <tr><td class="cl-text-muted">Urutan</td><td><?= esc($video->urutan) ?></td></tr>
            </table>
        </div>

        <div class="cl-card card-pad">
            <p class="eyebrow cl-mb-2">link referensi (<?= count($referensi) ?>)</p>
            <?php if (empty($referensi)): ?>
                <p class="cl-text-muted cl-small">Belum ada link referensi untuk video ini.</p>
            <?php else: ?>
                <?php foreach ($referensi as $r): ?>
                    <div class="flex-between" style="padding:8px 0;border-bottom:1px solid var(--border);">
                        <div>
                            <span class="cl-badge badge-gray"><?= esc($r->jenis) ?></span>
                            <a href="<?= esc($r->url) ?>" target="_blank" style="margin-left:8px;"><?= esc($r->judul) ?></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
