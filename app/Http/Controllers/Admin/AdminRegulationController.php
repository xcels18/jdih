<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Regulation;
use App\Models\RegulationRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminRegulationController extends Controller
{

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
            'Peraturan Daerah',
            'Peraturan Bupati',
            'Peraturan Kepala Daerah',
            'Keputusan Bupati',
            'Instruksi Bupati',
            'Surat Edaran',
            'Pengumuman',
            'Keputusan Dewan'
        ];

        return view('admin.index', compact('regulations', 'availableTypes'));
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
            'number' => 'required|string',
            'year' => 'required|integer',
            'title' => 'required|string',
            'stipulation_date' => 'required|date',
            'status' => 'required|in:active,revoked,amended',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:pdf|max:20480', // max 20MB
            'teu' => 'required|string',
            'law_field' => 'required|string',
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
            'number' => $request->number,
            'year' => $request->year,
            'title' => $request->title,
            'stipulation_date' => $request->stipulation_date,
            'status' => $request->status,
            'description' => $request->description,
            'file_path' => $filePath,
            'teu' => $request->teu,
            'law_field' => $request->law_field,
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
            'number' => 'required|string',
            'year' => 'required|integer',
            'title' => 'required|string',
            'stipulation_date' => 'required|date',
            'status' => 'required|in:active,revoked,amended',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:pdf|max:20480',
            'teu' => 'required|string',
            'law_field' => 'required|string',
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
        }

        $regulation->update([
            'type' => $request->type,
            'number' => $request->number,
            'year' => $request->year,
            'title' => $request->title,
            'stipulation_date' => $request->stipulation_date,
            'status' => $request->status,
            'description' => $request->description,
            'teu' => $request->teu,
            'law_field' => $request->law_field,
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
