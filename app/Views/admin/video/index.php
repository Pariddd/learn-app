<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex-between cl-mb-4">
    <h3>Kelola Video</h3>
    <a href="<?= base_url('admin/video/create') ?>" class="cl-btn cl-btn-primary">+ Tambah Video</a>
</div>

<?php $roleMap = array_column($roles, 'nama_role', 'id'); ?>

<div class="cl-card">
    <table class="data-table">
        <thead><tr><th>Tipe</th><th>Judul</th><th>Role</th><th>Urutan</th><th>Aksi</th></tr></thead>
        <tbody>
            <?php foreach ($videos as $v): ?>
                <tr>
                    <td><span class="cl-badge <?= $v->tipe === 'basic' ? 'badge-gray' : 'badge-blue' ?>"><?= esc($v->tipe) ?></span></td>
                    <td><?= esc($v->judul) ?></td>
                    <td><?= $v->role_id ? esc($roleMap[$v->role_id] ?? '-') : '-' ?></td>
                    <td><?= esc($v->urutan) ?></td>
                    <td>
                        <a href="<?= base_url('admin/video/show/' . esc($v->id, 'attr')) ?>" class="cl-btn cl-btn-sm btn-outline">Detail</a>
                        <a href="<?= base_url('admin/video/edit/' . esc($v->id, 'attr')) ?>" class="cl-btn cl-btn-sm btn-outline">Edit</a>
                        <a href="<?= base_url('admin/video/delete/' . esc($v->id, 'attr')) ?>" class="cl-btn cl-btn-sm btn-danger-outline"
                           onclick="return confirm('Hapus video ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($videos)): ?>
                <tr><td colspan="5" class="cl-text-center cl-text-muted" style="padding:32px;">Belum ada data video.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
