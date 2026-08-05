<?php

namespace Database\Seeders;

use App\Models\Regulation;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BulkRegulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Peraturan Daerah',
            'Peraturan Bupati',
            'Peraturan Kepala Daerah',
            'Keputusan Bupati',
            'Instruksi Bupati',
            'Surat Edaran',
            'Peraturan Menteri Dalam Negeri',
            'Peraturan Menteri Keuangan'
        ];

        $subjects = [
            'Pajak Daerah, Retribusi, PAD',
            'Tata Ruang, Wilayah, RTRW',
            'Rencana Pembangunan, APBD, RKPD',
            'Kepegawaian, ASN, Disiplin',
            'Kesehatan, Sanitasi, RSUD',
            'Pendidikan, Beasiswa, Sekolah',
            'Pemberdayaan Kampung, Alokasi Dana Desa, ADD',
            'Ketertiban Umum, Satpol PP, Keamanan',
            'Lingkungan Hidup, Kehutanan, Sampah',
            'Transportasi, Perhubungan, Parkir'
        ];

        $titles = [
            'Rencana Kerja Pemerintah Daerah Kabupaten Puncak Jaya Tahun Anggaran ',
            'Pemberian Insentif dan Kemudahan Investasi Daerah di Kabupaten Puncak Jaya ',
            'Pengelolaan Keuangan dan Aset Kampung di Wilayah Distrik Mulia ',
            'Pedoman Pembentukan Rukun Tetangga dan Rukun Warga di Kabupaten Puncak Jaya ',
            'Penerapan Disiplin dan Penegakan Hukum Protokol Kesehatan Kerja ',
            'Tata Cara Pemilihan, Pengangkatan, dan Pemberhentian Kepala Kampung ',
            'Penyelenggaraan Bantuan Hukum bagi Masyarakat Miskin di Puncak Jaya ',
            'Rencana Tata Ruang Wilayah Terpadu Kabupaten Puncak Jaya Periode ',
            'Pedoman Pelaksanaan Anggaran Pendapatan dan Belanja Kampung Terintegrasi ',
            'Pengawasan Intern Penyelenggaraan Pemerintahan oleh Inspektorat Daerah '
        ];

        $this->command->info("Memulai pembuatan 100 data peraturan secara massal...");

        for ($i = 1; $i <= 100; $i++) {
            $type = $types[array_rand($types)];
            $year = rand(2020, 2026);
            $number = rand(1, 45);
            $subject = $subjects[array_rand($subjects)];
            $baseTitle = $titles[array_rand($titles)];
            
            $title = "{$baseTitle} Tahun {$year} (Nomor {$number})";
            $stipulationDate = Carbon::create($year, rand(1, 12), rand(1, 28))->format('Y-m-d');
            
            $statuses = ['active', 'active', 'active', 'amended', 'revoked'];
            $status = $statuses[array_rand($statuses)];

            Regulation::create([
                'type' => $type,
                'number' => $number,
                'year' => $year,
                'title' => $title,
                'stipulation_date' => $stipulationDate,
                'status' => $status,
                'teu' => ($type == 'Peraturan Menteri Dalam Negeri' || $type == 'Peraturan Menteri Keuangan') 
                    ? 'Kementerian Republik Indonesia' 
                    : 'Inspektorat Kabupaten Puncak Jaya',
                'law_field' => 'Hukum Administrasi Negara',
                'subject' => $subject,
                'description' => "Bahwa untuk melaksanakan ketentuan penyelenggaraan pemerintahan daerah yang transparan dan akuntabel di Kabupaten Puncak Jaya, perlu menetapkan {$title}.",
                'file_path' => null
            ]);
        }

        $this->command->info("Berhasil membuat 100 data peraturan massal!");
    }
}
