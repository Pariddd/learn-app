<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex-between cl-mb-4">
    <h3>Kelola Link Referensi</h3>
    <button class="cl-btn cl-btn-primary" data-modal-open="modalTambah">+ Tambah Link</button>
</div>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="cl-alert cl-alert-danger"><?php foreach (session()->getFlashdata('errors') as $err): ?><div><?= esc($err) ?></div><?php endforeach; ?></div>
<?php endif; ?>

<div class="cl-card">
    <table class="data-table">
        <thead><tr><th>Video</th><th>Jenis</th><th>Judul Link</th><th>Aksi</th></tr></thead>
        <tbody>
            <?php foreach ($links as $l): ?>
                <tr>
                    <td><?= esc($l->judul_video) ?></td>
                    <td><span class="cl-badge badge-gray"><?= esc($l->nama_jenis) ?></span></td>
                    <td><a href="<?= esc($l->url) ?>" target="_blank"><?= esc($l->judul) ?></a></td>
                    <td>
                        <button class="cl-btn cl-btn-sm btn-outline" data-modal-open="modalEdit<?= esc($l->id, 'attr') ?>">Edit</button>
                        <a href="<?= base_url('admin/link/delete/' . esc($l->id, 'attr')) ?>" class="cl-btn cl-btn-sm btn-danger-outline" onclick="return confirm('Hapus link ini?')">Hapus</a>
                    </td>
                </tr>

                <div class="modal-overlay" id="modalEdit<?= esc($l->id, 'attr') ?>">
                    <div class="modal-box">
                        <form action="<?= base_url('admin/link/update/' . esc($l->id, 'attr')) ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="cl-modal-header"><h4 style="margin:0;">Edit Link</h4><button type="button" class="modal-close" data-modal-close>&times;</button></div>
                            <div class="cl-modal-body">
                                <div class="form-group"><label class="cl-form-label">Judul</label><input type="text" name="judul" class="cl-form-control" value="<?= esc($l->judul) ?>" required maxlength="150"></div>
                                <div class="form-group"><label class="cl-form-label">URL</label><input type="url" name="url" class="cl-form-control" value="<?= esc($l->url) ?>" required></div>
                            </div>
                            <div class="cl-modal-footer"><button type="submit" class="cl-btn cl-btn-primary">Simpan</button></div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($links)): ?><tr><td colspan="4" class="cl-text-center cl-text-muted" style="padding:32px;">Belum ada link referensi.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal-overlay" id="modalTambah">
    <div class="modal-box">
        <form action="<?= base_url('admin/link/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="cl-modal-header"><h4 style="margin:0;">Tambah Link Referensi</h4><button type="button" class="modal-close" data-modal-close>&times;</button></div>
            <div class="cl-modal-body">
                <div class="form-group">
                    <label class="cl-form-label">Video</label>
                    <select name="video_id" class="cl-form-control" required>
                        <option value="">-- Pilih Video --</option>
                        <?php foreach ($videos as $v): ?><option value="<?= esc($v->id, 'attr') ?>"><?= esc($v->judul) ?></option><?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="cl-form-label">Jenis Link</label>
                    <select name="jenis_link_id" class="cl-form-control" required>
                        <option value="">-- Pilih Jenis --</option>
                        <?php foreach ($jenis as $j): ?><option value="<?= esc($j->id, 'attr') ?>"><?= esc($j->nama_jenis) ?></option><?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group"><label class="cl-form-label">Judul Link</label><input type="text" name="judul" class="cl-form-control" required maxlength="150"></div>
                <div class="form-group"><label class="cl-form-label">URL</label><input type="url" name="url" class="cl-form-control" placeholder="https://" required></div>
            </div>
            <div class="cl-modal-footer"><button type="submit" class="cl-btn cl-btn-primary">Simpan</button></div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
