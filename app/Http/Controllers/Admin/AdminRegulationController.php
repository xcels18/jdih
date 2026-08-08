<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Regulation;
use App\Models\RegulationRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminRegulationController extends Controller
{
    public function exportExcel()
    {
        $regulations = Regulation::orderBy('created_at', 'desc')->get();
        
        $fileName = 'rekap_peraturan_jdih_' . date('Y-m-d') . '.csv';
        
        $headers = array(
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('ID', 'Judul Peraturan', 'Nomor', 'Tahun', 'Jenis Peraturan', 'Status', 'Tanggal Penetapan', 'Tanggal Diundangkan', 'Jumlah Unduh', 'Jumlah Dilihat');

        $callback = function() use($regulations, $columns) {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel compatibility
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns, ';');

            foreach ($regulations as $reg) {
                fputcsv($file, array(
                    $reg->id,
                    $reg->title,
                    $reg->number,
                    $reg->year,
                    $reg->type,
                    $reg->status,
                    $reg->stipulation_date,
                    $reg->promulgation_date ?: '-',
                    $reg->download_count ?? 0,
                    $reg->view_count ?? 0
                ), ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function index(Request $request)
    {
        $query = Regulation::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('number', 'like', "%{$q}%")
                    ->orWhere('year', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $regulations = $query->orderBy('stipulation_date', 'desc')->paginate(20)->withQueryString();
        
        $availableTypes = [
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

        // Compute dashboard statistics
        $stats = [
            'total' => Regulation::count(),
            'perda' => Regulation::whereIn('type', ['Peraturan Daerah (Perda) Provinsi', 'Peraturan Daerah (Perda) Kabupaten', 'Peraturan Daerah (Perda) Kota'])->count(),
            'perbup' => Regulation::where('type', 'Peraturan Bupati (Perbup)')->count(),
            'kepbup' => Regulation::where('type', 'Keputusan Bupati (Kepbup)')->count(),
            'others' => Regulation::whereNotIn('type', ['Peraturan Daerah (Perda) Provinsi', 'Peraturan Daerah (Perda) Kabupaten', 'Peraturan Daerah (Perda) Kota', 'Peraturan Bupati (Perbup)', 'Keputusan Bupati (Kepbup)'])->count(),
        ];

        return view('admin.index', compact('regulations', 'availableTypes', 'stats'));
    }

    public function create()
    {
        $allRegulations = Regulation::orderBy('title', 'asc')->get();
        return view('admin.form', compact('allRegulations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'document_type' => 'required|string',
            'number' => 'required|string',
            'publishing_place' => 'required|string',
            'year' => 'required|integer',
            'title' => 'required|string',
            'stipulation_date' => 'required|date',
            'promulgation_date' => 'nullable|date',
            'status' => 'required|in:active,revoked,amended',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:pdf|max:20480', // max 20MB
            'teu' => 'required|string',
            'law_field' => 'required|string',
            'gov_affairs' => 'nullable|string',
            'subject' => 'required|string',
            'related_regulation_id' => 'nullable|exists:regulations,id',
            'relation_type' => 'nullable|required_with:related_regulation_id|in:revokes,revoked_by,amends,amended_by',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('regulations', 'public');
        }

        $regulation = Regulation::create([
            'type' => $request->type,
            'document_type' => $request->document_type,
            'number' => $request->number,
            'publishing_place' => $request->publishing_place,
            'year' => $request->year,
            'title' => $request->title,
            'stipulation_date' => $request->stipulation_date,
            'promulgation_date' => $request->promulgation_date,
            'status' => $request->status,
            'description' => $request->description,
            'file_path' => $filePath,
            'teu' => $request->teu,
            'law_field' => $request->law_field,
            'gov_affairs' => $request->gov_affairs,
            'subject' => $request->subject,
        ]);

        // Save relationship if specified
        if ($request->filled('related_regulation_id')) {
            $relatedId = $request->related_regulation_id;
            $type = $request->relation_type;

            // Save forward relation
            RegulationRelation::create([
                'regulation_id' => $regulation->id,
                'related_regulation_id' => $relatedId,
                'relation_type' => $type,
            ]);

            // Save mirror/reverse relation automatically
            $reverseType = '';
            if ($type == 'amends') {
                $reverseType = 'amended_by';
            } elseif ($type == 'amended_by') {
                $reverseType = 'amends';
            } elseif ($type == 'revokes') {
                $reverseType = 'revoked_by';
            } elseif ($type == 'revoked_by') {
                $reverseType = 'revokes';
            }

            RegulationRelation::create([
                'regulation_id' => $relatedId,
                'related_regulation_id' => $regulation->id,
                'relation_type' => $reverseType,
            ]);
        }

        return redirect()->route('admin.regulations.index')->with('success', 'Regulasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $regulation = Regulation::findOrFail($id);
        $allRegulations = Regulation::where('id', '!=', $id)->orderBy('title', 'asc')->get();
        
        // Find existing relation if any
        $existingRelation = RegulationRelation::where('regulation_id', $id)->first();

        return view('admin.form', compact('regulation', 'allRegulations', 'existingRelation'));
    }

    public function update(Request $request, $id)
    {
        $regulation = Regulation::findOrFail($id);

        $request->validate([
            'type' => 'required|string',
            'document_type' => 'required|string',
            'number' => 'required|string',
            'publishing_place' => 'required|string',
            'year' => 'required|integer',
            'title' => 'required|string',
            'stipulation_date' => 'required|date',
            'promulgation_date' => 'nullable|date',
            'status' => 'required|in:active,revoked,amended',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:pdf|max:20480',
            'teu' => 'required|string',
            'law_field' => 'required|string',
            'gov_affairs' => 'nullable|string',
            'subject' => 'required|string',
            'related_regulation_id' => 'nullable|exists:regulations,id',
            'relation_type' => 'nullable|required_with:related_regulation_id|in:revokes,revoked_by,amends,amended_by',
        ]);

        if ($request->hasFile('file')) {
            // Delete old file
            if ($regulation->file_path) {
                Storage::disk('public')->delete($regulation->file_path);
            }
            $regulation->file_path = $request->file('file')->store('regulations', 'public');
        } elseif ($request->input('delete_file') == '1') {
            if ($regulation->file_path) {
                Storage::disk('public')->delete($regulation->file_path);
            }
            $regulation->file_path = null;
        }

        $regulation->update([
            'type' => $request->type,
            'document_type' => $request->document_type,
            'number' => $request->number,
            'publishing_place' => $request->publishing_place,
            'year' => $request->year,
            'title' => $request->title,
            'stipulation_date' => $request->stipulation_date,
            'promulgation_date' => $request->promulgation_date,
            'status' => $request->status,
            'description' => $request->description,
            'teu' => $request->teu,
            'law_field' => $request->law_field,
            'gov_affairs' => $request->gov_affairs,
            'subject' => $request->subject,
        ]);

        // Update relationships
        // Clear old ones for this regulation (and the mirrored reverse ones)
        $oldRelations = RegulationRelation::where('regulation_id', $id)->get();
        foreach ($oldRelations as $oldRel) {
            RegulationRelation::where('regulation_id', $oldRel->related_regulation_id)
                ->where('related_regulation_id', $id)
                ->delete();
            $oldRel->delete();
        }

        if ($request->filled('related_regulation_id')) {
            $relatedId = $request->related_regulation_id;
            $type = $request->relation_type;

            RegulationRelation::create([
                'regulation_id' => $id,
                'related_regulation_id' => $relatedId,
                'relation_type' => $type,
            ]);

            $reverseType = '';
            if ($type == 'amends') {
                $reverseType = 'amended_by';
            } elseif ($type == 'amended_by') {
                $reverseType = 'amends';
            } elseif ($type == 'revokes') {
                $reverseType = 'revoked_by';
            } elseif ($type == 'revoked_by') {
                $reverseType = 'revokes';
            }

            RegulationRelation::create([
                'regulation_id' => $relatedId,
                'related_regulation_id' => $id,
                'relation_type' => $reverseType,
            ]);
        }

        return redirect()->route('admin.regulations.index')->with('success', 'Regulasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $regulation = Regulation::findOrFail($id);
        
        // Delete PDF file
        if ($regulation->file_path) {
            Storage::disk('public')->delete($regulation->file_path);
        }

        $regulation->delete();

        return redirect()->route('admin.regulations.index')->with('success', 'Regulasi berhasil dihapus.');
    }
}
