<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex-between cl-mb-4">
    <h3>Kelola Kategori Minat</h3>
    <button class="cl-btn cl-btn-primary" data-modal-open="modalTambah">+ Tambah Kategori</button>
</div>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="cl-alert cl-alert-danger"><?php foreach (session()->getFlashdata('errors') as $err): ?><div><?= esc($err) ?></div><?php endforeach; ?></div>
<?php endif; ?>

<div class="cl-card">
    <table class="data-table">
        <thead><tr><th>Nama Kategori</th><th>Aksi</th></tr></thead>
        <tbody>
            <?php foreach ($kategori as $k): ?>
                <tr>
                    <td><?= esc($k->nama_kategori) ?></td>
                    <td>
                        <button class="cl-btn cl-btn-sm btn-outline" data-modal-open="modalEdit<?= esc($k->id, 'attr') ?>">Edit</button>
                        <a href="<?= base_url('admin/kategori/delete/' . esc($k->id, 'attr')) ?>" class="cl-btn cl-btn-sm btn-danger-outline"
                           onclick="return confirm('Hapus kategori ini? Gagal jika masih dipakai di bobot role/jawaban quiz.')">Hapus</a>
                    </td>
                </tr>

                <div class="modal-overlay" id="modalEdit<?= esc($k->id, 'attr') ?>">
                    <div class="modal-box">
                        <form action="<?= base_url('admin/kategori/update/' . esc($k->id, 'attr')) ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="cl-modal-header"><h4 style="margin:0;">Edit Kategori</h4><button type="button" class="modal-close" data-modal-close>&times;</button></div>
                            <div class="cl-modal-body">
                                <input type="text" name="nama_kategori" class="cl-form-control" value="<?= esc($k->nama_kategori) ?>" required maxlength="50">
                            </div>
                            <div class="cl-modal-footer"><button type="submit" class="cl-btn cl-btn-primary">Simpan</button></div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($kategori)): ?><tr><td colspan="2" class="cl-text-center cl-text-muted" style="padding:32px;">Belum ada kategori.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal-overlay" id="modalTambah">
    <div class="modal-box">
        <form action="<?= base_url('admin/kategori/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="cl-modal-header"><h4 style="margin:0;">Tambah Kategori</h4><button type="button" class="modal-close" data-modal-close>&times;</button></div>
            <div class="cl-modal-body">
                <input type="text" name="nama_kategori" class="cl-form-control" placeholder="mis. Offensive" required maxlength="50">
            </div>
            <div class="cl-modal-footer"><button type="submit" class="cl-btn cl-btn-primary">Simpan</button></div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
