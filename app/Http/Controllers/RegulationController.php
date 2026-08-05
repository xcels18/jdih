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
            'perda' => Regulation::where('type', 'Peraturan Daerah')->count(),
            'perbup' => Regulation::where('type', 'Peraturan Bupati')->count(),
            'kepbup' => Regulation::where('type', 'Keputusan Bupati')->count(),
        ];

        // Recent regulations
        $recentRegulations = Regulation::orderBy('stipulation_date', 'desc')->take(5)->get();

        // Get unique years for filter
        $availableYears = Regulation::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');
        $availableTypes = Regulation::select('type')->distinct()->orderBy('type', 'asc')->pluck('type');

        return view('landing', compact('stats', 'recentRegulations', 'availableYears', 'availableTypes'));
    }

    public function search(Request $request)
    {
        $query = Regulation::query();

        if ($request->filled('q')) {
            $searchTerm = $request->input('q');
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('number', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('year')) {
            $query->where('year', $request->input('year'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $sort = $request->input('sort', 'newest');
        if ($sort === 'newest') {
            $query->orderBy('stipulation_date', 'desc');
        } elseif ($sort === 'oldest') {
            $query->orderBy('stipulation_date', 'asc');
        } elseif ($sort === 'number') {
            $query->orderBy('number', 'asc');
        }

        $regulations = $query->paginate(10)->withQueryString();

        $availableYears = Regulation::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');
        $availableTypes = Regulation::select('type')->distinct()->orderBy('type', 'asc')->pluck('type');

        return view('results', compact('regulations', 'availableYears', 'availableTypes'));
    }

    public function show($id)
    {
        $regulation = Regulation::with(['relations.relatedRegulation', 'relatedTo.regulation'])->findOrFail($id);

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

    public function statistics()
    {
        // Regulations by status
        $statusCounts = Regulation::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Regulations by type
        $typeCounts = Regulation::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type')
            ->toArray();

        // Regulations by year
        $yearCounts = Regulation::select('year', DB::raw('count(*) as total'))
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->pluck('total', 'year')
            ->toArray();

        return view('stats', compact('statusCounts', 'typeCounts', 'yearCounts'));
    }
}
