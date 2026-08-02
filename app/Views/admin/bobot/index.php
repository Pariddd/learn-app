<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex-between cl-mb-4">
    <h3>Kelola Bobot Role – Kategori</h3>
    <button class="cl-btn cl-btn-primary" data-modal-open="modalTambah">+ Tambah Bobot</button>
</div>
<p class="cl-text-muted cl-small cl-mb-4">Vektor profil ideal tiap role, dipakai sebagai pembanding cosine similarity.</p>

<?php if (session()->getFlashdata('error')): ?><div class="cl-alert cl-alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

<?php $roleMap = array_column($roles, 'nama_role', 'id'); $kategoriMap = array_column($kategori, 'nama_kategori', 'id'); ?>

<div class="cl-card">
    <table class="data-table">
        <thead><tr><th>Role</th><th>Kategori</th><th>Bobot</th><th>Aksi</th></tr></thead>
        <tbody>
            <?php foreach ($bobot as $b): ?>
                <tr>
                    <td><?= esc($roleMap[$b->role_id] ?? '-') ?></td>
                    <td><?= esc($kategoriMap[$b->kategori_id] ?? '-') ?></td>
                    <td>
                        <form action="<?= base_url('admin/bobot/update/' . esc($b->id, 'attr')) ?>" method="post" class="flex cl-gap-2">
                            <?= csrf_field() ?>
                            <input type="number" name="bobot" value="<?= esc($b->bobot) ?>" step="0.01" min="0" max="1" class="cl-form-control" style="width:90px;">
                            <button type="submit" class="cl-btn cl-btn-sm btn-outline">Update</button>
                        </form>
                    </td>
                    <td><a href="<?= base_url('admin/bobot/delete/' . esc($b->id, 'attr')) ?>" class="cl-btn cl-btn-sm btn-danger-outline" onclick="return confirm('Hapus bobot ini?')">Hapus</a></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($bobot)): ?><tr><td colspan="4" class="cl-text-center cl-text-muted" style="padding:32px;">Belum ada data bobot.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal-overlay" id="modalTambah">
    <div class="modal-box">
        <form action="<?= base_url('admin/bobot/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="cl-modal-header"><h4 style="margin:0;">Tambah Bobot</h4><button type="button" class="modal-close" data-modal-close>&times;</button></div>
            <div class="cl-modal-body">
                <div class="form-group">
                    <label class="cl-form-label">Role</label>
                    <select name="role_id" class="cl-form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <?php foreach ($roles as $r): ?><option value="<?= esc($r->id, 'attr') ?>"><?= esc($r->nama_role) ?></option><?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="cl-form-label">Kategori</label>
                    <select name="kategori_id" class="cl-form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategori as $k): ?><option value="<?= esc($k->id, 'attr') ?>"><?= esc($k->nama_kategori) ?></option><?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="cl-form-label">Bobot (0.00 - 1.00)</label>
                    <input type="number" name="bobot" step="0.01" min="0" max="1" class="cl-form-control" required>
                </div>
            </div>
            <div class="cl-modal-footer"><button type="submit" class="cl-btn cl-btn-primary">Simpan</button></div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
