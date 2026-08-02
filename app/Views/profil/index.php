<?= $this->extend('layouts/main') ?>
<<<<<<< HEAD
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

=======

<?= $this->section('content') ?>
<div class="container py-4">
    <h1 class="fw-bold mb-4">Pengaturan Profil</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm text-center p-4">
                <div class="mb-3">
                    <?php if (!empty($user->foto_profil)): ?>
                        <img src="<?= base_url('uploads/profil/' . $user->foto_profil) ?>" class="rounded-circle object-fit-cover shadow" style="width: 130px; height: 130px;" alt="Foto Profil">
                    <?php else: ?>
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto shadow" style="width: 130px; height: 130px; font-size: 3rem;">
                            <?= strtoupper(substr($user->nama ?? $user->username ?? 'U', 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <h5 class="fw-bold mb-1"><?= esc($user->nama ?? $user->username ?? 'User') ?></h5>
                <p class="text-muted small mb-0"><?= esc($user->email ?? '') ?></p>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Ubah Foto Profil</h5>
                    <form action="<?= site_url('profil/update') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="foto_profil" class="form-label">Upload Foto Baru (JPG, JPEG, PNG - Max 2MB)</label>
                            <input type="file" name="foto_profil" id="foto_profil" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary fw-bold">
                            <i class="bi bi-upload me-1"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
>>>>>>> 400a718f959571cc2e2daf8ee4073aeabb66b3c0
<?= $this->endSection() ?>