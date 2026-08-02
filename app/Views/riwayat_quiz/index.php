<?= $this->extend('layouts/main') ?>
<<<<<<< HEAD
<?= $this->section('content') ?>

<p class="eyebrow cl-mb-2">riwayat quiz</p>
<h2 class="cl-mb-4">Histori Pengisian Quiz Role</h2>

<div class="cl-card">
    <table class="data-table">
        <thead><tr><th>Tanggal</th><th>Role Direkomendasikan</th><th>Skor Match</th></tr></thead>
        <tbody>
            <?php foreach ($riwayat as $r): ?>
                <tr>
                    <td><?= esc(date('d M Y, H:i', strtotime($r->tanggal))) ?></td>
                    <td><?= esc($r->nama_role_rekomendasi) ?></td>
                    <td><span class="cl-badge badge-blue"><?= esc($r->skor_similarity) ?>%</span></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($riwayat)): ?>
                <tr><td colspan="3" class="cl-text-center cl-text-muted" style="padding:32px;">
                    Belum ada riwayat quiz. <a href="<?= base_url('quiz-role') ?>">Isi Quiz Role</a>
                </td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
=======

<?= $this->section('content') ?>
<div class="container py-4">
    <h1 class="fw-bold mb-1">Riwayat Quiz & Rekomendasi</h1>
    <p class="text-muted mb-4">Catatan hasil tes minat dan kesesuaian role yang pernah kamu kerjakan.</p>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <?php if (!empty($riwayat)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Tanggal Dikerjakan</th>
                                <th>Rekomendasi Role Utama</th>
                                <th>Skor Kemiripan (Similarity)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($riwayat as $r): ?>
                                <tr>
                                    <td class="ps-4 fw-bold"><?= $no++ ?></td>
                                    <td><?= esc($r->tanggal ?? '-') ?></td>
                                    <td><span class="badge bg-primary fs-6"><?= esc($r->nama_role_rekomendasi ?? '-') ?></span></td>
                                    <td class="fw-bold text-success"><?= esc($r->skor_similarity) ?>% Match</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="p-4 text-center text-muted">
                    Kamu belum pernah mengambil quiz rekomendasi role.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
>>>>>>> 400a718f959571cc2e2daf8ee4073aeabb66b3c0
