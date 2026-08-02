<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex-between cl-mb-4">
    <h3>Kelola Bank Soal Quiz</h3>
    <button class="cl-btn cl-btn-primary" data-modal-open="modalTambah">+ Tambah Soal</button>
</div>

<p class="cl-text-muted cl-small cl-mb-4">
    Tiap soal wajib punya minimal 2 opsi jawaban (disarankan 5). Tiap jawaban bisa
    punya bobot ke lebih dari satu kategori sekaligus.
</p>

<?php $kategoriMap = array_column($kategori, 'nama_kategori', 'id'); ?>
<?php $kategoriJson = json_encode($kategori); ?>

<div class="cl-card">
    <table class="data-table">
        <thead>
            <tr><th>Pertanyaan</th><th>Jumlah Jawaban</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            <?php foreach ($soal as $s): ?>
                <tr>
                    <td><?= esc($s['pertanyaan']) ?></td>
                    <td><span class="cl-badge badge-gray"><?= count($s['jawaban']) ?> opsi</span></td>
                    <td>
                        <button class="cl-btn cl-btn-sm btn-outline" data-modal-open="modalEdit<?= esc($s['id'], 'attr') ?>">Edit</button>
                        <a href="<?= base_url('admin/quiz/delete/' . esc($s['id'], 'attr')) ?>"
                           class="cl-btn cl-btn-sm btn-danger-outline"
                           onclick="return confirm('Hapus soal ini beserta semua jawabannya?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($soal)): ?>
                <tr><td colspan="3" class="cl-text-center cl-text-muted" style="padding:32px;">Belum ada soal quiz.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah -->
<div class="modal-overlay" id="modalTambah">
    <div class="modal-box modal-lg">
        <form action="<?= base_url('admin/quiz/store') ?>" method="post" class="form-quiz-dinamis" data-kategori='<?= $kategoriJson ?>'>
            <?= csrf_field() ?>
            <div class="cl-modal-header">
                <h4 style="margin:0;">Tambah Soal Quiz</h4>
                <button type="button" class="modal-close" data-modal-close>&times;</button>
            </div>
            <div class="cl-modal-body">
                <div class="form-group">
                    <label class="cl-form-label">Pertanyaan</label>
                    <textarea name="pertanyaan" class="cl-form-control" rows="2" required maxlength="500"
                              placeholder="mis. Saya senang mencari celah keamanan dalam sebuah sistem."></textarea>
                </div>
                <label class="cl-form-label">Opsi Jawaban</label>
                <div class="jawaban-container"></div>
                <button type="button" class="cl-btn cl-btn-sm btn-outline btn-tambah-jawaban" style="margin-top:8px;">+ Tambah Opsi Jawaban</button>
            </div>
            <div class="cl-modal-footer">
                <button type="submit" class="cl-btn cl-btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit per soal -->
<?php foreach ($soal as $s): ?>
<div class="modal-overlay" id="modalEdit<?= esc($s['id'], 'attr') ?>">
    <div class="modal-box modal-lg">
        <form action="<?= base_url('admin/quiz/update/' . esc($s['id'], 'attr')) ?>" method="post"
              class="form-quiz-dinamis" data-kategori='<?= $kategoriJson ?>'>
            <?= csrf_field() ?>
            <div class="cl-modal-header">
                <h4 style="margin:0;">Edit Soal</h4>
                <button type="button" class="modal-close" data-modal-close>&times;</button>
            </div>
            <div class="cl-modal-body">
                <div class="form-group">
                    <label class="cl-form-label">Pertanyaan</label>
                    <textarea name="pertanyaan" class="cl-form-control" rows="2" required maxlength="500"><?= esc($s['pertanyaan']) ?></textarea>
                </div>
                <label class="cl-form-label">Opsi Jawaban</label>
                <div class="jawaban-container" data-existing='<?= json_encode($s['jawaban']) ?>'></div>
                <button type="button" class="cl-btn cl-btn-sm btn-outline btn-tambah-jawaban" style="margin-top:8px;">+ Tambah Opsi Jawaban</button>
            </div>
            <div class="cl-modal-footer">
                <button type="submit" class="cl-btn cl-btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<?php endforeach; ?>

<style>
    .jawaban-block { border: 1px solid var(--border); border-radius: var(--radius); padding: 12px; margin-bottom: 10px; }
    .bobot-row { display: flex; gap: 8px; margin-bottom: 6px; align-items: center; }
    .bobot-row select, .bobot-row input { flex: 1; }
</style>

<script>
/**
 * Form dinamis: tiap .form-quiz-dinamis punya container .jawaban-container.
 * Field name pattern: jawaban[i][teks], jawaban[i][kategori_id][], jawaban[i][bobot][]
 * Cocok dengan parsing nested array di Admin/QuizController::validateAndParse().
 */
function buatOpsiKategori(kategoriList, selectedId = '') {
    return kategoriList.map(k =>
        `<option value="${k.id}" ${String(k.id) === String(selectedId) ? 'selected' : ''}>${k.nama_kategori}</option>`
    ).join('');
}

