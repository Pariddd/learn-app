<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex-between cl-mb-4">
    <h3>Kelola Role / Spesialisasi</h3>
    <a href="<?= base_url('admin/role/create') ?>" class="cl-btn cl-btn-primary">+ Tambah Role</a>
</div>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="cl-alert cl-alert-danger"><?php foreach (session()->getFlashdata('errors') as $err): ?><div><?= esc($err) ?></div><?php endforeach; ?></div>
<?php endif; ?>

<div class="cl-card">
    <table class="data-table">
        <thead><tr><th>Thumbnail</th><th>Nama Role</th><th>Deskripsi</th><th>Aksi</th></tr></thead>
        <tbody>
            <?php foreach ($roles as $role): ?>
                <tr>
                    <td><img src="<?= base_url('uploads/roles/' . esc($role->thumbnail ?? 'default-role.png')) ?>" style="width:48px;height:48px;object-fit:cover;border-radius:6px;"></td>
                    <td><?= esc($role->nama_role) ?></td>
                    <td class="cl-text-muted cl-small"><?= esc(mb_strimwidth($role->deskripsi ?? '', 0, 80, '...')) ?></td>
                    <td>
                        <a href="<?= base_url('admin/role/edit/' . esc($role->id, 'attr')) ?>" class="cl-btn cl-btn-sm btn-outline">Edit</a>
                        <a href="<?= base_url('admin/role/delete/' . esc($role->id, 'attr')) ?>" class="cl-btn cl-btn-sm btn-danger-outline"
                           onclick="return confirm('Yakin hapus role ini? Semua video, bobot, dan progress terkait ikut terhapus.')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($roles)): ?><tr><td colspan="4" class="cl-text-center cl-text-muted" style="padding:32px;">Belum ada data role.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
