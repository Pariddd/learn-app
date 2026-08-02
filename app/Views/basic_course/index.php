<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <!-- Header Section -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h1 class="fw-bold mb-1">Basic Course</h1>
            <p class="text-muted">Materi pembelajaran dasar yang wajib diselesaikan sebelum memilih spesialisasi role.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <?php if ($basic_selesai): ?>
                <span class="badge bg-success fs-6 py-2 px-3">
                    <i class="bi bi-check-circle-fill me-1"></i> Basic Course Selesai
                </span>
            <?php else: ?>
                <span class="badge bg-warning text-dark fs-6 py-2 px-3">
                    <i class="bi bi-clock-history me-1"></i> Sedang Berjalan
                </span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Section Daftar Video Basic Course -->
    <div class="row mb-5">
        <div class="col-12">
            <h4 class="fw-bold mb-3"><i class="bi bi-play-btn me-2 text-primary"></i>Daftar Video Materi</h4>
        </div>

        <?php if (!empty($videos)): ?>
            <div class="row g-4">
                <?php foreach ($videos as $video): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm overflow-hidden">
                            <!-- Thumbnail Video -->
                            <div class="position-relative bg-dark text-center" style="height: 180px;">
                                <?php if (!empty($video->thumbnail)): ?>
                                    <img src="<?= base_url('uploads/thumbnails/' . $video->thumbnail) ?>" class="w-100 h-100 object-fit-cover" alt="<?= esc($video->judul) ?>">
                                <?php else: ?>
                                    <div class="d-flex align-items-center justify-content-center h-100 text-white">
                                        <i class="bi bi-file-play fs-1"></i>
                                    </div>
                                <?php endif; ?>

                                <!-- Badge Status pada Thumbnail -->
                                <div class="position-absolute top-0 end-0 m-2">
                                    <?php if ($video->status === 'selesai'): ?>
                                        <span class="badge bg-success"><i class="bi bi-check-lg me-1"></i> Selesai</span>
                                    <?php elseif ($video->status === 'proses'): ?>
                                        <span class="badge bg-info text-dark"><i class="bi bi-play-fill me-1"></i> Diproses</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><i class="bi bi-circle me-1"></i> Belum Ditonton</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Detail Video -->
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h6 class="fw-bold text-dark mb-2"><?= esc($video->judul) ?></h6>
                                    <p class="text-muted small mb-3"><?= esc(character_limiter($video->deskripsi ?? '', 90)) ?></p>
                                </div>

                                <div>
                                    <!-- Progress Bar Nonton -->
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="text-muted">Progress Tonton</small>
                                        <small class="fw-bold text-primary"><?= esc($video->watch_percentage) ?>%</small>
                                    </div>
                                    <div class="progress mb-3" style="height: 6px;">
                                        <div class="progress-bar bg-primary" role="progressbar" 
                                             style="width: <?= esc($video->watch_percentage) ?>%;" 
                                             aria-valuenow="<?= esc($video->watch_percentage) ?>" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100"></div>
                                    </div>

                                    <!-- Tombol Tonton Video -->
                                    <a href="<?= site_url('video/' . $video->id) ?>" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="bi bi-play-circle me-1"></i> Tonton Materi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info border-0 shadow-sm text-center py-4">
                    <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                    Belum ada video materi dasar yang tersedia.
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Section Preview Role Spesialisasi (Hanya muncul jika Basic Course Selesai) -->
    <?php if ($basic_selesai): ?>
        <hr class="my-5">
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success border-0 shadow-sm d-flex align-items-center">
                    <i class="bi bi-award fs-1 me-3"></i>
                    <div>
                        <h5 class="fw-bold mb-1">Selamat! Basic Course Telah Selesai</h5>
                        <p class="mb-0">Kamu sekarang bisa membuka dan mendaftar pada role spesialisasi berikut ini.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-3">
                <h4 class="fw-bold"><i class="bi bi-stars me-2 text-warning"></i>Pilihan Role Spesialisasi</h4>
            </div>

            <?php if (!empty($roles_with_preview)): ?>
                <?php foreach ($roles_with_preview as $item): ?>
                    <?php 
                        $role = $item['role']; 
                        $previews = $item['preview_videos'];
                        $totalVideos = $item['total_videos'];
                    ?>
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold mb-0 text-primary"><?= esc($role->nama_role ?? $role['nama_role'] ?? 'Spesialisasi') ?></h5>
                                <span class="badge bg-light text-dark border"><?= $totalVideos ?> Video</span>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small mb-3"><?= esc($role->deskripsi ?? $role['deskripsi'] ?? 'Materi lanjutan spesialisasi.') ?></p>
                                
                                <h6 class="fw-bold small text-uppercase text-muted mb-2">Preview Modul:</h6>
                                <ul class="list-group list-group-flush mb-3">
                                    <?php if (!empty($previews)): ?>
                                        <?php foreach ($previews as $pv): ?>
                                            <li class="list-group-item px-0 py-1 bg-transparent border-0 d-flex align-items-center">
                                                <i class="bi bi-check2-square text-success me-2"></i>
                                                <small class="text-dark"><?= esc($pv->judul ?? $pv['judul']) ?></small>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li class="list-group-item px-0 bg-transparent border-0"><small class="text-muted">Belum ada video preview.</small></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div class="card-footer bg-white border-0 pt-0 pb-3">
                                <a href="<?= site_url('roles/select/' . ($role->id ?? $role['id'])) ?>" class="btn btn-primary w-100 fw-bold">
                                    <i class="bi bi-plus-circle me-1"></i> Pilih Role Ini
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-muted">Belum ada data role spesialisasi.</p>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>