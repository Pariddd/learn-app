<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h3 class="cl-mb-4">Dashboard Statistik</h3>

<div class="grid grid-3 cl-mb-4">
    <div class="cl-card card-pad cl-text-center">
        <p class="eyebrow cl-mb-2">total user</p>
        <h2 style="color: var(--blue-600);"><?= esc($total_user) ?></h2>
    </div>
    <div class="cl-card card-pad cl-text-center">
        <p class="eyebrow cl-mb-2">quiz dikerjakan</p>
        <h2 style="color: var(--blue-600);"><?= esc($total_quiz_dikerjakan) ?></h2>
    </div>
    <div class="cl-card card-pad cl-text-center">
        <p class="eyebrow cl-mb-2">rata-rata similarity</p>
        <h2 style="color: var(--blue-600);"><?= esc($rata_skor_similarity) ?>%</h2>
    </div>
</div>

<div class="cl-card card-pad">
    <p class="eyebrow cl-mb-3">distribusi role terpopuler</p>
    <canvas id="chartDistribusiRole" height="100"></canvas>
</div>

<script src="<?= base_url('assets/js/vendor/chart.umd.js') ?>"></script>
<script>
    const dataDistribusi = <?= json_encode($distribusi_role) ?>;
    new Chart(document.getElementById('chartDistribusiRole'), {
        type: 'bar',
        data: {
            labels: dataDistribusi.map(d => d.nama_role),
            datasets: [{
                data: dataDistribusi.map(d => parseInt(d.jumlah_user, 10)),
                backgroundColor: '#2563eb',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#5b6b82'
                    },
                    grid: {
                        color: '#eef4ff'
                    }
                },
                y: {
                    ticks: {
                        color: '#5b6b82',
                        stepSize: 1
                    },
                    grid: {
                        color: '#eef4ff'
                    },
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?= $this->endSection() ?>