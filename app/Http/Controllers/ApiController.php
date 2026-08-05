<?php

namespace App\Http\Controllers;

use App\Models\Regulation;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Get paginated legal documents (JDIHN/BPHN Harvesting Standard)
     */
    public function index(Request $request)
    {
        $limit = min($request->get('limit', 20), 100);
        
        $query = Regulation::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $paginator = $query->orderBy('stipulation_date', 'desc')->paginate($limit);

        $formattedData = collect($paginator->items())->map(function($reg) {
            return [
                'id' => $reg->id,
                'jenis_peraturan' => $reg->type,
                'nomor' => $reg->number,
                'tahun' => $reg->year,
                'judul' => $reg->title,
                'teu' => $reg->teu ?: 'Inspektorat Kabupaten Puncak Jaya',
                'bidang_hukum' => $reg->law_field,
                'subjek' => $reg->subject ? array_map('trim', explode(',', $reg->subject)) : [],
                'tanggal_penetapan' => $reg->stipulation_date,
                'status_hukum' => $reg->status,
                'abstrak' => $reg->description,
                'url_dokumen' => $reg->file_path ? asset('storage/' . $reg->file_path) : null,
                'created_at' => $reg->created_at->toIso8601String(),
                'updated_at' => $reg->updated_at->toIso8601String(),
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Data regulasi berhasil diambil.',
            'data' => $formattedData,
            'pagination' => [
                'total_records' => $paginator->total(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
            ]
        ], 200);
    }

    /**
     * Get a single legal document
     */
    public function show($id)
    {
        $reg = Regulation::find($id);

        if (!$reg) {
            return response()->json([
                'status' => 'error',
                'message' => 'Regulasi tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $reg->id,
                'jenis_peraturan' => $reg->type,
                'nomor' => $reg->number,
                'tahun' => $reg->year,
                'judul' => $reg->title,
                'teu' => $reg->teu ?: 'Inspektorat Kabupaten Puncak Jaya',
                'bidang_hukum' => $reg->law_field,
                'subjek' => $reg->subject ? array_map('trim', explode(',', $reg->subject)) : [],
                'tanggal_penetapan' => $reg->stipulation_date,
                'status_hukum' => $reg->status,
                'abstrak' => $reg->description,
                'url_dokumen' => $reg->file_path ? asset('storage/' . $reg->file_path) : null,
                'created_at' => $reg->created_at->toIso8601String(),
                'updated_at' => $reg->updated_at->toIso8601String(),
            ]
        ], 200);
    }
}
