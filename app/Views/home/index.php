<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberLearn — Temukan Jalur Kariermu di Cybersecurity</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%232563eb' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'><path d='M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z'/><path d='m9 12 2 2 4-4'/></svg>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
</head>

<body class="grid-bg">

    <header class="topnav">
        <div class="cl-container topnav-inner">
            <a class="topnav-brand flex cl-gap-2" href="<?= base_url('/') ?>">
                <?= view('partials/_icon', ['name' => 'shield-check', 'size' => 22, 'color' => 'var(--blue-500)']) ?>
                CyberLearn
            </a>
            <nav class="flex cl-gap-2">
                <a href="<?= base_url('login') ?>" class="cl-btn btn-outline cl-btn-sm">Login</a>
                <a href="<?= base_url('register') ?>" class="cl-btn cl-btn-primary cl-btn-sm">Daftar Gratis</a>
            </nav>
        </div>
    </header>

    <!-- HERO -->
    <section class="cl-container reveal" style="padding: 64px 24px 40px; text-align: center;">
        <p class="eyebrow cl-mb-3">platform belajar cybersecurity</p>
        <h1 style="font-size: 2.3rem; max-width: 680px; margin: 0 auto 16px; line-height: 1.25;">
            Temukan Jalur Kariermu di Dunia Cybersecurity
        </h1>
        <p class="cl-text-muted" style="max-width: 560px; margin: 0 auto 28px; font-size: 1.02rem;">
            Belajar dari fondasi, kerjakan quiz penentuan minat berbasis <strong>Cosine Similarity</strong>,
            lalu dapatkan rekomendasi spesialisasi yang paling cocok denganmu.
        </p>
        <div class="flex cl-gap-3" style="justify-content: center;">
            <a href="<?= base_url('register') ?>" class="cl-btn cl-btn-primary" style="padding: 12px 28px;">
                Mulai Belajar Sekarang
                <?= view('partials/_icon', ['name' => 'arrow-right', 'size' => 16]) ?>
            </a>
            <a href="<?= base_url('login') ?>" class="cl-btn btn-outline" style="padding: 12px 28px;">Sudah Punya Akun</a>
        </div>
    </section>

    <!-- CARA KERJA -->
    <section class="cl-container reveal" style="padding: 32px 24px 40px;">
        <p class="eyebrow cl-text-center cl-mb-2">alurnya sederhana</p>
        <h2 class="cl-text-center cl-mb-4">Cara Kerja CyberLearn</h2>

        <div class="step-row">
            <div class="step-col">
                <span class="step-number">LANGKAH 1</span>
                <div class="icon-badge" style="background: var(--blue-50); color: var(--blue-500); margin-left:auto;margin-right:auto;">
                    <?= view('partials/_icon', ['name' => 'user-plus', 'size' => 22]) ?>
                </div>
                <h4 style="font-size:.95rem;margin-bottom:4px;">Daftar Akun</h4>
                <p class="cl-text-muted cl-small">Gratis, cukup email dan password.</p>
            </div>
            <div class="step-col">
                <span class="step-number">LANGKAH 2</span>
                <div class="icon-badge" style="background: #f0fdf9; color: #0d9488; margin-left:auto;margin-right:auto;">
                    <?= view('partials/_icon', ['name' => 'play-circle', 'size' => 22]) ?>
                </div>
                <h4 style="font-size:.95rem;margin-bottom:4px;">Selesaikan Basic Course</h4>
                <p class="cl-text-muted cl-small">Fondasi Linux, CLI, dan jaringan.</p>
            </div>
            <div class="step-col">
                <span class="step-number">LANGKAH 3</span>
                <div class="icon-badge" style="background: #fef3e8; color: #ea580c; margin-left:auto;margin-right:auto;">
                    <?= view('partials/_icon', ['name' => 'clipboard-list', 'size' => 22]) ?>
                </div>
                <h4 style="font-size:.95rem;margin-bottom:4px;">Isi Quiz Minat</h4>
                <p class="cl-text-muted cl-small">10 soal berbasis skenario nyata.</p>
            </div>
            <div class="step-col">
                <span class="step-number">LANGKAH 4</span>
                <div class="icon-badge" style="background: #f5f0ff; color: #7c3aed; margin-left:auto;margin-right:auto;">
                    <?= view('partials/_icon', ['name' => 'award', 'size' => 22]) ?>
                </div>
                <h4 style="font-size:.95rem;margin-bottom:4px;">Dapat Rekomendasi</h4>
                <p class="cl-text-muted cl-small">Mulai roadmap sesuai role-mu.</p>
            </div>
        </div>
    </section>

    <!-- FITUR -->
    <section class="cl-container reveal" style="padding: 40px 24px;">
        <p class="eyebrow cl-text-center cl-mb-2">kenapa cyberlearn</p>
        <h2 class="cl-text-center cl-mb-4">Belajar Terstruktur, Bukan Asal Nonton</h2>

        <?php
        $fitur = [
            ['icon' => 'book-open', 'bg' => 'var(--blue-50)', 'color' => 'var(--blue-500)', 'judul' => 'Basic Course', 'teks' => 'Mulai dari fondasi: Kali Linux, command line, dan dasar jaringan sebelum masuk ke spesialisasi.'],
            ['icon' => 'target', 'bg' => '#fdf2f8', 'color' => '#db2777', 'judul' => 'Quiz Rekomendasi', 'teks' => '10 soal berbasis skenario nyata, dihitung pakai Cosine Similarity untuk mencocokkan minatmu ke role yang tepat.'],
            ['icon' => 'map', 'bg' => '#f0fdf9', 'color' => '#0d9488', 'judul' => 'Roadmap per Role', 'teks' => 'Jalur belajar terstruktur ala skill-tree, video dibuka bertahap sesuai urutan.'],
            ['icon' => 'bar-chart', 'bg' => '#f5f0ff', 'color' => '#7c3aed', 'judul' => 'Lacak Progress', 'teks' => 'Pantau perkembangan belajarmu di tiap role secara real-time lewat dashboard.'],
            ['icon' => 'unlock', 'bg' => '#fef3e8', 'color' => '#ea580c', 'judul' => 'Bebas Eksplorasi', 'teks' => 'Tidak puas sama hasil rekomendasi? Jelajahi role manapun secara manual, kapan saja.'],
            ['icon' => 'rotate-ccw', 'bg' => '#eef4ff', 'color' => '#2563eb', 'judul' => 'Ulangi Kapan Saja', 'teks' => 'Isi ulang quiz kapanpun minatmu berubah, semua riwayat percobaan tersimpan.'],
        ];
        ?>
        <div class="grid grid-3">
            <?php foreach ($fitur as $f): ?>
                <div class="cl-card card-pad hover-lift">
                    <div class="icon-badge" style="background: <?= esc($f['bg'], 'attr') ?>; color: <?= esc($f['color'], 'attr') ?>;">
                        <?= view('partials/_icon', ['name' => $f['icon'], 'size' => 22]) ?>
                    </div>
                    <h4 style="margin-bottom:6px;"><?= esc($f['judul']) ?></h4>
                    <p class="cl-text-muted cl-small" style="margin:0;"><?= esc($f['teks']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- SHOWCASE ROLE -->
    <?php if (!empty($roles)): ?>
        <section class="cl-container reveal" style="padding: 40px 24px;">
            <p class="eyebrow cl-text-center cl-mb-2">spesialisasi tersedia</p>
            <h2 class="cl-text-center cl-mb-4">Pilih Jalur yang Sesuai Denganmu</h2>

            <div class="grid grid-3">
                <?php foreach ($roles as $role): ?>
                    <div class="cl-card hover-lift" style="overflow:hidden;">
                        <img src="<?= base_url('uploads/roles/' . esc($role->thumbnail ?? 'default-role.png')) ?>"
                            style="width:100%;height:140px;object-fit:cover;" alt="<?= esc($role->nama_role) ?>">
                        <div class="card-pad">
                            <h4 style="margin-bottom:6px;"><?= esc($role->nama_role) ?></h4>
                            <p class="cl-text-muted cl-small" style="margin:0;"><?= esc(mb_strimwidth($role->deskripsi ?? '', 0, 90, '...')) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- CTA PENUTUP -->
    <section class="reveal" style="background: var(--blue-50); border-top: 1px solid var(--border); margin-top: 20px;">
        <div class="cl-container cl-text-center" style="padding: 48px 24px;">
            <div class="icon-badge" style="background: var(--white); color: var(--blue-500); margin: 0 auto 14px;">
                <?= view('partials/_icon', ['name' => 'check-circle', 'size' => 24]) ?>
            </div>
            <h3 class="cl-mb-2">Siap Mulai Perjalananmu?</h3>
            <p class="cl-text-muted cl-mb-3">Gratis, tidak perlu kartu kredit. Cukup daftar dan langsung belajar.</p>
            <a href="<?= base_url('register') ?>" class="cl-btn cl-btn-primary" style="padding: 12px 28px;">Daftar Sekarang</a>
        </div>
    </section>

    <footer class="cl-container cl-text-center cl-text-muted cl-small" style="padding: 24px;">
        Dikembangkan oleh mahasiswa Teknik Informatika sebagai bagian dari tugas akhir mata kuliah
        Pemrograman Berbasis Web Lanjutan. &copy; <?= date('Y') ?> CyberLearn.
    </footer>

    <script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>

</html>