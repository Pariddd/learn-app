<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <!-- Breadcrumb & Flash Alert -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= site_url('basic-course') ?>">Basic Course</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($video->judul) ?></li>
        </ol>
    </nav>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Kolom Utama: Player Video & Deskripsi -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm overflow-hidden mb-4">
                <!-- Video Container -->
                <div class="ratio ratio-16x9 bg-dark">
                    <?php 
                        $url = $video->url_video ?? $video->url ?? '';
                        // Cek apakah URL merupakan YouTube link
                        if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false): 
                            // Extract YouTube Video ID
                            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
                            $youtubeId = $matches[1] ?? '';
                    ?>
                        <iframe id="youtube-player" 
                                src="https://www.youtube.com/embed/<?= $youtubeId ?>?enablejsapi=1" 
                                title="<?= esc($video->judul) ?>" 
                                allowfullscreen></iframe>
                    <?php else: ?>
                        <!-- Fallback ke Native HTML5 Video jika file mp4 lokal -->
                        <video id="html5-player" controls class="w-100 h-100">
                            <source src="<?= base_url('uploads/videos/' . $url) ?>" type="video/mp4">
                            Browser kamu tidak mendukung video tag.
                        </video>
                    <?php endif; ?>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h3 class="fw-bold text-dark mb-0"><?= esc($video->judul) ?></h3>
                        <span id="status-badge" class="badge <?= $progress->status === 'selesai' ? 'bg-success' : 'bg-warning text-dark' ?> fs-6">
                            <?= ucfirst(esc($progress->status)) ?>
                        </span>
                    </div>

                    <!-- Progress Bar Nonton Real-time -->
                    <div class="my-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <small class="text-muted">Progres Tontonan</small>
                            <small id="progress-text" class="fw-bold text-primary"><?= esc($progress->watch_percentage) ?>%</small>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div id="progress-bar" class="progress-bar bg-primary" role="progressbar" 
                                 style="width: <?= esc($progress->watch_percentage) ?>%;" 
                                 aria-valuenow="<?= esc($progress->watch_percentage) ?>" 
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <hr>

                    <h6 class="fw-bold">Deskripsi Materi</h6>
                    <p class="text-secondary mb-0"><?= nl2br(esc($video->deskripsi ?? 'Tidak ada deskripsi materi.')) ?></p>
                </div>
            </div>
        </div>

        <!-- Kolom Samping: Link Referensi & Navigasi -->
        <div class="col-lg-4">
            <!-- Card Link Referensi -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-link-45deg me-2 text-primary"></i>Link Referensi & Bacaan</h6>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($referensi)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($referensi as $ref): ?>
                                <a href="<?= esc($ref->url ?? $ref->link) ?>" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-3">
                                    <div>
                                        <div class="fw-semibold text-dark"><?= esc($ref->judul ?? $ref->nama_link ?? 'Referensi') ?></div>
                                        <small class="text-muted"><?= esc($ref->url ?? $ref->link) ?></small>
                                    </div>
                                    <i class="bi bi-box-arrow-up-right text-muted"></i>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="p-3 text-muted text-center small">
                            Belum ada link referensi tambahan untuk materi ini.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tombol Tandai Selesai Manual -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <button id="btn-complete" class="btn btn-success w-100 fw-bold py-2" <?= $progress->watch_percentage >= 100 ? 'disabled' : '' ?>>
                        <i class="bi bi-check-circle me-1"></i> <?= $progress->watch_percentage >= 100 ? 'Materi Selesai' : 'Tandai Selesai (100%)' ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript AJAX Progress Tracking -->
<script>
    let csrfTokenName = '<?= csrf_token() ?>';
    let csrfHash = '<?= csrf_hash() ?>';
    const videoId = <?= $video->id ?>;
    let currentPercentage = <?= $progress->watch_percentage ?>;

    // Fungsi Pengiriman AJAX Progress ke Controller Video::updateProgress
    function sendProgress(percentage) {
        if (percentage <= currentPercentage) return; // Mencegah progress mundur
        currentPercentage = Math.min(percentage, 100);

        // Update UI secara instant
        document.getElementById('progress-bar').style.width = currentPercentage.toFixed(1) + '%';
        document.getElementById('progress-text').innerText = currentPercentage.toFixed(1) + '%';

        if (currentPercentage >= 90) {
            document.getElementById('status-badge').className = 'badge bg-success fs-6';
            document.getElementById('status-badge').innerText = 'Selesai';
        }

        // Kirim via Fetch API (AJAX)
        const formData = new FormData();
        formData.append('video_id', videoId);
        formData.append('percentage', currentPercentage);
        formData.append(csrfTokenName, csrfHash);

        fetch('<?= site_url('video/update-progress') ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // WAJIB: Update CSRF Hash baru dari response server
                csrfTokenName = data.csrf_token_name;
                csrfHash = data.csrf_hash;
            }
        })
        .catch(err => console.error('Error updating progress:', err));
    }

    // Handlers untuk Native Video HTML5
    const nativePlayer = document.getElementById('html5-player');
    if (nativePlayer) {
        nativePlayer.addEventListener('timeupdate', function() {
            if (nativePlayer.duration > 0) {
                let percent = (nativePlayer.currentTime / nativePlayer.duration) * 100;
                sendProgress(percent);
            }
        });
    }

    // Tombol Manual "Tandai Selesai"
    document.getElementById('btn-complete').addEventListener('click', function() {
        sendProgress(100);
        this.disabled = true;
        this.innerText = 'Materi Selesai';
    });
</script>

<!-- YouTube Iframe API Support -->
<script src="https://www.youtube.com/iframe_api"></script>
<script>
    let ytPlayer;
    function onYouTubeIframeAPIReady() {
        const iframe = document.getElementById('youtube-player');
        if (iframe) {
            ytPlayer = new YT.Player('youtube-player', {
                events: {
                    'onStateChange': onPlayerStateChange
                }
            });
        }
    }

    let progressInterval;
    function onPlayerStateChange(event) {
        // Event 1 = PLAYING
        if (event.data == YT.PlayerState.PLAYING) {
            progressInterval = setInterval(() => {
                if (ytPlayer && ytPlayer.getDuration) {
                    let duration = ytPlayer.getDuration();
                    let currentTime = ytPlayer.getCurrentTime();
                    if (duration > 0) {
                        let percent = (currentTime / duration) * 100;
                        sendProgress(percent);
                    }
                }
            }, 3000); // Trigger kirim progress tiap 3 detik
        } else {
            clearInterval(progressInterval);
        }
    }
</script>
<?= $this->endSection() ?>