function buatBarisBobot(kategoriList, kategoriId = '', bobot = '') {
    const div = document.createElement('div');
    div.className = 'bobot-row';
    div.innerHTML = `
        <select class="cl-form-control" name="__KATEGORI__" required>
            <option value="">-- Kategori --</option>
            ${buatOpsiKategori(kategoriList, kategoriId)}
        </select>
        <input type="number" class="cl-form-control" name="__BOBOT__" step="0.01" min="0" max="1"
               value="${bobot}" placeholder="0.00-1.00" required style="max-width:110px;">
        <button type="button" class="cl-btn cl-btn-sm btn-danger-outline btn-hapus-bobot">✕</button>
    `;
    return div;
}

function buatBlokJawaban(kategoriList, jawabanIndex, teks = '', bobotKategori = {}) {
    const block = document.createElement('div');
    block.className = 'jawaban-block';
    block.dataset.index = jawabanIndex;
    block.innerHTML = `
        <div class="flex-between cl-mb-2">
            <span class="eyebrow">opsi ${String.fromCharCode(65 + jawabanIndex)}</span>
            <button type="button" class="cl-btn cl-btn-sm btn-danger-outline btn-hapus-jawaban">Hapus Opsi</button>
        </div>
        <div class="form-group">
            <input type="text" class="cl-form-control" placeholder="Teks jawaban" required
                   name="jawaban[${jawabanIndex}][teks]" value="${teks}">
        </div>
        <div class="bobot-container"></div>
        <button type="button" class="cl-btn cl-btn-sm btn-outline btn-tambah-bobot">+ Tambah Bobot Kategori</button>
    `;

    const bobotContainer = block.querySelector('.bobot-container');
    const entries = Object.keys(bobotKategori);
    if (entries.length === 0) {
        bobotContainer.appendChild(buatBarisBobot(kategoriList));
    } else {
        entries.forEach(katId => bobotContainer.appendChild(buatBarisBobot(kategoriList, katId, bobotKategori[katId])));
    }

    // Set nama field yang benar untuk tiap baris bobot yang sudah ada
    bobotContainer.querySelectorAll('.bobot-row').forEach(row => {
        row.querySelector('select').name = `jawaban[${jawabanIndex}][kategori_id][]`;
        row.querySelector('input[type=number]').name = `jawaban[${jawabanIndex}][bobot][]`;
    });

    return block;
}

function reindexJawaban(container) {
    container.querySelectorAll('.jawaban-block').forEach((block, i) => {
        block.dataset.index = i;
        block.querySelector('.eyebrow').textContent = 'opsi ' + String.fromCharCode(65 + i);
        block.querySelector('input[type=text]').name = `jawaban[${i}][teks]`;
        block.querySelectorAll('.bobot-row select').forEach(s => s.name = `jawaban[${i}][kategori_id][]`);
        block.querySelectorAll('.bobot-row input[type=number]').forEach(inp => inp.name = `jawaban[${i}][bobot][]`);
    });
}

document.querySelectorAll('.form-quiz-dinamis').forEach(form => {
    const kategoriList = JSON.parse(form.dataset.kategori);
    const container = form.querySelector('.jawaban-container');

    // Mode edit: render jawaban yang sudah ada
    if (container.dataset.existing) {
        const existing = JSON.parse(container.dataset.existing);
        existing.forEach((j, i) => container.appendChild(buatBlokJawaban(kategoriList, i, j.teks_jawaban, j.bobot_kategori)));
    } else {
        // Mode tambah: mulai dengan 2 opsi kosong (A, B) sebagai starting point
        container.appendChild(buatBlokJawaban(kategoriList, 0));
        container.appendChild(buatBlokJawaban(kategoriList, 1));
    }

    form.querySelector('.btn-tambah-jawaban').addEventListener('click', () => {
        const nextIndex = container.querySelectorAll('.jawaban-block').length;
        container.appendChild(buatBlokJawaban(kategoriList, nextIndex));
    });

    container.addEventListener('click', (e) => {
        if (e.target.classList.contains('btn-tambah-bobot')) {
            e.target.closest('.jawaban-block').querySelector('.bobot-container').appendChild(buatBarisBobot(kategoriList));
            reindexJawaban(container);
        }
        if (e.target.classList.contains('btn-hapus-bobot')) {
            const bobotContainer = e.target.closest('.bobot-container');
            if (bobotContainer.querySelectorAll('.bobot-row').length > 1) {
                e.target.closest('.bobot-row').remove();
            }
        }
        if (e.target.classList.contains('btn-hapus-jawaban')) {
            if (container.querySelectorAll('.jawaban-block').length > 2) {
                e.target.closest('.jawaban-block').remove();
                reindexJawaban(container);
            } else {
                alert('Minimal 2 opsi jawaban diperlukan.');
            }
        }
    });
});
</script>

<?= $this->endSection() ?>
