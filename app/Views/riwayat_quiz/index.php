<?= $this->extend('layouts/main') ?>
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
