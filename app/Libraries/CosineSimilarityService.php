<?php

namespace App\Libraries;

/**
 * Modul komputasi inti: menghitung kemiripan (similarity) antara vektor minat
 * user (hasil quiz) dengan vektor profil ideal tiap role, menggunakan Cosine Similarity.
 *
 * similarity = (A . B) / (||A|| * ||B||)
 *
 * CATATAN METODOLOGIS (wajib dicantumkan di laporan BAB V):
 * Cosine similarity hanya sensitif terhadap ARAH vektor, bukan magnitude-nya.
 * Skema quiz saat ini: multiple choice (1 soal = 5 opsi jawaban), tiap opsi
 * punya bobot ke satu/lebih kategori. Karena user hanya memilih SATU opsi per
 * soal (bukan skala Likert), rentang skor per kategori jauh lebih bergantung
 * pada seberapa seimbang bobot antar opsi jawaban dirancang admin - opsi
 * jawaban yang bobotnya jomplang (misal satu opsi 0.9 sementara opsi lain 0.1)
 * akan mendominasi hasil rekomendasi. Bobot kategori-jawaban pada sistem ini
 * ditentukan berdasarkan expert judgment tim, BUKAN hasil validasi psikometri
 * formal (mis. uji reliabilitas Cronbach's Alpha).
 */
class CosineSimilarityService
{
    /**
     * Hitung cosine similarity antara dua vektor (format: [kategori_id => nilai]).
     */
    public function calculate(array $vectorA, array $vectorB): float
    {
        $dotProduct = 0.0;
        $normA = 0.0;
        $normB = 0.0;

        foreach ($vectorA as $kategoriId => $nilai) {
            $nilaiB = $vectorB[$kategoriId] ?? 0.0;
            $dotProduct += $nilai * $nilaiB;
            $normA += $nilai ** 2;
        }
        foreach ($vectorB as $nilai) {
            $normB += $nilai ** 2;
        }

        // Hindari division by zero: terjadi jika user skip semua soal,
        // atau role belum diisi bobot kategori sama sekali oleh admin.
        if ($normA <= 0.0 || $normB <= 0.0) {
            return 0.0;
        }

        return $dotProduct / (sqrt($normA) * sqrt($normB));
    }

    /**
     * Hitung vektor profil user dari jawaban quiz TERPILIH (multiple choice,
     * bukan lagi skala Likert). Tiap soal user pilih 1 dari 5 jawaban;
     * bobot kategori jawaban yang dipilih langsung dijumlahkan ke vektor user.
     *
     * @param array $jawabanTerpilih  [quiz_id => jawaban_id yang dipilih user]
     * @param array $soalDenganJawaban Hasil dari QuizPenentuanRoleModel::getAllWithJawaban()
     * @return array [kategori_id => skor_terkumpul]
     */
    public function buildUserVector(array $jawabanTerpilih, array $soalDenganJawaban): array
    {
        $vector = [];

        foreach ($soalDenganJawaban as $soal) {
            $jawabanIdTerpilih = $jawabanTerpilih[$soal['id']] ?? null;
            if ($jawabanIdTerpilih === null) {
                continue; // soal tidak dijawab, tidak berkontribusi ke vektor
            }

            foreach ($soal['jawaban'] as $opsi) {
                if ((int) $opsi['id'] !== (int) $jawabanIdTerpilih) {
                    continue;
                }
                foreach ($opsi['bobot_kategori'] as $kategoriId => $bobot) {
                    $vector[$kategoriId] = ($vector[$kategoriId] ?? 0) + $bobot;
                }
            }
        }

        return $vector;
    }

    /**
     * Ranking semua role berdasarkan similarity terhadap vektor user.
     * Return: [role_id => similarity_score, ...] terurut dari tertinggi.
     */
    public function rankRoles(array $vectorUser, array $allRoleVectors): array
    {
        $results = [];
        foreach ($allRoleVectors as $roleId => $vectorRole) {
            $results[$roleId] = $this->calculate($vectorUser, $vectorRole);
        }
        arsort($results);
        return $results;
    }
}
