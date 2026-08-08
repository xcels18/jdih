<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::query();

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                  ->orWhere('contact', 'like', "%{$q}%")
                  ->orWhere('message', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Stats
        $stats = [
            'total' => Report::count(),
            'pending' => Report::where('status', 'pending')->count(),
            'resolved' => Report::where('status', 'resolved')->count(),
        ];

        return view('admin.reports.index', compact('reports', 'stats'));
    }

    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,resolved',
            'reply' => 'nullable|string',
        ]);

        $report->update([
            'status' => $validated['status'],
            'reply' => $validated['reply'] ?? $report->reply,
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }
}
