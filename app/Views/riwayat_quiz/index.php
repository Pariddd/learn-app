<?= $this->extend('layouts/main') ?>

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