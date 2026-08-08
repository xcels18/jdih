<?php

namespace Database\Seeders;

use App\Models\Regulation;
use App\Models\RegulationRelation;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BulkRegulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean the database tables first
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('regulations')->truncate();
        DB::table('regulation_relations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $types = [
            'Peraturan Daerah (Perda) Kabupaten',
            'Peraturan Bupati (Perbup)',
            'Keputusan Bupati (Kepbup)',
            'Instruksi Bupati (Inbup)',
            'Surat Edaran (SE)',
            'Peraturan Kebijakan'
        ];

        $documentTypes = [
            'Peraturan Daerah (Perda) Kabupaten' => 'PERATURAN PERUNDANG-UNDANGAN DAERAH',
            'Peraturan Bupati (Perbup)' => 'PERATURAN BUPATI',
            'Keputusan Bupati (Kepbup)' => 'KEPUTUSAN BUPATI',
            'Instruksi Bupati (Inbup)' => 'INSTRUKSI BUPATI',
            'Surat Edaran (SE)' => 'SURAT EDARAN',
            'Peraturan Kebijakan' => 'PERATURAN KEBIJAKAN'
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
            'Transportasi, Perhubungan, Parkir',
            'Pariwisata, Kebudayaan, Daerah',
            'Investasi, Kemudahan Berusaha, Perizinan'
        ];

        $lawFields = [
            'Hukum Administrasi Negara',
            'Hukum Keuangan Daerah',
            'Hukum Tata Pemerintahan',
            'Hukum Kepegawaian',
            'Hukum Lingkungan',
            'Hukum Kesehatan',
            'Hukum Pajak dan Retribusi'
        ];

        $govAffairsList = [
            'Pemerintahan Umum & Keuangan Daerah',
            'Pembangunan Daerah & Tata Ruang',
            'Pendidikan & Kebudayaan',
            'Kesehatan & Kesejahteraan Rakyat',
            'Ketenteraman & Ketertiban Umum',
            'Pemberdayaan Masyarakat Kampung'
        ];

        $teus = [
            'Bupati Puncak Jaya',
            'Dewan Perwakilan Rakyat Daerah Kabupaten Puncak Jaya',
            'Sekretariat Daerah Kabupaten Puncak Jaya',
            'Inspektorat Kabupaten Puncak Jaya'
        ];

        $titles = [
            'Rencana Kerja Pemerintah Daerah Kabupaten Puncak Jaya',
            'Pemberian Insentif dan Kemudahan Investasi Daerah',
            'Pengelolaan Keuangan dan Aset Kampung',
            'Pedoman Pembentukan Rukun Tetangga dan Rukun Warga',
            'Penerapan Disiplin dan Penegakan Hukum Protokol Kesehatan Kerja',
            'Tata Cara Pemilihan, Pengangkatan, dan Pemberhentian Kepala Kampung',
            'Penyelenggaraan Bantuan Hukum bagi Masyarakat Miskin',
            'Rencana Tata Ruang Wilayah Terpadu',
            'Pedoman Pelaksanaan Anggaran Pendapatan dan Belanja Kampung Terintegrasi',
            'Pengawasan Intern Penyelenggaraan Pemerintahan oleh Inspektorat Daerah',
            'Rencana Detail Tata Ruang Distrik Mulia',
            'Pengembangan Komoditas Unggulan Kopi di Wilayah Pegunungan',
            'Pencegahan dan Penanggulangan Stunting Anak Balita',
            'Pedoman Pengadaan Barang dan Jasa Pemerintah Kampung',
            'Standar Pelayanan Minimal Rumah Sakit Umum Daerah Mulia',
            'Pedoman Pemberian Tambahan Penghasilan Pegawai ASN',
            'Rencana Induk Sistem Proteksi Kebakaran Kabupaten',
            'Pelestarian Cagar Budaya dan Adat Istiadat Puncak Jaya',
            'Penyelenggaraan Angkutan Jalan dan Trayek Pedalaman',
            'Penyelenggaraan Retribusi Jasa Umum dan Jasa Usaha'
        ];

        $this->command->info("Memulai pembuatan 100 data peraturan secara lengkap...");

        $createdRegulations = [];

        for ($i = 1; $i <= 100; $i++) {
            $type = $types[array_rand($types)];
            $docType = $documentTypes[$type] ?? 'PERATURAN PERUNDANG-UNDANGAN';
            
            // Generate clean year sequence
            $year = 2020 + ($i % 7); // distributes nicely between 2020 and 2026
            $number = rand(1, 40);
            $subject = $subjects[array_rand($subjects)];
            $lawField = $lawFields[array_rand($lawFields)];
            $govAffairs = $govAffairsList[array_rand($govAffairsList)];
            $teu = $teus[array_rand($teus)];
            $baseTitle = $titles[array_rand($titles)];
            
            // Format Title nicely based on Type
            if ($type === 'Peraturan Daerah (Perda) Kabupaten') {
                $title = "Peraturan Daerah Kabupaten Puncak Jaya Nomor {$number} Tahun {$year} tentang {$baseTitle}";
            } elseif ($type === 'Peraturan Bupati (Perbup)') {
                $title = "Peraturan Bupati Puncak Jaya Nomor {$number} Tahun {$year} tentang {$baseTitle}";
            } elseif ($type === 'Keputusan Bupati (Kepbup)') {
                $title = "Keputusan Bupati Puncak Jaya Nomor {$number} Tahun {$year} tentang {$baseTitle}";
            } elseif ($type === 'Instruksi Bupati (Inbup)') {
                $title = "Instruksi Bupati Puncak Jaya Nomor {$number} Tahun {$year} tentang {$baseTitle}";
            } elseif ($type === 'Surat Edaran (SE)') {
                $title = "Surat Edaran Bupati Puncak Jaya Nomor {$number} Tahun {$year} tentang {$baseTitle}";
            } else {
                $title = "Peraturan Kebijakan Daerah Kabupaten Puncak Jaya Nomor {$number} Tahun {$year} tentang {$baseTitle}";
            }

            $stipulationDate = Carbon::create($year, rand(1, 12), rand(1, 28));
            $promulgationDate = (clone $stipulationDate)->addDays(rand(1, 3));
            
            $statuses = ['active', 'active', 'active', 'amended', 'revoked'];
            $status = $statuses[array_rand($statuses)];

            $reg = Regulation::create([
                'type' => $type,
                'document_type' => $docType,
                'number' => (string) $number,
                'publishing_place' => 'KABUPATEN PUNCAK JAYA',
                'year' => $year,
                'title' => $title,
                'stipulation_date' => $stipulationDate->format('Y-m-d'),
                'promulgation_date' => $promulgationDate->format('Y-m-d'),
                'status' => $status,
                'description' => "Bahwa untuk melaksanakan ketentuan penyelenggaraan tata kelola pemerintahan yang baik, transparan, dan akuntabel di lingkungan Pemerintah Kabupaten Puncak Jaya, dipandang perlu untuk menetapkan kebijakan mengenai {$baseTitle} melalui peraturan daerah ini.",
                'file_path' => "regulations/sample_document.pdf",
                'teu' => $teu,
                'law_field' => $lawField,
                'gov_affairs' => $govAffairs,
                'subject' => $subject,
                'view_count' => rand(15, 750),
                'download_count' => rand(5, 300)
            ]);

            $createdRegulations[] = $reg;
        }

        // Generate some sample relations between created regulations to populate timeline
        $this->command->info("Membuat relasi antar peraturan...");
        for ($j = 0; $j < 15; $j++) {
            $sourceIndex = rand(0, 49);
            $targetIndex = rand(50, 99);
            
            $source = $createdRegulations[$sourceIndex];
            $target = $createdRegulations[$targetIndex];

            // Avoid duplicating relations
            $exists = RegulationRelation::where('regulation_id', $source->id)
                ->where('related_regulation_id', $target->id)
                ->exists();

            if (!$exists) {
                // Relate source amending/revoking target
                $relationType = rand(0, 1) === 0 ? 'amends' : 'revokes';
                
                RegulationRelation::create([
                    'relation_type' => $relationType,
                    'regulation_id' => $source->id,
                    'related_regulation_id' => $target->id,
                ]);

                // Create reverse relation
                $reverseType = $relationType === 'amends' ? 'amended_by' : 'revoked_by';
                RegulationRelation::create([
                    'relation_type' => $reverseType,
                    'regulation_id' => $target->id,
                    'related_regulation_id' => $source->id,
                ]);

                // Update targets status accordingly
                $target->update([
                    'status' => $relationType === 'amends' ? 'amended' : 'revoked'
                ]);
            }
        }

        $this->command->info("Berhasil membuat 100 data peraturan daerah Puncak Jaya!");
    }
}
