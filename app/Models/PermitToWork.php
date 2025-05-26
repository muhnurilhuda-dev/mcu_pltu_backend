<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermitToWork extends Model
{
    use HasFactory;

    protected $table = 'permit_to_work';
    protected $primaryKey = 'id_ptw';
    public $incrementing = true;

    protected $fillable = [
        'nomor_permit',
        'diminta_oleh',
        'rencana_pekerjaan',
        'tanggal_mulai',
        'tanggal_selesai',
        'nomor_wo',
        'lokasi_kerja',
        'perusahaan',
        'form_data', // optional: store serialized form data
    ];

    // Relations (add these if the foreign keys are valid)
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
