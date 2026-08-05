<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Regulation;
use App\Models\RegulationRelation;

class RegulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Keuangan Daerah
        $keuangan = Regulation::create([
            'type' => 'Peraturan Daerah',
            'number' => '3',
            'year' => 2023,
            'title' => 'Peraturan Daerah Kabupaten Puncak Jaya Nomor 3 Tahun 2023 tentang Pengelolaan Keuangan Daerah',
            'stipulation_date' => '2023-05-10',
            'status' => 'active',
            'description' => 'Peraturan ini mengatur tentang asas umum, struktur APBD, penyusunan, pelaksanaan, penatausahaan, pertanggungjawaban, dan pengawasan keuangan daerah Kabupaten Puncak Jaya.',
            'file_path' => 'regulations/perda_3_2023.pdf',
            'teu' => 'Bupati Puncak Jaya',
            'law_field' => 'Hukum Keuangan Daerah',
            'subject' => 'Keuangan Daerah, APBD, Pengelolaan Keuangan',
        ]);

        // 2. Ketertiban Umum (Old)
        $tibumOld = Regulation::create([
            'type' => 'Peraturan Daerah (Perda) Kabupaten',
            'number' => '2',
            'year' => 2022,
            'title' => 'Peraturan Daerah Kabupaten Puncak Jaya Nomor 2 Tahun 2022 tentang Ketertiban Umum dan Ketentraman Masyarakat',
            'stipulation_date' => '2022-03-12',
            'status' => 'amended',
            'description' => 'Peraturan Daerah ini mengatur mengenai pedoman ketertiban sosial, lingkungan, jalan, angkutan, serta ketentraman masyarakat di wilayah Kabupaten Puncak Jaya.',
            'file_path' => 'regulations/perda_2_2022.pdf',
            'teu' => 'Bupati Puncak Jaya',
            'law_field' => 'Hukum Pemerintahan Umum',
            'subject' => 'Ketertiban Umum, Ketentraman, Ketertiban Sosial',
        ]);

        // 3. Ketertiban Umum (New) - Amending the old one
        $tibumNew = Regulation::create([
            'type' => 'Peraturan Daerah (Perda) Kabupaten',
            'number' => '5',
            'year' => 2024,
            'title' => 'Peraturan Daerah Kabupaten Puncak Jaya Nomor 5 Tahun 2024 tentang Perubahan atas Peraturan Daerah Nomor 2 Tahun 2022 tentang Ketertiban Umum dan Ketentraman Masyarakat',
            'stipulation_date' => '2024-08-20',
            'status' => 'active',
            'description' => 'Peraturan ini melakukan penyesuaian terhadap sanksi administratif dan pengawasan penegakan ketertiban umum di Kabupaten Puncak Jaya.',
            'file_path' => 'regulations/perda_5_2024.pdf',
            'teu' => 'Bupati Puncak Jaya',
            'law_field' => 'Hukum Pemerintahan Umum',
            'subject' => 'Perubahan Perda, Ketertiban Umum, Sanksi Administratif',
        ]);

        // Create relationship: new amends old, old amended by new
        RegulationRelation::create([
            'relation_type' => 'amends',
            'regulation_id' => $tibumNew->id,
            'related_regulation_id' => $tibumOld->id,
        ]);
        RegulationRelation::create([
            'relation_type' => 'amended_by',
            'regulation_id' => $tibumOld->id,
            'related_regulation_id' => $tibumNew->id,
        ]);

        // 4. RKPD 2021 (Revoked)
        $rkpdOld = Regulation::create([
            'type' => 'Peraturan Bupati (Perbup)',
            'number' => '15',
            'year' => 2021,
            'title' => 'Peraturan Bupati Puncak Jaya Nomor 15 Tahun 2021 tentang Rencana Kerja Pemerintah Daerah Tahun Anggaran 2022',
            'stipulation_date' => '2021-09-05',
            'status' => 'revoked',
            'description' => 'Mengatur rencana kerja program pembangunan daerah jangka pendek untuk tahun anggaran 2022.',
            'file_path' => 'regulations/perbup_15_2021.pdf',
            'teu' => 'Bupati Puncak Jaya',
            'law_field' => 'Hukum Perencanaan Daerah',
            'subject' => 'RKPD, Pembangunan Daerah, Rencana Kerja',
        ]);

        // 5. Pencabutan RKPD 2021
        $rkpdNew = Regulation::create([
            'type' => 'Peraturan Bupati (Perbup)',
            'number' => '10',
            'year' => 2024,
            'title' => 'Peraturan Bupati Puncak Jaya Nomor 10 Tahun 2024 tentang Pencabutan Peraturan Bupati Nomor 15 Tahun 2021',
            'stipulation_date' => '2024-11-12',
            'status' => 'active',
            'description' => 'Menyatakan Peraturan Bupati Puncak Jaya Nomor 15 Tahun 2021 tentang Rencana Kerja Pemerintah Daerah tidak berlaku lagi.',
            'file_path' => 'regulations/perbup_10_2024.pdf',
            'teu' => 'Bupati Puncak Jaya',
            'law_field' => 'Hukum Perencanaan Daerah',
            'subject' => 'Pencabutan, RKPD, Pembatalan Perbup',
        ]);

        // Create relationship: new revokes old, old revoked by new
        RegulationRelation::create([
            'relation_type' => 'revokes',
            'regulation_id' => $rkpdNew->id,
            'related_regulation_id' => $rkpdOld->id,
        ]);
        RegulationRelation::create([
            'relation_type' => 'revoked_by',
            'regulation_id' => $rkpdOld->id,
            'related_regulation_id' => $rkpdNew->id,
        ]);

        // 6. Pajak & Retribusi
        Regulation::create([
            'type' => 'Peraturan Daerah (Perda) Kabupaten',
            'number' => '1',
            'year' => 2025,
            'title' => 'Peraturan Daerah Kabupaten Puncak Jaya Nomor 1 Tahun 2025 tentang Pajak Daerah dan Retribusi Daerah',
            'stipulation_date' => '2025-01-05',
            'status' => 'active',
            'description' => 'Perda payung hukum terbaru yang menyatukan seluruh jenis pajak daerah dan retribusi daerah di Kabupaten Puncak Jaya berdasarkan UU No 1 Tahun 2022.',
            'file_path' => 'regulations/perda_1_2025.pdf',
            'teu' => 'Bupati Puncak Jaya',
            'law_field' => 'Hukum Pajak dan Retribusi',
            'subject' => 'Pajak Daerah, Retribusi Daerah, PAD',
        ]);

        // 7. Keputusan Bupati tentang JDIH
        Regulation::create([
            'type' => 'Keputusan Bupati (Kepbup)',
            'number' => '45',
            'year' => 2025,
            'title' => 'Keputusan Bupati Puncak Jaya Nomor 45 Tahun 2025 tentang Pembentukan Pengelola Jaringan Dokumentasi dan Informasi Hukum (JDIH) Kabupaten Puncak Jaya',
            'stipulation_date' => '2025-04-18',
            'status' => 'active',
            'description' => 'Menetapkan tim pengelola, tugas pokok, susunan organisasi, dan pembiayaan untuk pusat dokumentasi hukum JDIH di lingkungan Pemerintah Daerah Kabupaten Puncak Jaya.',
            'file_path' => 'regulations/kepbup_45_2025.pdf',
            'teu' => 'Bupati Puncak Jaya',
            'law_field' => 'Hukum Kelembagaan & Organisasi',
            'subject' => 'Pengelola JDIH, Organisasi, Publikasi Hukum',
        ]);

        // 8. Peraturan Kepala Daerah (PERKADA)
        Regulation::create([
            'type' => 'Peraturan Bupati (Perbup)',
            'number' => '12',
            'year' => 2025,
            'title' => 'Peraturan Kepala Daerah Kabupaten Puncak Jaya Nomor 12 Tahun 2025 tentang Kebijakan Sistem Keamanan Informasi Pemerintah Daerah',
            'stipulation_date' => '2025-06-20',
            'status' => 'active',
            'description' => 'Mengatur tata kelola dan standar keamanan teknologi informasi pada seluruh Satuan Kerja Perangkat Daerah (SKPD) Kabupaten Puncak Jaya.',
            'file_path' => 'regulations/perkada_12_2025.pdf',
            'teu' => 'Bupati Puncak Jaya',
            'law_field' => 'Hukum Komunikasi & Informatika',
            'subject' => 'Keamanan Informasi, Sandi Daerah, IT Pemerintah',
        ]);

        // 9. Instruksi Bupati
        Regulation::create([
            'type' => 'Instruksi Bupati (Inbup)',
            'number' => '2',
            'year' => 2026,
            'title' => 'Instruksi Bupati Puncak Jaya Nomor 2 Tahun 2026 tentang Percepatan Pembangunan Infrastruktur Telekomunikasi Wilayah Pedalaman',
            'stipulation_date' => '2026-02-15',
            'status' => 'active',
            'description' => 'Instruksi langsung kepada Kepala Dinas Pekerjaan Umum dan Kepala Dinas Kominfo untuk melakukan monitoring serta percepatan pembangunan BTS di wilayah Puncak Jaya.',
            'file_path' => 'regulations/insbup_2_2026.pdf',
            'teu' => 'Bupati Puncak Jaya',
            'law_field' => 'Hukum Pembangunan & Wilayah',
            'subject' => 'Instruksi Bupati, Pembangunan BTS, Telekomunikasi',
        ]);

        // 10. Surat Edaran
        Regulation::create([
            'type' => 'Surat Edaran (SE)',
            'number' => '5',
            'year' => 2026,
            'title' => 'Surat Edaran Bupati Puncak Jaya Nomor 5 Tahun 2026 tentang Himbauan Penerapan Disiplin Kerja dan Jam Kerja ASN Selama Bulan Ramadhan',
            'stipulation_date' => '2026-03-01',
            'status' => 'active',
            'description' => 'Mengatur penyesuaian jam kerja Aparatur Sipil Negara (ASN) dan PPPK di lingkungan Pemerintah Daerah Kabupaten Puncak Jaya.',
            'file_path' => 'regulations/se_5_2026.pdf',
            'teu' => 'Bupati Puncak Jaya',
            'law_field' => 'Hukum Kepegawaian',
            'subject' => 'Surat Edaran, Jam Kerja ASN, Ramadhan',
        ]);
    }
}
