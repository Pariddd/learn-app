<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h1 class="fw-bold text-black">Dashboard Pembelajaran</h1>
        <p class="text-muted">Pantau progres belajar dan analisis grafik performa kamu di CyberLearn.</p>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="<?= site_url('role/jelajahi') ?>" class="cl-btn cl-btn-sm">
            + Pilih Role Baru
        </a>
    </div>
</div>

<!-- Status Basic & Quiz -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="cl-card h-100 p-4">
            <h5 class="fw-bold mb-2">Status Basic Course</h5>
            <p class="text-muted small">Selesaikan seluruh modul dasar sebelum mengambil role spesialisasi.</p>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <?php if ($basic_selesai): ?>
                    <span class="badge bg-success py-2 px-3">✓ Selesai</span>
                <?php else: ?>
                    <span class="badge bg-warning text-dark py-2 px-3">⏳ Belum Selesai</span>
                <?php endif; ?>
                <a href="<?= site_url('basic-course') ?>" class="cl-btn cl-btn-sm">Masuk Materi</a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="cl-card h-100 p-4">
            <h5 class="fw-bold mb-2">Hasil Quiz Terakhir</h5>
            <?php if ($last_quiz_result): ?>
                <?php 
                    // Penyesuaian alias kolom dari HasilQuizRoleModel
                    $roleRekomendasi = $last_quiz_result->nama_role_rekomendasi ?? $last_quiz_result->nama_role ?? '-';
                    $rawSkor = (float) ($last_quiz_result->skor_similarity ?? $last_quiz_result->skor ?? 0);
                    // Jika skor desimal (0.85), konversi ke persen (85%)
                    $skorPersen = $rawSkor <= 1 ? round($rawSkor * 100, 1) : round($rawSkor, 1);
                ?>
                <p class="text-muted mb-1">Rekomendasi Role: <strong class="text-info"><?= esc($roleRekomendasi) ?></strong></p>
                <h3 class="fw-bold text-primary"><?= esc($skorPersen) ?> %</h3>
            <?php else: ?>
                <p class="text-muted small mb-0">Kamu belum pernah mengerjakan quiz penentuan role.</p>
            <?php endif; ?>
            <div class="text-end mt-3">
                <a href="<?= site_url('quiz-role') ?>" class="cl-btn btn-outline cl-btn-sm">
                    <?= $last_quiz_result ? 'Ulangi Quiz' : 'Ambil Quiz' ?>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- FITUR GRAFIS: Visualisasi Bar Chart Progres Paths -->
<div class="cl-card p-4">
    <h5 class="fw-bold mb-3">📊 Grafik Progres Learning Paths Aktif</h5>
    <?php if (!empty($roles_aktif)): ?>
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div style="position: relative; height:280px;">
                    <canvas id="progressChart"></canvas>
                </div>
            </div>
            <div class="col-lg-4">
                <h6 class="fw-bold mb-3">Detail Persentase:</h6>
                <?php foreach ($roles_aktif as $role): ?>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between text-muted small mb-1">
                            <span><?= esc($role->nama_role) ?></span>
                            <span class="fw-bold text-white"><?= esc($role->progress_percentage) ?>%</span>
                        </div>
                        <div class="progress" style="height: 6px; background-color: #222;">
                            <div class="progress-bar bg-info" style="width: <?= esc($role->progress_percentage) ?>%;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <p class="text-muted mb-0 py-3 text-center">Belum ada role aktif yang diikuti untuk ditampilkan grafiknya.</p>
    <?php endif; ?>
</div>

<?php if (!empty($roles_aktif)): ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const labels = [<?= implode(',', array_map(fn($r) => "'" . esc($r->nama_role) . "'", $roles_aktif)) ?>];
        const dataValues = [<?= implode(',', array_map(fn($r) => $r->progress_percentage, $roles_aktif)) ?>];

        const ctx = document.getElementById('progressChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Progres Belajar (%)',
                    data: dataValues,
                    backgroundColor: 'rgba(0, 210, 255, 0.6)',
                    borderColor: 'rgba(0, 210, 255, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: { color: '#888', callback: value => value + '%' },
                        grid: { color: 'rgba(255, 255, 255, 0.05)' }
                    },
                    x: {
                        ticks: { color: '#fff' },
                        grid: { display: false }
                    }
                },
                plugins: { legend: { display: false } }
            }
        });
    });
</script>
<?php endif; ?>
<?= $this->endSection() ?>