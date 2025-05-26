<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotWorkPermit extends Model
{
    use HasFactory;

    protected $table = 'hot_work_permit';
    protected $primaryKey = 'id_ptw';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nomor_permit',
        'diminta_oleh',
        'rencana_pekerjaan',
        'nomor_wo',
        'lokasi_kerja',
        'perusahaan',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_izin',
        'pekerja',
        'housekeeping',
        'signatures',
        'id_petugas_k3',
        'id_jenis_ptw',
        'id_safety_officer',
        'id_jsa'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'pekerja' => 'array',
        'housekeeping' => 'array',
        'signatures' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Kolom ENUM untuk status_izin
     */
    public static $statuses = ['draft', 'submitted', 'approved', 'rejected'];

    // Relasi ke tabel lain (sesuaikan dengan model yang ada)
    // public function petugasK3()
    // {
    //     return $this->belongsTo(PetugasK3::class, 'id_petugas_k3');
    // }
    
    // public function jenisPtw()
    // {
    //     return $this->belongsTo(JenisPtw::class, 'id_jenis_ptw');
    // }
    
    // public function safetyOfficer()
    // {
    //     return $this->belongsTo(SafetyOfficer::class, 'id_safety_officer');
    // }
    
    // public function jsa()
    // {
    //     return $this->belongsTo(JobSafetyAnalysis::class, 'id_jsa');
    // }
}
