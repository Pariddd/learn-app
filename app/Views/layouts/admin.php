<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unimal CodeVerse Admin - <?= $title ?? '' ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
</head>

<body>

    <div class="admin-mobile-topbar">
        <button class="sidebar-toggle" data-sidebar-toggle aria-label="Buka menu">☰</button>
        <span class="admin-brand" style="margin:0;">Unimal CodeVerse</span>
        <span style="width:38px;"></span>
    </div>
    <div class="sidebar-backdrop"></div>

    <?php $current = uri_string(); ?>
    <aside class="admin-sidebar">
        <div class="admin-brand">Unimal CodeVerse</div>
        <div class="eyebrow">admin panel</div>
        <nav>
            <a href="<?= base_url('admin/dashboard') ?>" class="<?= str_contains($current, 'admin/dashboard') ? 'active' : '' ?>">Dashboard</a>
            <a href="<?= base_url('admin/role') ?>" class="<?= str_contains($current, 'admin/role') ? 'active' : '' ?>">Kelola Role</a>
            <a href="<?= base_url('admin/kategori') ?>" class="<?= str_contains($current, 'admin/kategori') ? 'active' : '' ?>">Kelola Kategori</a>
            <a href="<?= base_url('admin/video') ?>" class="<?= str_contains($current, 'admin/video') ? 'active' : '' ?>">Kelola Video</a>
            <a href="<?= base_url('admin/quiz') ?>" class="<?= str_contains($current, 'admin/quiz') ? 'active' : '' ?>">Bank Soal Quiz</a>
            <a href="<?= base_url('admin/bobot') ?>" class="<?= str_contains($current, 'admin/bobot') ? 'active' : '' ?>">Bobot Role-Kategori</a>
            <a href="<?= base_url('admin/link') ?>" class="<?= str_contains($current, 'admin/link') ? 'active' : '' ?>">Link Referensi</a>
            <hr>
            <a href="<?= base_url('dashboard') ?>">Lihat Sisi User</a>
            <a href="<?= base_url('logout') ?>">Logout</a>
        </nav>
    </aside>

    <div class="admin-main grid-bg">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="cl-alert cl-alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="cl-alert cl-alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </div>

    <script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>

</html>