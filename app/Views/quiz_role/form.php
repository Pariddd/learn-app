<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-dark">Quiz Penentuan Role Spesialisasi</h2>
                <p class="text-muted">Isi pertanyaan berikut secara jujur untuk mengetahui jalur karir dan role spesialisasi yang paling cocok dengan minat kamu.</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger border-0 shadow-sm mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($soal)): ?>
                <!-- Action disesuaikan ke quiz-role/submit -->
                <form action="<?= site_url('quiz-role/submit') ?>" method="post">
                    <?= csrf_field() ?>

                    <?php $no = 1; foreach ($soal as $s): ?>
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold text-primary mb-3">
                                    <span class="badge bg-primary me-2"><?= $no ?></span>
                                    <?= esc($s['pertanyaan']) ?>
                                </h6>

                                <div class="d-flex flex-column gap-2 ms-2">
                                    <?php if (!empty($s['jawaban'])): ?>
                                        <?php foreach ($s['jawaban'] as $j): ?>
                                            <div class="form-check p-3 border rounded">
                                                <input class="form-check-input ms-0 me-3" 
                                                       type="radio" 
                                                       name="jawaban[<?= $s['id'] ?>]" 
                                                       id="jawaban_<?= $s['id'] ?>_<?= $j['id'] ?>" 
                                                       value="<?= $j['id'] ?>" 
                                                       required>
                                                <label class="form-check-label w-100 text-dark fw-medium" for="jawaban_<?= $s['id'] ?>_<?= $j['id'] ?>" style="cursor: pointer;">
                                                    <?= esc($j['teks_jawaban']) ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php $no++; endforeach; ?>

                    <div class="card border-0 shadow-sm mb-5">
                        <div class="card-body p-3 d-flex justify-content-between align-items-center">
                            <a href="<?= site_url('dashboard') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success fw-bold px-4">
                                <i class="bi bi-send me-1"></i> Submit Jawaban & Lihat Hasil
                            </button>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>