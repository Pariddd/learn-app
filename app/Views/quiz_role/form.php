<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div style="max-width: 680px; margin: 0 auto;">
    <p class="eyebrow cl-mb-2">quiz penentuan role</p>
    <h2 class="cl-mb-2">Temukan Role yang Cocok Untukmu</h2>
    <p class="cl-text-muted cl-mb-4">
        Pilih satu jawaban yang paling menggambarkan dirimu di tiap soal. Tidak ada jawaban benar/salah —
        hasilnya bisa kamu ulang kapan saja.
    </p>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="cl-alert cl-alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if (empty($soal)): ?>
        <div class="cl-card card-pad cl-text-center cl-text-muted">Belum ada soal quiz yang tersedia. Hubungi admin.</div>
    <?php else: ?>

    <form action="<?= base_url('quiz-role/submit') ?>" method="post">
        <?= csrf_field() ?>

        <?php foreach ($soal as $i => $item): ?>
            <div class="cl-card card-pad cl-mb-3">
                <p class="eyebrow cl-mb-2">soal <?= $i + 1 ?> / <?= count($soal) ?></p>
                <h4 style="margin-bottom: 14px;"><?= esc($item['pertanyaan']) ?></h4>

                <div style="display:flex; flex-direction:column; gap:8px;">
                    <?php foreach ($item['jawaban'] as $j => $opsi): ?>
                        <label class="quiz-option">
                            <input type="radio" name="jawaban[<?= esc($item['id'], 'attr') ?>]"
                                   value="<?= esc($opsi['id'], 'attr') ?>" required>
                            <span class="quiz-option-letter"><?= chr(65 + $j) ?></span>
                            <span><?= esc($opsi['teks_jawaban']) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <button type="submit" class="cl-btn cl-btn-primary cl-w-100" style="padding: 12px;">Lihat Hasil Rekomendasi</button>
    </form>

    <?php endif; ?>
</div>

<style>
    .quiz-option {
        display: flex; align-items: center; gap: 10px; padding: 12px 14px;
        border: 1px solid var(--border); border-radius: var(--radius); cursor: pointer;
        transition: border-color .15s ease, background-color .15s ease;
    }
    .quiz-option:hover { border-color: var(--blue-300); background: var(--blue-50); }
    .quiz-option input[type="radio"] { accent-color: var(--blue-500); }
    .quiz-option-letter {
        font-family: var(--font-mono); font-weight: 600; font-size: .8rem; color: var(--blue-500);
        border: 1px solid var(--blue-300); border-radius: 6px; width: 24px; height: 24px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .quiz-option:has(input:checked) { border-color: var(--blue-500); background: var(--blue-50); }
</style>

<?= $this->endSection() ?>
