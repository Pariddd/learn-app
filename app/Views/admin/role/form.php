<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h3 class="cl-mb-4"><?= $role ? 'Edit Role' : 'Tambah Role Baru' ?></h3>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="cl-alert cl-alert-danger"><?php foreach (session()->getFlashdata('errors') as $err): ?><div><?= esc($err) ?></div><?php endforeach; ?></div>
<?php endif; ?>

<div class="cl-card card-pad" style="max-width: 560px; margin: 0 auto;">
    <form action="<?= $role ? base_url('admin/role/update/' . esc($role->id, 'attr')) : base_url('admin/role/store') ?>"
        method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="form-group">
            <label class="cl-form-label">Nama Role</label>
            <input type="text" name="nama_role" class="cl-form-control" value="<?= esc(old('nama_role') ?? ($role->nama_role ?? '')) ?>" required maxlength="50">
        </div>
        <div class="form-group">
            <label class="cl-form-label">Deskripsi</label>
            <textarea name="deskripsi" class="cl-form-control" rows="4"><?= esc(old('deskripsi') ?? ($role->deskripsi ?? '')) ?></textarea>
        </div>
        <div class="form-group">
            <label class="cl-form-label">Thumbnail <?= $role ? '(kosongkan jika tidak diganti)' : '' ?></label>
            <div class="upload-dropzone <?= ($role && !empty($role->thumbnail)) ? 'has-preview' : '' ?>">
                <input type="file" name="thumbnail" accept="image/jpeg,image/png" hidden>
                <div class="upload-preview-wrap <?= ($role && !empty($role->thumbnail)) ? 'is-active' : '' ?>">
                    <img src="<?= $role && !empty($role->thumbnail) ? base_url('uploads/roles/' . esc($role->thumbnail)) : '' ?>" alt="Preview">
                    <div class="upload-preview-overlay">Klik atau seret untuk ganti gambar</div>
                </div>
                <div class="upload-dropzone-inner">
                    <div class="upload-icon">⬆</div>
                    <div class="upload-placeholder">
                        <p class="upload-title">Klik atau seret gambar ke sini</p>
                        <p class="upload-hint">JPG/PNG, maksimal 2MB</p>
                    </div>
                </div>
                <p class="upload-filename"></p>
            </div>
        </div>
        <button type="submit" class="cl-btn cl-btn-primary cl-w-100"><?= $role ? 'Perbarui' : 'Simpan' ?></button>
        <a href="<?= base_url('admin/role') ?>" class="cl-btn btn-outline cl-w-100 cl-mt-3">Batal</a>
    </form>
</div>

<?= $this->endSection() ?>