<?php

namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('users')->insertBatch([
            ['username' => 'admin', 'email' => 'admin@mail.com', 'password' => password_hash('admin1234', PASSWORD_DEFAULT), 'role' => 'admin', 'is_premium' => 0, 'created_at' => date('Y-m-d H:i:s')],
            ['username' => 'budi_santoso', 'email' => 'user1@mail.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'user', 'is_premium' => 0, 'created_at' => date('Y-m-d H:i:s')],
            ['username' => 'siti_rahma', 'email' => 'user2@mail.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'user', 'is_premium' => 1, 'created_at' => date('Y-m-d H:i:s')],
        ]);

        $this->db->table('kategori_minat')->insertBatch([
            ['nama_kategori' => 'Offensive'],
            ['nama_kategori' => 'Defensive'],
            ['nama_kategori' => 'Analytical'],
            ['nama_kategori' => 'Development'],
        ]);

        $this->db->table('roles_spesialisasi')->insertBatch([
            ['nama_role' => 'Security Analyst', 'deskripsi' => 'Fokus memantau, mendeteksi, dan merespons insiden keamanan secara real-time (SOC).', 'thumbnail' => null],
            ['nama_role' => 'Penetration Tester', 'deskripsi' => 'Fokus menemukan dan mengeksploitasi celah keamanan sebelum penyerang sungguhan melakukannya.', 'thumbnail' => null],
            ['nama_role' => 'Security Engineer', 'deskripsi' => 'Fokus membangun, mengonfigurasi, dan mengeraskan (hardening) infrastruktur keamanan sistem.', 'thumbnail' => null],
        ]);

        $this->db->table('role_kategori_bobot')->insertBatch([
            ['role_id' => 1, 'kategori_id' => 1, 'bobot' => 0.15],
            ['role_id' => 1, 'kategori_id' => 2, 'bobot' => 0.70],
            ['role_id' => 1, 'kategori_id' => 3, 'bobot' => 0.85],
            ['role_id' => 1, 'kategori_id' => 4, 'bobot' => 0.10],
            ['role_id' => 2, 'kategori_id' => 1, 'bobot' => 0.90],
            ['role_id' => 2, 'kategori_id' => 2, 'bobot' => 0.10],
            ['role_id' => 2, 'kategori_id' => 3, 'bobot' => 0.35],
            ['role_id' => 2, 'kategori_id' => 4, 'bobot' => 0.10],
            ['role_id' => 3, 'kategori_id' => 1, 'bobot' => 0.10],
            ['role_id' => 3, 'kategori_id' => 2, 'bobot' => 0.60],
            ['role_id' => 3, 'kategori_id' => 3, 'bobot' => 0.30],
            ['role_id' => 3, 'kategori_id' => 4, 'bobot' => 0.85],
        ]);

        $this->db->table('jenis_link')->insertBatch([
            ['nama_jenis' => 'Lab'],
            ['nama_jenis' => 'Artikel'],
            ['nama_jenis' => 'Tools'],
            ['nama_jenis' => 'Dokumentasi'],
        ]);


        $this->db->table('videos')->insertBatch([
            ['tipe' => 'basic', 'role_id' => null, 'judul' => 'Pengenalan Kali Linux', 'deskripsi' => 'Instalasi dan navigasi dasar Kali Linux.', 'thumbnail' => null, 'video_url' => 'https://www.youtube.com/embed/dummy1', 'durasi_detik' => 600, 'urutan' => 1],
            ['tipe' => 'basic', 'role_id' => null, 'judul' => 'Dasar Command Line', 'deskripsi' => 'Perintah dasar terminal Linux.', 'thumbnail' => null, 'video_url' => 'https://www.youtube.com/embed/dummy2', 'durasi_detik' => 540, 'urutan' => 2],
            ['tipe' => 'basic', 'role_id' => null, 'judul' => 'Dasar Jaringan Komputer', 'deskripsi' => 'TCP/IP, subnetting, dan routing dasar.', 'thumbnail' => null, 'video_url' => 'https://www.youtube.com/embed/dummy3', 'durasi_detik' => 720, 'urutan' => 3],

            ['tipe' => 'intermediate', 'role_id' => 1, 'judul' => 'Dasar SIEM dan Log Analysis', 'deskripsi' => null, 'thumbnail' => null, 'video_url' => 'https://www.youtube.com/embed/dummy4', 'durasi_detik' => 850, 'urutan' => 1],
            ['tipe' => 'intermediate', 'role_id' => 1, 'judul' => 'Incident Response Fundamentals', 'deskripsi' => null, 'thumbnail' => null, 'video_url' => 'https://www.youtube.com/embed/dummy5', 'durasi_detik' => 950, 'urutan' => 2],

            ['tipe' => 'intermediate', 'role_id' => 2, 'judul' => 'Pengenalan Nmap & Enumeration', 'deskripsi' => null, 'thumbnail' => null, 'video_url' => 'https://www.youtube.com/embed/dummy6', 'durasi_detik' => 900, 'urutan' => 1],
            ['tipe' => 'intermediate', 'role_id' => 2, 'judul' => 'Web Exploitation dengan Burp Suite', 'deskripsi' => null, 'thumbnail' => null, 'video_url' => 'https://www.youtube.com/embed/dummy7', 'durasi_detik' => 1100, 'urutan' => 2],

            ['tipe' => 'intermediate', 'role_id' => 3, 'judul' => 'Hardening Server Linux', 'deskripsi' => null, 'thumbnail' => null, 'video_url' => 'https://www.youtube.com/embed/dummy8', 'durasi_detik' => 890, 'urutan' => 1],
        ]);

        $pertanyaanList = [
            'Aspek apa dari keamanan siber (cyber security) yang paling menarik bagi Anda?',
            'Menurut Anda, apa kekuatan terbesar yang Anda miliki?',
            'Lingkungan kerja seperti apa yang paling sesuai untuk Anda?',
            'Bagaimana Anda menghadapi tantangan atau kegagalan?',
            'Menurut Anda, keterampilan apa yang paling penting dalam karier keamanan siber?',
            'Jika Anda dapat memiliki satu perangkat dari film mata-mata, perangkat apa yang akan Anda pilih?',
            'Skenario mana yang paling menantang dan menarik bagi Anda?',
            'Bagaimana pendapat Anda tentang bekerja secara kolaboratif dalam tim?',
            'Menurut Anda, apa aspek yang paling memuaskan dari karier di bidang keamanan siber?',
            'Bagaimana cara Anda belajar dan tetap mengikuti perkembangan di bidang keamanan siber?',
        ];

        $quizRows = array_map(fn($p) => ['pertanyaan' => $p], $pertanyaanList);
        $this->db->table('quiz_penentuan_role')->insertBatch($quizRows);
        $quizIds = array_column($this->db->table('quiz_penentuan_role')->select('id')->orderBy('id', 'ASC')->get()->getResultArray(), 'id');

        $soalJawaban = [
            [
                ['Mensimulasikan serangan dunia nyata untuk meningkatkan pertahanan sistem.', 'PT'],
                ['Merespons dan menangani insiden keamanan.', 'SA'],
                ['Menemukan serta mengeksploitasi kerentanan (vulnerability).', 'PT'],
                ['Membangun dan memelihara sistem yang aman.', 'SE'],
                ['Memantau dan menganalisis peristiwa keamanan secara real-time.', 'SA']
            ],
            [
                ['Mampu memecahkan masalah dan berpikir cepat dalam berbagai situasi.', 'SA'],
                ['Mampu merencanakan serta menyusun strategi untuk menghadapi skenario yang kompleks.', 'SE'],
                ['Mampu menganalisis data dan mengidentifikasi pola.', 'SA'],
                ['Senang bereksperimen dengan berbagai alat dan teknik.', 'PT'],
                ['Senang mempelajari teknologi baru serta menerapkan langkah-langkah keamanan.', 'SE']
            ],
            [
                ['Menyukai situasi bertekanan tinggi dan mampu menangani keadaan darurat.', 'SA'],
                ['Bekerja sama dalam tim untuk merancang dan menerapkan solusi keamanan.', 'SE'],
                ['Bekerja secara mandiri dalam tugas atau proyek tertentu.', 'PT'],
                ['Menjadi bagian dari tim yang melakukan pemantauan secara berkelanjutan.', 'SA'],
                ['Berpartisipasi dalam simulasi dan latihan yang menyerupai serangan nyata (adversarial simulation).', 'PT']
            ],
            [
                ['Tetap tenang dan mengikuti SOP (Standar Operasional Prosedur).', 'SA'],
                ['Menikmati tantangan serta mencari solusi yang kreatif.', 'PT'],
                ['Menganggap tantangan sebagai kesempatan untuk meningkatkan keterampilan dan teknik.', 'PT'],
                ['Tetap tenang di bawah tekanan dan fokus menyelesaikan masalah secara efisien.', 'SA'],
                ['Menganalisis situasi, mengambil pelajaran, lalu melakukan perbaikan untuk ke depannya.', 'SE']
            ],
            [
                ['Kemampuan berpikir kritis dan mengambil keputusan dengan cepat di bawah tekanan.', 'SA'],
                ['Pemahaman yang kuat tentang arsitektur jaringan dan sistem.', 'SE'],
                ['Kemampuan berpikir strategis serta memahami taktik yang digunakan oleh penyerang.', 'PT'],
                ['Kemampuan teknis dan pemahaman terhadap berbagai alat peretasan (hacking tools).', 'PT'],
                ['Ketelitian serta kemampuan mendeteksi anomali dari sejumlah besar data.', 'SA']
            ],
            [
                ['Implementation Wand: Cukup colokkan perangkat ini, lalu sistem keamanan terbaik akan diterapkan secara otomatis pada sistem Anda.', 'SE'],
                ['Reportinator: Mengambil snapshot dari sistem yang telah diuji keamanannya, kemudian menghasilkan laporan lengkap berdasarkan temuan yang diperoleh.', 'PT'],
                ['CyberLens: Memungkinkan Anda mengenali peringatan (alert) yang merupakan false positive secara langsung.', 'SA'],
                ['Trace2Face: Menampilkan jejak digital suatu insiden di seluruh sistem, membantu menelusuri lalu lintas jaringan dan log sistem hingga menemukan sumber serangan.', 'SA'],
                ['Rent-a-Brain: Memungkinkan Anda berpikir seperti kelompok APT (Advanced Persistent Threat) pilihan Anda, melihat sistem dari sudut pandang penyerang, serta memberikan saran langkah serangan berikutnya.', 'PT']
            ],
            [
                ['Tantangan seperti teka-teki yang melibatkan upaya menembus mekanisme keamanan.', 'PT'],
                ['Menganalisis data dan mengenali pola untuk mendeteksi anomali serta ancaman.', 'SA'],
                ['Menyelesaikan permasalahan kompleks terkait pembangunan sistem yang aman dan tangguh.', 'SE'],
                ['Mengelola krisis serta menangani insiden keamanan yang mendesak.', 'SA'],
                ['Menemukan celah dalam pertahanan tim dengan mensimulasikan tindakan seorang penyerang.', 'PT']
            ],
            [
                ['Lebih suka bekerja sama dalam tim untuk mencapai tujuan bersama.', 'SE'],
                ['Menikmati kerja tim, terutama saat merencanakan dan menjalankan simulasi serangan.', 'PT'],
                ['Lebih senang bekerja secara mandiri dalam menyelesaikan tugas atau proyek.', 'PT'],
                ['Berkembang dengan baik dalam lingkungan tim, terutama saat menghadapi situasi bertekanan tinggi.', 'SA'],
                ['Lebih menyukai kombinasi antara bekerja mandiri dan berkolaborasi dalam tim.', 'SE']
            ],
            [
                ['Tantangan dalam menguji dan mengalahkan mekanisme pertahanan sistem.', 'PT'],
                ['Memberikan perlindungan berkelanjutan melalui pemantauan dan analisis peristiwa keamanan.', 'SA'],
                ['Kepuasan karena berhasil menemukan kerentanan dan kelemahan yang kritis.', 'PT'],
                ['Memberikan dampak besar dengan menangani insiden serta pelanggaran keamanan.', 'SA'],
                ['Berkontribusi dalam membangun sistem yang aman untuk melindungi aset-aset penting.', 'SE']
            ],
            [
                ['Membaca blog atau artikel keamanan siber di sela-sela penanganan insiden maupun alert.', 'SA'],
                ['Mengikuti perkembangan terbaru melalui riset dan pelatihan.', 'SE'],
                ['Bereksperimen secara langsung dengan berbagai alat dan teknik baru.', 'PT'],
                ['Mengikuti latihan praktis serta simulasi untuk meningkatkan keterampilan.', 'PT'],
                ['Belajar dari insiden nyata dan menerapkan pelajaran yang diperoleh.', 'SA']
            ],
        ];

        $bobotTemplate = [
            'PT' => [1 => 0.85, 3 => 0.25],
            'SA' => [2 => 0.60, 3 => 0.75],
            'SE' => [2 => 0.55, 4 => 0.80],
        ];

        foreach ($soalJawaban as $i => $jawabanList) {
            $quizId = $quizIds[$i];
            foreach ($jawabanList as $urutan => $pair) {
                [$teks, $kelas] = $pair;
                $this->db->table('jawaban_quiz')->insert([
                    'quiz_id' => $quizId,
                    'teks_jawaban' => $teks,
                    'urutan' => $urutan + 1,
                ]);
                $jawabanId = $this->db->insertID();

                $bobotRows = [];
                foreach ($bobotTemplate[$kelas] as $kategoriId => $bobot) {
                    $bobotRows[] = ['jawaban_id' => $jawabanId, 'kategori_id' => $kategoriId, 'bobot' => $bobot];
                }
                $this->db->table('jawaban_kategori_bobot')->insertBatch($bobotRows);
            }
        }

        echo "Seeding selesai.\n";
    }
}
