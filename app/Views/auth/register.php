<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CyberLearn</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
    <style>
        body { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px 0; }
        .auth-box { width: 100%; max-width: 380px; }
        .auth-brand { font-family: var(--font-display); font-weight: 700; font-size: 1.3rem; color: var(--blue-600); text-align: center; margin-bottom: 4px; }
    </style>
</head>
<body class="grid-bg">
    <div class="auth-box">
        <div class="cl-card card-pad">
            <p class="auth-brand">CyberLearn</p>
            <p class="cl-text-muted cl-text-center cl-small cl-mb-4">Buat akun baru</p>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="cl-alert cl-alert-danger">
                    <?php foreach (session()->getFlashdata('errors') as $err): ?>
                        <div><?= esc($err) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('register') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label class="cl-form-label">Username</label>
                    <input type="text" name="username" class="cl-form-control" value="<?= old('username') ?>" required>
                </div>
                <div class="form-group">
                    <label class="cl-form-label">Email</label>
                    <input type="email" name="email" class="cl-form-control" value="<?= old('email') ?>" required>
                </div>
                <div class="form-group">
                    <label class="cl-form-label">Password</label>
                    <input type="password" name="password" class="cl-form-control" minlength="8" required>
                </div>
                <div class="form-group">
                    <label class="cl-form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirm" class="cl-form-control" minlength="8" required>
                </div>
                <button type="submit" class="cl-btn cl-btn-primary cl-w-100">Daftar</button>
            </form>
            <p class="cl-text-center cl-small cl-text-muted cl-mt-3">
                Sudah punya akun? <a href="<?= base_url('login') ?>">Login</a>
            </p>
        </div>
    </div>
</body>
</html>
