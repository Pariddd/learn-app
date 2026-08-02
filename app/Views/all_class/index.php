<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="fw-bold mb-1">Semua Kelas & Materi</h1>
            <p class="text-muted">Jelajahi seluruh koleksi video pembelajaran dari berbagai role dan spesialisasi.</p>
        </div>
    </div>

    <!-- Filter & Search Form -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="<?= site_url('all-class') ?>" method="get" class="row g-3">
                <!-- Input Keyword -->
                <div class="col-md-6 col-lg-5">
                    <label for="keyword" class="form-label small fw-semibold">Cari Judul Materi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="keyword" id="keyword" class="form-control border-start-0" 
                               placeholder="Ketik kata kunci..." value="<?= esc($keyword ?? '') ?>">
                    </div>
                </div>

                <!-- Select Filter Role -->
                <div class="col-md-4 col-lg-4">
                    <label for="role_id" class="form-label small fw-semibold">Filter Berdasarkan Role</label>
                    <select name="role_id" id="role_id" class="form-select">
                        <option value="">-- Semua Role --</option>
                        <?php if (!empty($roles_filter)): ?>
                            <?php foreach ($roles_filter as $rf): ?>
                                <?php 
                                    $rfId = is_object($rf) ? $rf->id : $rf['id'];
                                    $rfNama = is_object($rf) ? $rf->nama_role : $rf['nama_role'];
                                    $selected = (request()->getGet('role_id') == $rfId) ? 'selected' : '';
                                ?>
                                <option value="<?= $rfId ?>" <?= $selected ?>><?= esc($rfNama) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Tombol Submit & Reset -->
                <div class="col-md-2 col-lg-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                    <?php if (!empty($keyword) || request()->getGet('role_id')): ?>
                        <a href="<?= site_url('all-class') ?>" class="btn btn-outline-secondary" title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Grid List Video -->
    <div class="row g-4 mb-4">
        <?php if (!empty($videos)): ?>
            <?php foreach ($videos as $v): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden position-relative">
                        <!-- Thumbnail & Lock Overlay -->
                        <div class="position-relative bg-dark text-center" style="height: 180px;">
                            <?php if (!empty($v->thumbnail)): ?>
                                <img src="<?= base_url('uploads/thumbnails/' . $v->thumbnail) ?>" 
                                     class="w-100 h-100 object-fit-cover <?= $v->is_locked ? 'opacity-50' : '' ?>" 
                                     alt="<?= esc($v->judul) ?>">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center h-100 text-white">
                                    <i class="bi bi-file-play fs-1"></i>
                                </div>
                            <?php endif; ?>

                            <!-- Badge Role -->
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-primary text-white shadow-sm">
                                    <?= esc($v->nama_role ?? 'Basic Course') ?>
                                </span>
                            </div>

                            <!-- Overlay Terkunci (Locked) -->
                            <?php if ($v->is_locked): ?>
                                <div class="position-absolute top-50 start-50 translate-middle text-white text-center w-100 px-3">
                                    <i class="bi bi-lock-fill fs-1 text-warning mb-1 d-block"></i>
                                    <span class="badge bg-dark bg-opacity-75">Selesaikan Basic Course</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Detail Card -->
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h6 class="fw-bold text-dark mb-2"><?= esc($v->judul) ?></h6>
                            </div>

                            <div class="mt-3">
                                <?php if ($v->is_locked): ?>
                                    <button class="btn btn-secondary btn-sm w-100" disabled>
                                        <i class="bi bi-lock me-1"></i> Terkunci
                                    </button>
                                <?php else: ?>
                                    <a href="<?= site_url('video/' . $v->id) ?>" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="bi bi-play-circle me-1"></i> Tonton Kelas
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info border-0 shadow-sm text-center py-5">
                    <i class="bi bi-search fs-1 d-block mb-3 text-muted"></i>
                    <h5 class="fw-bold">Kelas Tidak Ditemukan</h5>
                    <p class="text-muted mb-0">Coba ubah kata kunci atau filter role yang kamu pilih.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ($pager): ?>
        <div class="d-flex justify-content-center mt-4">
            <?= $pager->links('default', 'default_full') ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>