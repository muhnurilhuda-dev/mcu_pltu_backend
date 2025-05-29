<?php

namespace App\Http\Controllers;

use App\Models\JenisWorkPermits;
use App\Models\WorkPermits;
use Illuminate\Http\Request;

class JenisWorkPermitController extends Controller
{
    public function index() {
        $permits = JenisWorkPermits::all();
        return response()->json($permits);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $permit = JenisWorkPermits::create($validated);
        return response()->json($permit, 201);
    }

    public function show($id) {
        $permit = JenisWorkPermits::with(['jenisParameters', 'workPermits'])->findOrFail($id);
        return response()->json($permit);
    }

    public function update(Request $request, $id) {
        $permit = JenisWorkPermits::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $permit->update($validated);
        return response()->json($permit);
    }

    public function destroy($id) {
        $permit = JenisWorkPermits::findOrFail($id);
        $permit->delete();

        return response()->json(['message' => 'Permit deleted successfully'], 204);
    }
}
