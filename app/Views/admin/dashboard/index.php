<?= $this->extend('layouts/admin') ?> <!-- Sesuaikan nama layout admin kamu jika berbeda -->

<?= $this->section('content') ?>
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h1 class="fw-bold text-dark">Dashboard Statistik</h1>
    </div>
</div>

<!-- Cards Ringkasan Statistik -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="cl-card p-4 h-100 bg-white border rounded-3 shadow-sm text-center">
            <h6 class="text-primary text-uppercase small fw-bold mb-2">> TOTAL USER</h6>
            <h1 class="fw-bold text-primary mb-0"><?= esc($total_user) ?></h1>
        </div>
    </div>
    <div class="col-md-4">
        <div class="cl-card p-4 h-100 bg-white border rounded-3 shadow-sm text-center">
            <h6 class="text-primary text-uppercase small fw-bold mb-2">> QUIZ DIKERJAKAN</h6>
            <h1 class="fw-bold text-primary mb-0"><?= esc($total_quiz_dikerjakan) ?></h1>
        </div>
    </div>
    <div class="col-md-4">
        <div class="cl-card p-4 h-100 bg-white border rounded-3 shadow-sm text-center">
            <h6 class="text-primary text-uppercase small fw-bold mb-2">> RATA-RATA SIMILARITY</h6>
            <h1 class="fw-bold text-primary mb-0"><?= esc($rata_skor_similarity) ?>%</h1>
        </div>
    </div>
</div>

<!-- Visualisasi Grafis: Distribusi Role Terpopuler -->
<div class="row">
    <div class="col-12">
        <div class="cl-card p-4 bg-white border rounded-3 shadow-sm">
            <h6 class="text-primary text-uppercase small fw-bold mb-4">> DISTRIBUSI ROLE TERPOPULER</h6>
            
            <?php if (!empty($distribusi_role)): ?>
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div style="position: relative; height: 300px;">
                            <canvas id="adminDistribusiChart"></canvas>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <table class="table table-borderless align-middle mb-0">
                            <thead>
                                <tr class="border-bottom text-muted small">
                                    <th>Role Spesialisasi</th>
                                    <th class="text-end">Pengambil</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($distribusi_role as $row): ?>
                                    <tr class="border-bottom">
                                        <td class="fw-semibold text-dark"><?= esc($row['nama_role']) ?></td>
                                        <td class="text-end fw-bold text-primary"><?= esc($row['jumlah_user']) ?> User</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <p class="text-muted text-center py-4 mb-0">Belum ada data pengguna yang mengambil role.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Script Chart.js untuk Admin -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php if (!empty($distribusi_role)): ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const labels = [<?= implode(',', array_map(fn($r) => "'" . esc($r['nama_role']) . "'", $distribusi_role)) ?>];
        const dataValues = [<?= implode(',', array_map(fn($r) => $r['jumlah_user'], $distribusi_role)) ?>];

        const ctx = document.getElementById('adminDistribusiChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: dataValues,
                    backgroundColor: [
                        '#0d6efd',
                        '#198754',
                        '#ffc107',
                        '#dc3545',
                        '#0dcaf0'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    });
</script>
<?php endif; ?>
<?= $this->endSection() ?>