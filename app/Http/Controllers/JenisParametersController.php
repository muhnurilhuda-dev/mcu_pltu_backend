<?php

namespace App\Http\Controllers;

use App\Models\JenisParameters;
use Illuminate\Http\Request;

class JenisParametersController extends Controller
{
    public function index() {
        $jenisParameters = JenisParameters::with('jenis_work_permits')->get();
        return response()->json($jenisParameters);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_work_permit_id' => 'required|exists:jenis_work_permits,id',
        ]);

        $jenisParameters = JenisParameters::create($validated);
        return response()->json($jenisParameters, 201);
    }

    public function show($id) {
        $jenisParameters = JenisParameters::with('jenis_work_permits')->findOrFail($id);
        return response()->json($jenisParameters);
    }

    public function update(Request $request, $id) {
        $jenisParameters = JenisParameters::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_work_permit_id' => 'required|exists:jenis_work_permits,id',
        ]);

        $jenisParameters->update($validated);
        return response()->json($jenisParameters);
    }

    public function destroy($id) {
        $jenisParameters = JenisParameters::findOrFail($id);
        $jenisParameters->delete();
        
        return response()->json(['message' => 'Jenis Parameter berhasil dihapus.'], 204);
    }
}
