<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php 
    // Ambil properti secara aman baik berupa Object maupun Array
    $roleNama = is_object($role) ? ($role->nama_role ?? 'Spesialisasi') : ($role['nama_role'] ?? 'Spesialisasi');
    $roleDeskripsi = is_object($role) ? ($role->deskripsi ?? '') : ($role['deskripsi'] ?? '');
    $roleId = is_object($role) ? ($role->id ?? 0) : ($role['id'] ?? 0);
?>

<div class="row justify-content-center">
    <div class="col-lg-9 text-center">
        <h1 class="fw-bold text-white mb-2">Hasil Rekomendasi Role</h1>
        <p class="text-muted mb-4">Hasil analisis algoritma <em>Cosine Similarity</em> terhadap pilihan jawabanmu.</p>

        <div class="cl-card p-4 p-md-5 mb-4">
            <h4 class="text-uppercase text-info small fw-bold mb-1">Rekomendasi Utama</h4>
            <!-- Memanggil variabel $roleNama secara aman -->
            <h2 class="fw-bold text-white mb-4"><?= esc($roleNama) ?></h2>

            <div class="row align-items-center">
                <div class="col-md-5 text-center mb-4 mb-md-0">
                    <div class="d-inline-block p-4 rounded-circle border border-info mb-3">
                        <span class="display-5 fw-bold text-info"><?= $skor_persen ?>%</span>
                        <small class="d-block text-muted">Kesesuaian (Match)</small>
                    </div>
                    <p class="text-muted small text-start"><?= esc($roleDeskripsi) ?></p>
                </div>

                <!-- FITUR GRAFIS: Radar Chart Match Role -->
                <div class="col-md-7">
                    <h6 class="fw-bold text-muted mb-3">🕸 Grafik Match Role Similarity</h6>
                    <div style="position: relative; height: 260px;">
                        <canvas id="radarChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-center mt-4 pt-3 border-top border-secondary">
                <a href="<?= site_url('quiz-role/mulai/' . $roleId) ?>" class="cl-btn">Mulai Belajar Role Ini</a>
                <a href="<?= site_url('role/jelajahi') ?>" class="cl-btn btn-outline">Jelajahi Role Lain</a>
            </div>
        </div>

        <a href="<?= site_url('dashboard') ?>" class="text-decoration-none text-muted">
            ← Kembali ke Dashboard
        </a>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('radarChart').getContext('2d');
        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['Offensive Security', 'Defensive Security', 'Network Security', 'Digital Forensics', 'Cloud Security'],
                datasets: [{
                    label: 'Match (%)',
                    data: [<?= $skor_persen ?>, 45, 60, 30, 50],
                    backgroundColor: 'rgba(0, 210, 255, 0.2)',
                    borderColor: 'rgba(0, 210, 255, 1)',
                    pointBackgroundColor: 'rgba(0, 210, 255, 1)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        angleLines: { color: 'rgba(255, 255, 255, 0.1)' },
                        grid: { color: 'rgba(255, 255, 255, 0.1)' },
                        pointLabels: { color: '#ccc' },
                        ticks: { backdropColor: 'transparent', color: '#888' },
                        suggestedMin: 0,
                        suggestedMax: 100
                    }
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>