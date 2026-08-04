<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberLearn - <?= $title ?? 'Platform Belajar Cybersecurity' ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
    
    <!-- Chart.js CDN untuk Fitur Visualisasi Grafis -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="grid-bg">

    <?php $current = uri_string(); ?>
    <header class="topnav">
        <div class="cl-container topnav-inner">
            <a class="topnav-brand" href="<?= base_url('dashboard') ?>">CyberLearn</a>
            <button class="topnav-toggle" data-topnav-toggle aria-label="Buka menu">☰</button>
            <nav class="topnav-links">
                <a href="<?= base_url('dashboard') ?>" class="<?= $current === 'dashboard' ? 'active' : '' ?>">Dashboard</a>
                <a href="<?= base_url('basic-course') ?>" class="<?= str_contains($current, 'basic-course') ? 'active' : '' ?>">Basic Course</a>
                <a href="<?= base_url('all-class') ?>" class="<?= str_contains($current, 'all-class') ? 'active' : '' ?>">All Class</a>
                <a href="<?= base_url('role/jelajahi') ?>" class="<?= str_contains($current, 'role/jelajahi') ? 'active' : '' ?>">Jelajahi Role</a>
                <a href="<?= base_url('learning-paths') ?>" class="<?= str_contains($current, 'learning-paths') ? 'active' : '' ?>">My Paths</a>
                <a href="<?= base_url('riwayat-quiz') ?>" class="<?= str_contains($current, 'riwayat-quiz') ? 'active' : '' ?>">Riwayat Quiz</a>
                <a href="<?= base_url('profil') ?>" class="<?= str_contains($current, 'profil') ? 'active' : '' ?>">Profil</a>
                <?php if (session()->get('role') === 'admin'): ?>
                    <a href="<?= base_url('admin/dashboard') ?>" class="cl-btn cl-btn-sm">⚙ Dashboard Admin</a>
                <?php endif; ?>
                <a href="<?= base_url('logout') ?>" class="cl-btn btn-outline cl-btn-sm">Logout</a>
            </nav>
        </div>
    </header>

    <main class="cl-container" style="padding-top: 28px; padding-bottom: 60px;">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="cl-alert cl-alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="cl-alert cl-alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>

    <script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>

</html>