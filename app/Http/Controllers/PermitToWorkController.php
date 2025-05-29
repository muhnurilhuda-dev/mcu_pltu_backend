<?php

namespace App\Http\Controllers;

use App\Models\HotWorkPermit;
use App\Models\PermitToWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermitToWorkController extends Controller
{
    public function index() {
        $data = PermitToWork
    }

    /**
     * Store a new Permit To Work entry.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_permit' => 'required|string|max:255',
            'diminta_oleh' => 'nullable|string|max:255',
            'rencana_pekerjaan' => 'nullable|string|max:255',
            'nomor_wo' => 'nullable|string|max:255',
            'lokasi_kerja' => 'nullable|string|max:255',
            'perusahaan' => 'nullable|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'status_izin' => 'nullable|in:draft,submitted,approved,rejected',
            'pekerja' => 'nullable|array',
            'pekerja.*.nama' => 'required_with:pekerja|string',
            'pekerja.*.posisi' => 'nullable|string',
            'pekerja.*.checkup' => 'boolean',
            'housekeeping' => 'nullable|array',
            'signatures' => 'nullable|array',
            'signatures.*.jabatan' => 'required_with:signatures|string',
            'signatures.*.nama' => 'required_with:signatures|string',
            'signatures.*.tanggal' => 'required_with:signatures|date',

            // Optional foreign keys (add these if used)
            // 'id_petugas_k3' => 'nullable|exists:petugas_k3,id_petugas_k3',
            'id_jenis_ptw' => 'required|exists:jenis_ptw,id_jenis_ptw',
            // 'id_safety_officer' => 'nullable|exists:safety_officer,id_safety',
            // 'id_jsa' => 'nullable|exists:job_safety_analysis,id_jsa',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $permit = HotWorkPermit::create([
            'nomor_permit'      => $request->nomor_permit,
            'diminta_oleh'      => $request->diminta_oleh,
            'rencana_pekerjaan' => $request->rencana_pekerjaan,
            'nomor_wo'          => $request->nomor_wo,
            'lokasi_kerja'      => $request->lokasi_kerja,
            'perusahaan'        => $request->perusahaan,
            'tanggal_mulai'     => $request->tanggal_mulai,
            'tanggal_selesai'   => $request->tanggal_selesai,
            'status_izin'       => $request->status_izin ?? 'draft',
            'pekerja'           => $request->pekerja,
            'housekeeping'      => $request->housekeeping,
            'signatures'        => $request->signatures,

            // Optional foreign keys
            // 'id_petugas_k3'     => $request->id_petugas_k3,
            'id_jenis_ptw'      => $request->id_jenis_ptw,
            // 'id_safety_officer' => $request->id_safety_officer,
            // 'id_jsa'            => $request->id_jsa,
        ]);

        return response()->json([
            'message' => 'Permit berhasil disimpan.',
            'data' => $permit
        ]);
    }

    /**
     * Optional: Fetch all permits
     */
    public function index()
    {
        return PermitToWork::latest()->get();
    }

    /**
     * Optional: Show a single permit by ID
     */
    public function show($id)
    {
        $permit = PermitToWork::findOrFail($id);
        return response()->json($permit);
    }
}
