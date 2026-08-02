<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<p class="eyebrow cl-mb-2">profil</p>
<h2 class="cl-mb-4">Akun Saya</h2>

<div class="cl-card card-pad" style="max-width: 480px;">
    <form action="<?= base_url('profil/update') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group" style="text-align:center;">
            <img src="<?= base_url('uploads/profil/' . esc($user->foto_profil ?? 'default-avatar.png')) ?>"
                 style="width:90px;height:90px;object-fit:cover;border-radius:50%;border:3px solid var(--blue-100);margin-bottom:14px;">

            <div class="upload-dropzone">
                <input type="file" name="foto_profil" accept="image/jpeg,image/png" hidden>
                <div class="upload-preview-wrap">
                    <img src="" alt="Preview">
                    <div class="upload-preview-overlay">Klik atau seret untuk ganti foto</div>
                </div>
                <div class="upload-dropzone-inner">
                    <div class="upload-icon">⬆</div>
                    <div class="upload-placeholder">
                        <p class="upload-title">Klik atau seret foto ke sini</p>
                        <p class="upload-hint">JPG/PNG, maksimal 2MB</p>
                    </div>
                </div>
                <p class="upload-filename"></p>
            </div>
        </div>

        <div class="form-group">
            <label class="cl-form-label">Username</label>
            <input type="text" class="cl-form-control" value="<?= esc($user->username) ?>" disabled>
        </div>
        <div class="form-group">
            <label class="cl-form-label">Email</label>
            <input type="email" class="cl-form-control" value="<?= esc($user->email) ?>" disabled>
        </div>
        <div class="form-group">
            <label class="cl-form-label">Bergabung Sejak</label>
            <input type="text" class="cl-form-control" value="<?= esc(date('d M Y', strtotime($user->created_at))) ?>" disabled>
        </div>

        <button type="submit" class="cl-btn cl-btn-primary cl-w-100">Simpan Foto Profil</button>
    </form>
</div>

<?= $this->endSection() ?>
