<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h3 class="cl-mb-4"><?= $video ? 'Edit Video' : 'Tambah Video Baru' ?></h3>

<?php if (session()->getFlashdata('error')): ?><div class="cl-alert cl-alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

<div class="cl-card card-pad" style="max-width: 620px; margin: 0 auto;">
    <form action="<?= $video ? base_url('admin/video/update/' . esc($video->id, 'attr')) : base_url('admin/video/store') ?>"
        method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group">
            <label class="cl-form-label">Tipe Video</label>
            <select name="tipe" id="tipeVideo" class="cl-form-control" required>
                <option value="basic" <?= ($video->tipe ?? '') === 'basic' ? 'selected' : '' ?>>Basic Course</option>
                <option value="intermediate" <?= ($video->tipe ?? '') === 'intermediate' ? 'selected' : '' ?>>Intermediate (per Role)</option>
            </select>
        </div>

        <div class="form-group" id="fieldRole" style="display:none;">
            <label class="cl-form-label">Role / Spesialisasi</label>
            <select name="role_id" class="cl-form-control">
                <option value="">-- Pilih Role --</option>
                <?php foreach ($roles as $r): ?>
                    <option value="<?= esc($r->id, 'attr') ?>" <?= ($video->role_id ?? null) == $r->id ? 'selected' : '' ?>><?= esc($r->nama_role) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="cl-form-label">Judul</label>
            <input type="text" name="judul" class="cl-form-control" value="<?= esc(old('judul') ?? ($video->judul ?? '')) ?>" required maxlength="150">
        </div>

        <div class="form-group">
            <label class="cl-form-label">Deskripsi</label>
            <textarea name="deskripsi" class="cl-form-control" rows="3"><?= esc(old('deskripsi') ?? ($video->deskripsi ?? '')) ?></textarea>
        </div>

        <div class="form-group">
            <label class="cl-form-label">URL Video (embed YouTube/Vimeo)</label>
            <input type="url" name="video_url" class="cl-form-control" value="<?= esc(old('video_url') ?? ($video->video_url ?? '')) ?>"
                placeholder="https://www.youtube.com/embed/xxxxx" required>
        </div>

        <div class="cl-row">
            <div class="cl-col form-group"><label class="cl-form-label">Durasi (detik)</label>
                <input type="number" name="durasi_detik" class="cl-form-control" value="<?= esc(old('durasi_detik') ?? ($video->durasi_detik ?? '')) ?>" required min="1">
            </div>
            <div class="cl-col form-group"><label class="cl-form-label">Urutan</label>
                <input type="number" name="urutan" class="cl-form-control" value="<?= esc(old('urutan') ?? ($video->urutan ?? 0)) ?>" min="0">
            </div>
        </div>

        <div class="form-group">
            <label class="cl-form-label">Thumbnail <?= $video ? '(kosongkan jika tidak diganti)' : '' ?></label>
            <div class="upload-dropzone <?= ($video && !empty($video->thumbnail)) ? 'has-preview' : '' ?>">
                <input type="file" name="thumbnail" accept="image/jpeg,image/png" hidden>
                <div class="upload-preview-wrap <?= ($video && !empty($video->thumbnail)) ? 'is-active' : '' ?>">
                    <img src="<?= $video && !empty($video->thumbnail) ? base_url('uploads/videos/' . esc($video->thumbnail)) : '' ?>" alt="Preview">
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

        <button type="submit" class="cl-btn cl-btn-primary cl-w-100"><?= $video ? 'Perbarui' : 'Simpan' ?></button>
        <a href="<?= base_url('admin/video') ?>" class="cl-btn btn-outline cl-w-100 cl-mt-3">Batal</a>
    </form>
</div>

<script>
    const tipeSelect = document.getElementById('tipeVideo');
    const fieldRole = document.getElementById('fieldRole');

    function toggleFieldRole() {
        fieldRole.style.display = tipeSelect.value === 'intermediate' ? 'block' : 'none';
    }
    tipeSelect.addEventListener('change', toggleFieldRole);
    toggleFieldRole();
</script>

<?= $this->endSection() ?>