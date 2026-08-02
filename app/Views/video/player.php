<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<p class="eyebrow cl-mb-2">video player</p>
<h2 class="cl-mb-4"><?= esc($video->judul) ?></h2>

<div class="cl-row" style="margin: 0 -12px;">
    <div class="cl-col" style="flex: 1 1 65%; min-width: 300px;">
        <div class="cl-card" style="overflow:hidden;">
            <div style="position:relative;padding-top:56.25%;background:#000;">
                <div id="ytPlayer" style="position:absolute;top:0;left:0;width:100%;height:100%;"></div>
            </div>
        </div>
        <div class="cl-mt-3">
            <?= view('partials/_progress_bar', ['percentage' => $progress->watch_percentage]) ?>
        </div>
        <div class="cl-mt-3">
            <?php if ($progress->status === 'selesai'): ?>
                <span class="cl-badge badge-blue">✓ Video Selesai</span>
            <?php else: ?>
                <button type="button" id="btnTandaiSelesai" class="cl-btn btn-outline">Tandai Selesai</button>
            <?php endif; ?>
        </div>
    </div>

    <div class="cl-col" style="flex: 1 1 30%; min-width: 260px;">
        <div class="cl-card card-pad">
            <p class="eyebrow cl-mb-3">referensi & lab tambahan</p>
            <?php if (empty($referensi)): ?>
                <p class="cl-text-muted cl-small">Belum ada referensi tambahan untuk video ini.</p>
            <?php else: ?>
                <?php foreach ($referensi as $r): ?>
                    <div style="padding: 8px 0; border-bottom: 1px solid var(--border);">
                        <span class="cl-badge badge-gray"><?= esc($r->jenis) ?></span>
                        <a href="<?= esc($r->url) ?>" target="_blank" style="display:block;margin-top:4px;"><?= esc($r->judul) ?></a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// Ekstrak video ID dari URL embed YouTube, misal https://www.youtube.com/embed/XXXXX
preg_match('/embed\/([a-zA-Z0-9_-]+)/', $video->video_url, $matches);
$youtubeId = $matches[1] ?? '';
?>
<script src="https://www.youtube.com/iframe_api"></script>
<script>
    let ytPlayerInstance;
    let sudahMulai = false;

    // Token CSRF disimpan sebagai variabel, di-refresh tiap response berhasil -
    // karena CI4 meregenerasi token tiap request, token awal saja tidak cukup
    // untuk request AJAX berulang (interval tracking + tombol Tandai Selesai).
    let csrfName = '<?= csrf_token() ?>';
    let csrfHash = '<?= csrf_hash() ?>';

    function onYouTubeIframeAPIReady() {
        ytPlayerInstance = new YT.Player('ytPlayer', {
            videoId: '<?= esc($youtubeId) ?>',
            events: {
                onStateChange: onPlayerStateChange
            }
        });
    }

    function onPlayerStateChange(event) {
        if (event.data === YT.PlayerState.PLAYING) sudahMulai = true;
    }

    async function kirimUpdateProgress(percentage) {
        const res = await fetch('<?= base_url('video/update-progress') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest' // wajib manual, fetch() tidak set ini otomatis (beda dari jQuery.ajax)
            },
            body: `video_id=<?= esc($video->id, 'attr') ?>&percentage=${percentage}&${csrfName}=${csrfHash}`
        });
        if (res.ok) {
            const data = await res.json();
            if (data.csrf_hash) csrfHash = data.csrf_hash; // simpan token baru untuk request berikutnya
        }
        return res;
    }

    function kirimProgress() {
        if (!sudahMulai || !ytPlayerInstance || !ytPlayerInstance.getDuration) return;
        const duration = ytPlayerInstance.getDuration();
        if (!duration) return;
        const percentage = (ytPlayerInstance.getCurrentTime() / duration) * 100;
        kirimUpdateProgress(percentage).catch(() => {});
    }

    setInterval(kirimProgress, 10000);
    window.addEventListener('beforeunload', kirimProgress);

    // Tombol manual "Tandai Selesai" - independen dari tracking IFrame API,
    // supaya user tetap bisa menyelesaikan video walau tracking otomatis gagal
    // (misal diblokir ad-blocker, atau video tidak diputar penuh dari awal).
    const btnTandai = document.getElementById('btnTandaiSelesai');
    if (btnTandai) {
        btnTandai.addEventListener('click', async () => {
            btnTandai.disabled = true;
            btnTandai.textContent = 'Menyimpan...';
            try {
                const res = await kirimUpdateProgress(100);
                if (res.ok) {
                    location.reload(); // reload supaya status "Selesai" langsung terlihat
                } else {
                    btnTandai.disabled = false;
                    btnTandai.textContent = 'Tandai Selesai';
                    const bodyText = await res.text();
                    console.error('Gagal tandai selesai. Status:', res.status, 'Response:', bodyText);
                    alert(`Gagal menandai selesai (status ${res.status}). Detail error ada di console browser (tekan F12 > Console).`);
                }
            } catch (e) {
                btnTandai.disabled = false;
                btnTandai.textContent = 'Tandai Selesai';
                console.error('Error jaringan:', e);
                alert('Terjadi kesalahan jaringan: ' + e.message);
            }
        });
    }
</script>

<?= $this->endSection() ?>