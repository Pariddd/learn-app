<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<p class="eyebrow cl-mb-2">basic course</p>
<h2 class="cl-mb-2">Fondasi Sebelum Memilih Role</h2>
<p class="cl-text-muted cl-mb-4" style="max-width:560px;">
    Selesaikan semua video di bawah secara berurutan. Setelah selesai, jalur akan bercabang
    ke beberapa spesialisasi cybersecurity yang bisa kamu pilih.
</p>

<div class="roadmap-track">
    <?php foreach ($videos as $i => $v): ?>
        <div class="roadmap-node <?= $v->status === 'selesai' ? 'is-done' : '' ?>">
            <div class="cl-card card-pad flex-between">
                <div style="display:flex;align-items:center;gap:14px;">
                    <img src="<?= base_url('uploads/videos/' . esc($v->thumbnail ?? 'default-video.png')) ?>"
                        style="width:70px;height:52px;object-fit:cover;border-radius:6px;flex-shrink:0;">
                    <div>
                        <p class="eyebrow" style="margin-bottom:2px;">video <?= $i + 1 ?></p>
                        <h4 style="margin:0;font-size:.95rem;"><?= esc($v->judul) ?></h4>
                        <p class="cl-text-muted cl-small" style="margin:2px 0 0;"><?= esc(number_format($v->watch_percentage, 0)) ?>% ditonton</p>
                    </div>
                </div>
                <div style="text-align:right;flex-shrink:0;">
                    <?php if ($v->status === 'selesai'): ?>
                        <span class="cl-badge badge-blue">✓ Selesai</span>
                    <?php else: ?>
                        <a href="<?= base_url('video/' . esc($v->id, 'attr')) ?>" class="cl-btn cl-btn-primary cl-btn-sm">
                            <?= $v->status === 'sedang' ? 'Lanjutkan' : 'Mulai' ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($videos)): ?>
        <p class="cl-text-muted">Belum ada video basic course.</p>
    <?php endif; ?>
</div>

<!-- Percabangan role - trunk turun lalu pecah jadi kolom paralel, ala TryHackMe -->
<?php if ($basic_selesai): ?>
    <div style="text-align:center; margin: 20px 0 8px;">
        <div class="branch-trunk"></div>
        <p class="eyebrow cl-mb-2">jalur bercabang di sini</p>
        <h3 class="cl-mb-2">Pilih Spesialisasimu</h3>
        <p class="cl-text-muted cl-mb-3">Basic course selesai! Isi Quiz Role untuk rekomendasi, atau jelajahi tiap jalur di bawah.</p>
        <a href="<?= base_url('quiz-role') ?>" class="cl-btn cl-btn-primary">Isi Quiz Role</a>
    </div>

    <?php
    // Warna aksen berbeda tiap kolom, berputar dari daftar ini (bukan gradient, solid color saja)
    $accentColors = ['#2563eb', '#dc2626', '#f59e0b', '#7c3aed', '#059669'];
    ?>
    <div class="branch-row cl-mt-3">
        <?php foreach ($roles_with_preview as $i => $rp): $accent = $accentColors[$i % count($accentColors)]; ?>
            <div class="branch-col">
                <div class="branch-col-header">
                    <div class="accent-bar" style="background: <?= esc($accent, 'attr') ?>;"></div>
                    <h4 style="margin:0 0 4px;font-size:.95rem;"><?= esc($rp['role']->nama_role) ?></h4>
                    <p class="cl-text-muted" style="font-size:.78rem;margin:0;"><?= esc(mb_strimwidth($rp['role']->deskripsi ?? '', 0, 60, '...')) ?></p>
                </div>

                <?php foreach ($rp['preview_videos'] as $v): ?>
                    <div class="branch-item">
                        <img src="<?= base_url('uploads/videos/' . esc($v->thumbnail ?? 'default-video.png')) ?>" alt="">
                        <span><?= esc(mb_strimwidth($v->judul, 0, 34, '...')) ?></span>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($rp['preview_videos'])): ?>
                    <p class="cl-text-muted" style="font-size:.78rem;text-align:center;">Belum ada video di role ini.</p>
                <?php endif; ?>

                <a href="<?= base_url('role/roadmap/' . esc($rp['role']->id, 'attr')) ?>" class="branch-more">
                    Lihat semua <?= esc($rp['total_videos']) ?> video →
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>