<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
/**
 * Fungsi untuk mengonversi URL YouTube biasa/share menjadi URL Embed Iframe
 */
function convertToYoutubeEmbed($url) {
    if (empty($url)) return null;

    // Pattern Regex untuk ekstrak 11 karakter ID YouTube
    $pattern = '/(?:youtube(?:-nocookie)?\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
    
    if (preg_match($pattern, trim($url), $matches)) {
        $videoId = $matches[1]; // Mengambil 'MB6CP1QvrJs'
        return [
            'type' => 'youtube',
            'id' => $videoId,
            'embed_url' => "https://www.youtube.com/embed/" . $videoId . "?enablejsapi=1&rel=0"
        ];
    }

    return [
        'type' => 'native',
        'embed_url' => trim($url)
    ];
}

// AMBIL DARI KOLOM DATABASE KAMU: video_url
$rawUrl = is_object($video) ? ($video->video_url ?? '') : ($video['video_url'] ?? '');
$media = convertToYoutubeEmbed($rawUrl);
?>

<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>" class="text-info text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= site_url('basic-course') ?>" class="text-info text-decoration-none">Basic Course</a></li>
            <li class="breadcrumb-item active text-white" aria-current="page"><?= esc(is_object($video) ? $video->judul : $video['judul']) ?></li>
        </ol>
    </nav>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="cl-alert cl-alert-danger mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="cl-card overflow-hidden mb-4 p-0">
                
                <!-- Pemutar Video -->
                <div class="ratio ratio-16x9 bg-black">
                    <?php if ($media && $media['type'] === 'youtube'): ?>
                        <iframe id="youtube-player" 
                                src="<?= $media['embed_url'] ?>" 
                                title="YouTube Video Player" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen></iframe>

                    <?php elseif ($media && $media['type'] === 'native' && !empty($rawUrl)): ?>
                        <video id="html5-player" controls class="w-100 h-100">
                            <source src="<?= (strpos($rawUrl, 'http') === 0) ? esc($rawUrl) : base_url('uploads/videos/' . $rawUrl) ?>" type="video/mp4">
                            Browser tidak mendukung pemutaran video.
                        </video>

                    <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center text-muted h-100">
                            <p class="mb-0">❌ Link materi video belum disiapkan atau format tidak didukung.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h3 class="fw-bold text-white mb-0"><?= esc(is_object($video) ? $video->judul : $video['judul']) ?></h3>
                        <span id="status-badge" class="badge <?= $progress->status === 'selesai' ? 'bg-success' : 'bg-warning text-dark' ?>">
                            <?= ucfirst(esc($progress->status)) ?>
                        </span>
                    </div>

                    <div class="my-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <small class="text-muted">Progres Tontonan</small>
                            <small id="progress-text" class="fw-bold text-info"><?= esc($progress->watch_percentage) ?>%</small>
                        </div>
                        <div class="progress" style="height: 8px; background-color: #222;">
                            <div id="progress-bar" class="progress-bar bg-info" role="progressbar" 
                                 style="width: <?= esc($progress->watch_percentage) ?>%;"></div>
                        </div>
                    </div>

                    <hr class="border-secondary">

                    <h6 class="fw-bold text-white">Deskripsi Materi</h6>
                    <p class="text-muted mb-0"><?= nl2br(esc((is_object($video) ? $video->deskripsi : $video['deskripsi']) ?? 'Tidak ada deskripsi.')) ?></p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="cl-card mb-4 p-4">
                <h6 class="fw-bold text-white mb-3">🔗 Link Referensi & Bacaan</h6>
                <?php if (!empty($referensi)): ?>
                    <div class="list-group list-group-flush bg-transparent">
                        <?php foreach ($referensi as $ref): ?>
                            <a href="<?= esc($ref->url ?? $ref->link) ?>" target="_blank" class="list-group-item bg-transparent text-info border-secondary py-2 px-0 d-flex align-items-center justify-content-between">
                                <span class="small text-truncate"><?= esc($ref->judul ?? $ref->nama_link ?? 'Referensi') ?></span>
                                <small>↗</small>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted small mb-0">Belum ada link referensi tambahan.</p>
                <?php endif; ?>
            </div>

            <div class="cl-card p-4">
                <button id="btn-complete" class="cl-btn w-100 fw-bold" <?= $progress->watch_percentage >= 100 ? 'disabled' : '' ?>>
                    <?= $progress->watch_percentage >= 100 ? '✓ Materi Selesai' : 'Tandai Selesai (100%)' ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let csrfTokenName = '<?= csrf_token() ?>';
    let csrfHash = '<?= csrf_hash() ?>';
    const videoId = <?= is_object($video) ? $video->id : $video['id'] ?>;
    let currentPercentage = <?= $progress->watch_percentage ?>;

    function sendProgress(percentage) {
        if (percentage <= currentPercentage) return;
        currentPercentage = Math.min(percentage, 100);

        document.getElementById('progress-bar').style.width = currentPercentage.toFixed(1) + '%';
        document.getElementById('progress-text').innerText = currentPercentage.toFixed(1) + '%';

        if (currentPercentage >= 90) {
            document.getElementById('status-badge').className = 'badge bg-success';
            document.getElementById('status-badge').innerText = 'Selesai';
        }

        const formData = new FormData();
        formData.append('video_id', videoId);
        formData.append('percentage', currentPercentage);
        formData.append(csrfTokenName, csrfHash);

        fetch('<?= site_url('video/update-progress') ?>', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                csrfTokenName = data.csrf_token_name;
                csrfHash = data.csrf_hash;
            }
        })
        .catch(err => console.error('Error updating progress:', err));
    }

    const nativePlayer = document.getElementById('html5-player');
    if (nativePlayer) {
        nativePlayer.addEventListener('timeupdate', function() {
            if (nativePlayer.duration > 0) {
                let percent = (nativePlayer.currentTime / nativePlayer.duration) * 100;
                sendProgress(percent);
            }
        });
    }

    document.getElementById('btn-complete').addEventListener('click', function() {
        sendProgress(100);
        this.disabled = true;
        this.innerText = '✓ Materi Selesai';
    });
</script>

<script src="https://www.youtube.com/iframe_api"></script>
<script>
    let ytPlayer;
    function onYouTubeIframeAPIReady() {
        const iframe = document.getElementById('youtube-player');
        if (iframe) {
            ytPlayer = new YT.Player('youtube-player', {
                events: { 'onStateChange': onPlayerStateChange }
            });
        }
    }

    let progressInterval;
    function onPlayerStateChange(event) {
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
            }, 3000);
        } else {
            clearInterval(progressInterval);
        }
    }
</script>
<?= $this->endSection() ?>