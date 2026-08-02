<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Unimal CodeVerse</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-box {
            width: 100%;
            max-width: 360px;
        }

        .auth-brand {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--blue-600);
            text-align: center;
            margin-bottom: 4px;
        }
    </style>
</head>

<body class="grid-bg">
    <div class="auth-box">
        <div class="cl-card card-pad">
            <p class="auth-brand">Unimal CodeVerse</p>
            <p class="cl-text-muted cl-text-center cl-small cl-mb-4">Masuk ke akunmu</p>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="cl-alert cl-alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="cl-alert cl-alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>

            <form action="<?= base_url('login') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label class="cl-form-label">Email</label>
                    <input type="email" name="email" class="cl-form-control" value="<?= old('email') ?>" required>
                </div>
                <div class="form-group">
                    <label class="cl-form-label">Password</label>
                    <input type="password" name="password" class="cl-form-control" required>
                </div>
                <button type="submit" class="cl-btn cl-btn-primary cl-w-100">Login</button>
            </form>
            <p class="cl-text-center cl-small cl-text-muted cl-mt-3">
                Belum punya akun? <a href="<?= base_url('register') ?>">Daftar</a>
            </p>
        </div>
    </div>
</body>

</html>