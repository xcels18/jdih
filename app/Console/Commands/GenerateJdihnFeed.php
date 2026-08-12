<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Regulation;
use Illuminate\Support\Facades\File;

class GenerateJdihnFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jdihn:generate-feed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate document.json feed for JDIHN BPHN integration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $allowedTypes = [
            'Peraturan Daerah (Perda) Kabupaten',
            'Peraturan Bupati (Perbup)',
            'Keputusan Bupati (Kepbup)',
            'Surat Edaran (SE)',
            'Instruksi Bupati (Inbup)',
            'Pengumuman Bupati'
        ];

        // Fetch regulations that are of local regional types
        $regulations = Regulation::whereIn('type', $allowedTypes)->get();

        $feedData = [];

        foreach ($regulations as $reg) {
            // Mapping Status
            $status = 'Berlaku';
            if ($reg->status === 'revoked') {
                $status = 'Tidak Berlaku';
            } elseif ($reg->status === 'amended') {
                $status = 'Mengalami Perubahan';
            }

            // Map Singkatan Jenis
            $singkatanJenis = '-';
            if (str_contains($reg->type, 'Perda')) {
                $singkatanJenis = 'PERDA';
            } elseif (str_contains($reg->type, 'Perbup')) {
                $singkatanJenis = 'PERBUP';
            } elseif (str_contains($reg->type, 'Kepbup')) {
                $singkatanJenis = 'KEPBUP';
            } elseif (str_contains($reg->type, 'SE')) {
                $singkatanJenis = 'SE';
            } elseif (str_contains($reg->type, 'Inbup')) {
                $singkatanJenis = 'INBUP';
            }

            $feedData[] = [
                "idData" => (string) $reg->id,
                "tahun_pengundangan" => (string) $reg->year,
                "tanggal_penetapan" => $reg->stipulation_date ? $reg->stipulation_date->format('Y-m-d') : "-",
                "tanggal_pengundangan" => $reg->promulgation_date ? $reg->promulgation_date->format('Y-m-d') : ($reg->stipulation_date ? $reg->stipulation_date->format('Y-m-d') : "-"),
                "jenis" => strtoupper($reg->type),
                "noPeraturan" => (string) $reg->number,
                "judul" => $reg->title,
                "noPanggil" => "-",
                "singkatanJenis" => $singkatanJenis,
                "tempatTerbit" => $reg->publishing_place ?? "KAB. PUNCAK JAYA",
                "penerbit" => "Pemerintah Kabupaten Puncak Jaya",
                "deskripsiFisik" => "-",
                "sumber" => "-",
                "isbn" => "-",
                "status" => $status,
                "bahasa" => "Indonesia",
                "bidangHukum" => $reg->law_field ?? "-",
                "teuBadan" => $reg->teu ?? "-",
                "nomorIndukBuku" => "-",
                "abstrak" => $reg->file_path ? basename($reg->file_path) : "-",
                "last_updated" => $reg->updated_at ? $reg->updated_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s'),
                "urlAbstrak" => $reg->file_path ? asset('storage/' . $reg->file_path) : ($reg->external_pdf_url ?? "-"),
                "urlDetailPeraturan" => route('detail', $reg->id),
                "fileDownload" => "-",
                "urlDownload" => "-",
                "subjek" => $reg->subject ?? "",
                "operasi" => "4",
                "display" => "1"
            ];
        }

        // Ensure feed directory exists
        $feedPath = public_path('feed');
        if (!File::exists($feedPath)) {
            File::makeDirectory($feedPath, 0755, true);
        }

        $jsonFile = $feedPath . '/document.json';
        File::put($jsonFile, json_encode($feedData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $this->info("Dokumen feed berhasil digenerate ke: {$jsonFile}");
    }
}
