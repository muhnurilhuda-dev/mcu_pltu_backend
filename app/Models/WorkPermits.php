<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkPermits extends Model
{
    protected $table = 'work_permits';
    protected $fillable = [
        'status',
        'parameter_id',
        'temp_parameter',
        'work_permit_id',
        'temp_work_permit',
        'nik_pic',
        'nama_pic',
        // 'evidence',
        'ok_remark',
        'not_ok_remark',
        'kategori'
    ];

    public function jenisWorkPermit() {
        return $this->belongsTo(JenisWorkPermits::class);
    }

    public function parameters() {
        return $this->belongsTo(Parameters::class);
    }
}
