<?php

namespace App\Http\Controllers;

use App\Models\Regulation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegulationController extends Controller
{
    public function index()
    {
        // Get statistics overview
        $stats = [
            'total' => Regulation::count(),
            'perda' => Regulation::where('type', 'Peraturan Daerah (Perda) Kabupaten')->count(),
            'perbup' => Regulation::where('type', 'Peraturan Bupati (Perbup)')->count(),
            'kepbup' => Regulation::where('type', 'Keputusan Bupati (Kepbup)')->count(),
        ];

        // Recent regulations
        $recentRegulations = Regulation::orderBy('stipulation_date', 'desc')->take(5)->get();

        // Get unique years for filter
        $availableYears = Regulation::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');
        
        $fixed = [
            'Peraturan Daerah (Perda) Kabupaten',
            'Peraturan Bupati (Perbup)',
            'Keputusan Bupati (Kepbup)',
            'Surat Edaran (SE)'
        ];
        $others = [
            'Undang-Undang (UU)',
            'Peraturan Pemerintah Pengganti Undang-Undang (Perppu)',
            'Peraturan Pemerintah (PP)',
            'Peraturan Presiden (Perpres)',
            'Peraturan Menteri (Permen)',
            'Peraturan Mahkamah Agung (Perma)',
            'Peraturan Mahkamah Konstitusi (Permk)',
            'Peraturan Bank Indonesia (PBI)',
            'Peraturan Otoritas Jasa Keuangan (POJK)',
            'Peraturan Daerah (Perda) Provinsi',
            'Peraturan Gubernur (Pergub)',
            'Peraturan Daerah (Perda) Kota',
            'Peraturan Walikota (Perwali)',
            'Peraturan Desa (Perdes)',
            'Peraturan Kepala Desa (Perkades)',
            'Peraturan Bersama Kepala Desa (Permakades)',
            'Instruksi Bupati (Inbup)',
            'Peraturan Kebijakan',
            'Produk Hukum DPR/DPRD',
            'Produk Hukum Desa',
            'Dokumen Legislasi',
            'Dokumen Persidangan',
            'Putusan',
            'Perjanjian',
            'Dokumen Hukum Lainnya'
        ];
        shuffle($others);
        $availableTypes = array_merge($fixed, $others);

        return view('landing', compact('stats', 'recentRegulations', 'availableYears', 'availableTypes'));
    }

    public function search(Request $request)
    {
        $query = Regulation::query();

        // Clone base query for facets before filters are applied
        $facetQuery = clone $query;

        if ($request->filled('q')) {
            $searchTerm = $request->input('q');
            $words = array_filter(explode(' ', $searchTerm));

            // Base relevance score calculation
            $sqlSelect = "(
                (CASE WHEN title = ? THEN 50 ELSE 0 END) +
                (CASE WHEN title LIKE ? THEN 30 ELSE 0 END) +
                (CASE WHEN title LIKE ? THEN 15 ELSE 0 END) +
                (CASE WHEN number = ? THEN 40 ELSE 0 END) +
                (CASE WHEN description LIKE ? THEN 10 ELSE 0 END)
            ";

            $bindings = [
                $searchTerm,
                $searchTerm . '%',
                '%' . $searchTerm . '%',
                $searchTerm,
                '%' . $searchTerm . '%'
            ];

            foreach ($words as $word) {
                if (strlen($word) > 2) {
                    $sqlSelect .= " + (CASE WHEN title LIKE ? THEN 10 ELSE 0 END) + (CASE WHEN description LIKE ? THEN 5 ELSE 0 END)";
                    $bindings[] = '%' . $word . '%';
                    $bindings[] = '%' . $word . '%';
                }
            }

            $sqlSelect .= ")";

            $subQuery = DB::table('regulations')->selectRaw("*, {$sqlSelect} as raw_relevance", $bindings);
            $query = Regulation::fromSub($subQuery, 'regulations_sub');

            // Normalize raw relevance to a clean 45% - 100% percentage display
            $query->selectRaw("*, LEAST(GREATEST(ROUND((raw_relevance / 80) * 100), 45), 100) as relevance_percentage");

            $query->where(function($q) use ($searchTerm, $words) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('number', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
                foreach ($words as $word) {
                    if (strlen($word) > 2) {
                        $q->orWhere('title', 'like', "%{$word}%")
                          ->orWhere('description', 'like', "%{$word}%");
                    }
                }
            });

            // Set up facet queries with query filters applied
            $facetQuery->where(function($q) use ($searchTerm, $words) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('number', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
                foreach ($words as $word) {
                    if (strlen($word) > 2) {
                        $q->orWhere('title', 'like', "%{$word}%")
                          ->orWhere('description', 'like', "%{$word}%");
                    }
                }
            });
        }

        // Apply filters
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('year')) {
            $query->where('year', $request->input('year'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Sort priority
        $sort = $request->input('sort');
        if ($request->filled('q') && !$sort) {
            $sort = 'relevance';
        }

        if ($sort === 'relevance' && $request->filled('q')) {
            $query->orderBy('relevance_percentage', 'desc');
        } elseif ($sort === 'oldest') {
            $query->orderBy('stipulation_date', 'asc');
        } elseif ($sort === 'number') {
            $query->orderBy('number', 'asc');
        } else {
            $query->orderBy('stipulation_date', 'desc'); // newest
        }

        $regulations = $query->paginate(10)->withQueryString();

        // Calculate dynamic counts for facets
        $typeFacets = $facetQuery->clone()->select('type', DB::raw('count(*) as count'))->groupBy('type')->pluck('count', 'type')->toArray();
        $yearFacets = $facetQuery->clone()->select('year', DB::raw('count(*) as count'))->groupBy('year')->pluck('count', 'year')->toArray();
        $statusFacets = $facetQuery->clone()->select('status', DB::raw('count(*) as count'))->groupBy('status')->pluck('count', 'status')->toArray();

        $availableYears = Regulation::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');
        
        $availableTypes = [
            'Undang-Undang (UU)',
            'Peraturan Pemerintah Pengganti Undang-Undang (Perppu)',
            'Peraturan Pemerintah (PP)',
            'Peraturan Presiden (Perpres)',
            'Peraturan Menteri (Permen)',
            'Peraturan Mahkamah Agung (Perma)',
            'Peraturan Mahkamah Konstitusi (Permk)',
            'Peraturan Bank Indonesia (PBI)',
            'Peraturan Otoritas Jasa Keuangan (POJK)',
            'Peraturan Daerah (Perda) Provinsi',
            'Peraturan Gubernur (Pergub)',
            'Peraturan Daerah (Perda) Kabupaten',
            'Peraturan Daerah (Perda) Kota',
            'Peraturan Bupati (Perbup)',
            'Peraturan Walikota (Perwali)',
            'Peraturan Desa (Perdes)',
            'Peraturan Kepala Desa (Perkades)',
            'Peraturan Bersama Kepala Desa (Permakades)',
            'Keputusan Bupati (Kepbup)',
            'Instruksi Bupati (Inbup)',
            'Surat Edaran (SE)',
            'Peraturan Kebijakan',
            'Produk Hukum DPR/DPRD',
            'Produk Hukum Desa',
            'Dokumen Legislasi',
            'Dokumen Persidangan',
            'Putusan',
            'Perjanjian',
            'Dokumen Hukum Lainnya'
        ];

        return view('results', compact('regulations', 'availableYears', 'availableTypes', 'typeFacets', 'yearFacets', 'statusFacets'));
    }

    public function show($id)
    {
        $regulation = Regulation::with(['relations.relatedRegulation', 'relatedTo.regulation'])->findOrFail($id);
        $regulation->increment('view_count');

        // Build a history timeline array
        $timeline = [];

        // Add current regulation as node
        $timeline[] = [
            'id' => $regulation->id,
            'title' => $regulation->title,
            'status' => $regulation->status,
            'date' => $regulation->stipulation_date,
            'is_current' => true,
        ];

        // Find relations where this regulation is modified or modifies
        foreach ($regulation->relations as $relation) {
            $timeline[] = [
                'id' => $relation->relatedRegulation->id,
                'title' => $relation->relatedRegulation->title,
                'status' => $relation->relatedRegulation->status,
                'date' => $relation->relatedRegulation->stipulation_date,
                'is_current' => false,
                'relation_type' => $relation->relation_type,
            ];
        }

        foreach ($regulation->relatedTo as $relation) {
            $relationType = $relation->relation_type;
            if ($relationType == 'amends') {
                $mappedRelation = 'amended_by';
            } elseif ($relationType == 'revokes') {
                $mappedRelation = 'revoked_by';
            } elseif ($relationType == 'amended_by') {
                $mappedRelation = 'amends';
            } else {
                $mappedRelation = 'revokes';
            }

            $timeline[] = [
                'id' => $relation->regulation->id,
                'title' => $relation->regulation->title,
                'status' => $relation->regulation->status,
                'date' => $relation->regulation->stipulation_date,
                'is_current' => false,
                'relation_type' => $mappedRelation,
            ];
        }

        // Sort timeline by stipulation date
        usort($timeline, function($a, $b) {
            return strtotime($a['date']) <=> strtotime($b['date']);
        });

        return view('detail', compact('regulation', 'timeline'));
    }

    public function download($id)
    {
        $regulation = Regulation::findOrFail($id);
        $regulation->increment('download_count');

        if ($regulation->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($regulation->file_path)) {
            return \Illuminate\Support\Facades\Storage::disk('public')->download($regulation->file_path);
        }

        return redirect()->back()->with('error', 'Berkas PDF tidak ditemukan.');
    }

    public function statistics(Request $request)
    {
        $query = Regulation::query();

        // Apply filters
        if ($request->filled('year')) {
            $query->where('year', $request->input('year'));
        }
        if ($request->filled('document_type')) {
            $query->where('document_type', $request->input('document_type'));
        }
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('law_field')) {
            $query->where('law_field', $request->input('law_field'));
        }

        // 1. Calculate KPIs
        $totalDocs = (clone $query)->count();
        $peraturanCount = (clone $query)->where('document_type', 'Peraturan Perundang-Undangan')->count();
        $daerahCount = (clone $query)->whereIn('type', ['Peraturan Daerah (Perda) Provinsi', 'Peraturan Daerah (Perda) Kabupaten', 'Peraturan Daerah (Perda) Kota', 'Peraturan Bupati (Perbup)', 'Peraturan Walikota (Perwali)', 'Peraturan Desa (Perdes)', 'Peraturan Kepala Desa (Perkades)', 'Peraturan Bersama Kepala Desa (Permakades)'])->count();
        $keputusanCount = (clone $query)->where('type', 'Keputusan Bupati (Kepbup)')->count();
        $seCount = (clone $query)->where('type', 'Surat Edaran (SE)')->count();
        $putusanCount = (clone $query)->where('type', 'Putusan')->count();
        $legislasiCount = (clone $query)->where('type', 'Dokumen Legislasi')->count();
        
        $totalDownloads = (clone $query)->sum('download_count') ?: 0;
        $totalViews = (clone $query)->sum('view_count') ?: 0;
        $totalBookmarks = round($totalViews * 0.12);
        
        $newThisMonth = (clone $query)->whereMonth('stipulation_date', now()->month)->whereYear('stipulation_date', now()->year)->count();

        // 2. Trend Dokumen (Line Chart)
        $yearlyTrend = (clone $query)->select('year', DB::raw('count(*) as total'))
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        // 3. Distribusi Jenis Dokumen (Donut Chart)
        $typeDistribution = (clone $query)->select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->orderBy('total', 'desc')
            ->get();

        // 4. Status Dokumen (Pie Chart)
        $statusDistribution = (clone $query)->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // 5. Bidang Hukum (Bar/Treemap representation)
        $lawFieldDistribution = (clone $query)->select('law_field', DB::raw('count(*) as total'))
            ->whereNotNull('law_field')
            ->groupBy('law_field')
            ->orderBy('total', 'desc')
            ->get();

        // 6. Top Dokumen Table
        $topRegulations = (clone $query)->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        $data = [
            'kpis' => [
                'total' => $totalDocs,
                'peraturan' => $peraturanCount,
                'daerah' => $daerahCount,
                'keputusan' => $keputusanCount,
                'se' => $seCount,
                'putusan' => $putusanCount,
                'legislasi' => $legislasiCount,
                'downloads' => $totalDownloads,
                'views' => $totalViews,
                'bookmarks' => $totalBookmarks,
                'new_this_month' => $newThisMonth,
            ],
            'charts' => [
                'yearly_trend' => [
                    'labels' => $yearlyTrend->pluck('year'),
                    'values' => $yearlyTrend->pluck('total'),
                ],
                'type_distribution' => [
                    'labels' => $typeDistribution->pluck('type'),
                    'values' => $typeDistribution->pluck('total'),
                ],
                'status_distribution' => [
                    'labels' => $statusDistribution->map(fn($item) => $item->status == 'active' ? 'Berlaku' : ($item->status == 'amended' ? 'Diubah' : 'Dicabut')),
                    'values' => $statusDistribution->pluck('total'),
                    'raw_status' => $statusDistribution->pluck('status'),
                ],
                'law_field' => [
                    'labels' => $lawFieldDistribution->pluck('law_field'),
                    'values' => $lawFieldDistribution->pluck('total'),
                ],
            ],
            'top_regulations' => $topRegulations->map(fn($reg) => [
                'id' => $reg->id,
                'title' => $reg->title,
                'views' => $reg->view_count,
                'downloads' => $reg->download_count,
                'type' => $reg->type,
                'status' => $reg->status,
            ])
        ];

        if ($request->has('ajax') || $request->wantsJson()) {
            return response()->json($data);
        }

        // For initial load page, get unique filter lists
        $filterYears = Regulation::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');
        $filterDocTypes = Regulation::select('document_type')->distinct()->whereNotNull('document_type')->pluck('document_type');
        $filterTypes = [
            'Undang-Undang (UU)',
            'Peraturan Pemerintah (PP)',
            'Peraturan Presiden (Perpres)',
            'Peraturan Menteri (Permen)',
            'Peraturan Mahkamah Agung (Perma)',
            'Peraturan Mahkamah Konstitusi (Permk)',
            'Peraturan Bank Indonesia (PBI)',
            'Peraturan Otoritas Jasa Keuangan (POJK)',
            'Peraturan Daerah (Perda) Provinsi',
            'Peraturan Gubernur (Pergub)',
            'Peraturan Daerah (Perda) Kabupaten',
            'Peraturan Daerah (Perda) Kota',
            'Peraturan Bupati (Perbup)',
            'Peraturan Walikota (Perwali)',
            'Peraturan Desa (Perdes)',
            'Peraturan Kepala Desa (Perkades)',
            'Peraturan Bersama Kepala Desa (Permakades)',
            'Keputusan Bupati (Kepbup)',
            'Instruksi Bupati (Inbup)',
            'Surat Edaran (SE)',
            'Peraturan Kebijakan',
            'Produk Hukum DPR/DPRD',
            'Produk Hukum Desa',
            'Dokumen Legislasi',
            'Dokumen Persidangan',
            'Putusan',
            'Perjanjian',
            'Dokumen Hukum Lainnya'
        ];
        $filterLawFields = Regulation::select('law_field')->distinct()->whereNotNull('law_field')->pluck('law_field');

        return view('stats', compact('data', 'filterYears', 'filterDocTypes', 'filterTypes', 'filterLawFields'));
    }

    public function exportExcel()
    {
        // Only allow if logged in (admin)
        if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }

        $regulations = \App\Models\Regulation::orderBy('stipulation_date', 'desc')->get();

        $filename = "JDIH_Puncak_Jaya_Laporan_Regulasi_" . date('Ymd_His') . ".csv";

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($regulations) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Headers
            fputcsv($file, [
                'ID', 
                'Bentuk Peraturan', 
                'Nomor', 
                'Tahun', 
                'Judul', 
                'Tanggal Penetapan', 
                'Status Hukum', 
                'TEU', 
                'Bidang Hukum', 
                'Subjek', 
                'Kunjungan (Views)', 
                'Unduhan (Downloads)'
            ]);

            foreach ($regulations as $reg) {
                fputcsv($file, [
                    $reg->id,
                    $reg->type,
                    $reg->number,
                    $reg->year,
                    $reg->title,
                    $reg->stipulation_date,
                    $reg->status == 'active' ? 'Berlaku' : ($reg->status == 'amended' ? 'Diubah' : 'Dicabut'),
                    $reg->teu,
                    $reg->law_field,
                    $reg->subject,
                    $reg->view_count,
                    $reg->download_count
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
