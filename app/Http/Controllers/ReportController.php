<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        Report::create([
            'name' => $validated['name'],
            'contact' => $validated['contact'],
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan Anda berhasil dikirim ke pengelola JDIH. Terima kasih atas laporan Anda.'
        ]);
    }
}
