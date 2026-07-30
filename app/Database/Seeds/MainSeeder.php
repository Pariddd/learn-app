<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        // ==== USERS ====
        $this->db->table('users')->insertBatch([
            ['username' => 'admin', 'email' => 'admin@cyberlearn.test', 'password' => password_hash('admin1234', PASSWORD_DEFAULT), 'role' => 'admin', 'is_premium' => 0, 'created_at' => date('Y-m-d H:i:s')],
            ['username' => 'budi_santoso', 'email' => 'budi@test.test', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'user', 'is_premium' => 0, 'created_at' => date('Y-m-d H:i:s')],
            ['username' => 'siti_rahma', 'email' => 'siti@test.test', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'user', 'is_premium' => 1, 'created_at' => date('Y-m-d H:i:s')],
        ]);

        // ==== KATEGORI MINAT ====
        $this->db->table('kategori_minat')->insertBatch([
            ['nama_kategori' => 'Offensive'],
            ['nama_kategori' => 'Defensive'],
            ['nama_kategori' => 'Analytical'],
            ['nama_kategori' => 'Development'],
        ]);

        // ==== ROLES SPESIALISASI ====
        $this->db->table('roles_spesialisasi')->insertBatch([
            ['nama_role' => 'Red Team / Penetration Tester', 'deskripsi' => 'Fokus menemukan celah keamanan sebelum penyerang sungguhan melakukannya.', 'thumbnail' => null],
            ['nama_role' => 'Blue Team / SOC Analyst', 'deskripsi' => 'Fokus memantau, mendeteksi, dan merespons insiden keamanan secara real-time.', 'thumbnail' => null],
            ['nama_role' => 'Digital Forensic Analyst', 'deskripsi' => 'Fokus investigasi pasca-insiden dan analisis bukti digital.', 'thumbnail' => null],
            ['nama_role' => 'Malware Reverse Engineer', 'deskripsi' => 'Fokus membedah cara kerja malware melalui static & dynamic analysis.', 'thumbnail' => null],
            ['nama_role' => 'Security Engineer', 'deskripsi' => 'Fokus membangun dan mengeraskan (hardening) infrastruktur keamanan sistem.', 'thumbnail' => null],
        ]);

        // ==== ROLE-KATEGORI BOBOT (vektor profil ideal role) ====
        // role_id: 1=Red Team, 2=Blue Team, 3=Forensic, 4=RE, 5=Sec Engineer
        // kategori_id: 1=Offensive, 2=Defensive, 3=Analytical, 4=Development
        $this->db->table('role_kategori_bobot')->insertBatch([
            ['role_id' => 1, 'kategori_id' => 1, 'bobot' => 0.90],
            ['role_id' => 1, 'kategori_id' => 2, 'bobot' => 0.10],
            ['role_id' => 1, 'kategori_id' => 3, 'bobot' => 0.30],
            ['role_id' => 2, 'kategori_id' => 1, 'bobot' => 0.10],
            ['role_id' => 2, 'kategori_id' => 2, 'bobot' => 0.90],
            ['role_id' => 2, 'kategori_id' => 3, 'bobot' => 0.50],
            ['role_id' => 3, 'kategori_id' => 2, 'bobot' => 0.40],
            ['role_id' => 3, 'kategori_id' => 3, 'bobot' => 0.90],
            ['role_id' => 4, 'kategori_id' => 3, 'bobot' => 0.70],
            ['role_id' => 4, 'kategori_id' => 4, 'bobot' => 0.80],
            ['role_id' => 5, 'kategori_id' => 2, 'bobot' => 0.60],
            ['role_id' => 5, 'kategori_id' => 4, 'bobot' => 0.70],
        ]);

        // ==== JENIS LINK ====
        $this->db->table('jenis_link')->insertBatch([
            ['nama_jenis' => 'Lab'],
            ['nama_jenis' => 'Artikel'],
            ['nama_jenis' => 'Tools'],
            ['nama_jenis' => 'Dokumentasi'],
        ]);

        // ==== VIDEOS (basic + intermediate) ====
        $this->db->table('videos')->insertBatch([
            ['tipe' => 'basic', 'role_id' => null, 'judul' => 'Pengenalan Kali Linux', 'deskripsi' => 'Instalasi dan navigasi dasar Kali Linux.', 'thumbnail' => null, 'video_url' => 'https://www.youtube.com/embed/dummy1', 'durasi_detik' => 600, 'urutan' => 1],
            ['tipe' => 'basic', 'role_id' => null, 'judul' => 'Dasar Command Line', 'deskripsi' => 'Perintah dasar terminal Linux.', 'thumbnail' => null, 'video_url' => 'https://www.youtube.com/embed/dummy2', 'durasi_detik' => 540, 'urutan' => 2],
            ['tipe' => 'basic', 'role_id' => null, 'judul' => 'Dasar Jaringan Komputer', 'deskripsi' => 'TCP/IP, subnetting, dan routing dasar.', 'thumbnail' => null, 'video_url' => 'https://www.youtube.com/embed/dummy3', 'durasi_detik' => 720, 'urutan' => 3],
            ['tipe' => 'intermediate', 'role_id' => 1, 'judul' => 'Pengenalan Nmap & Enumeration', 'deskripsi' => null, 'thumbnail' => null, 'video_url' => 'https://www.youtube.com/embed/dummy4', 'durasi_detik' => 900, 'urutan' => 1],
            ['tipe' => 'intermediate', 'role_id' => 1, 'judul' => 'Web Exploitation dengan Burp Suite', 'deskripsi' => null, 'thumbnail' => null, 'video_url' => 'https://www.youtube.com/embed/dummy5', 'durasi_detik' => 1100, 'urutan' => 2],
            ['tipe' => 'intermediate', 'role_id' => 2, 'judul' => 'Dasar SIEM dan Log Analysis', 'deskripsi' => null, 'thumbnail' => null, 'video_url' => 'https://www.youtube.com/embed/dummy6', 'durasi_detik' => 850, 'urutan' => 1],
            ['tipe' => 'intermediate', 'role_id' => 2, 'judul' => 'Incident Response Fundamentals', 'deskripsi' => null, 'thumbnail' => null, 'video_url' => 'https://www.youtube.com/embed/dummy7', 'durasi_detik' => 950, 'urutan' => 2],
            ['tipe' => 'intermediate', 'role_id' => 3, 'judul' => 'Disk Imaging dan Chain of Custody', 'deskripsi' => null, 'thumbnail' => null, 'video_url' => 'https://www.youtube.com/embed/dummy8', 'durasi_detik' => 1000, 'urutan' => 1],
            ['tipe' => 'intermediate', 'role_id' => 4, 'judul' => 'Static Analysis PE Header', 'deskripsi' => null, 'thumbnail' => null, 'video_url' => 'https://www.youtube.com/embed/dummy9', 'durasi_detik' => 1200, 'urutan' => 1],
            ['tipe' => 'intermediate', 'role_id' => 5, 'judul' => 'Hardening Server Linux', 'deskripsi' => null, 'thumbnail' => null, 'video_url' => 'https://www.youtube.com/embed/dummy10', 'durasi_detik' => 890, 'urutan' => 1],
        ]);

        // ==== QUIZ PENENTUAN ROLE (bank soal) ====
        $this->db->table('quiz_penentuan_role')->insertBatch([
            ['pertanyaan' => 'Saya senang mencari celah keamanan dalam sebuah sistem.'],
            ['pertanyaan' => 'Saya senang memantau log dan alert keamanan secara berkala.'],
            ['pertanyaan' => 'Saya tertarik menganalisis bukti digital pasca-insiden.'],
            ['pertanyaan' => 'Saya senang membedah cara kerja program/file yang mencurigakan.'],
            ['pertanyaan' => 'Saya senang membangun dan mengonfigurasi sistem keamanan infrastruktur.'],
            ['pertanyaan' => 'Saya lebih suka menyerang sistem daripada mempertahankannya.'],
        ]);

        // ==== QUIZ-KATEGORI BOBOT ====
        // quiz_id 1-6 sesuai urutan insert di atas
        $this->db->table('quiz_kategori_bobot')->insertBatch([
            ['quiz_id' => 1, 'kategori_id' => 1, 'bobot' => 0.90],
            ['quiz_id' => 2, 'kategori_id' => 2, 'bobot' => 0.85],
            ['quiz_id' => 3, 'kategori_id' => 3, 'bobot' => 0.90],
            ['quiz_id' => 4, 'kategori_id' => 3, 'bobot' => 0.60],
            ['quiz_id' => 4, 'kategori_id' => 4, 'bobot' => 0.70],
            ['quiz_id' => 5, 'kategori_id' => 4, 'bobot' => 0.70],
            ['quiz_id' => 5, 'kategori_id' => 2, 'bobot' => 0.50],
            ['quiz_id' => 6, 'kategori_id' => 1, 'bobot' => 0.80],
        ]);

        echo "Seeding selesai.\n";
    }
}
