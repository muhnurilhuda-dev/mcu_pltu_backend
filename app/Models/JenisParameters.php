<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisParameters extends Model
{
    protected $table = 'jenis_parameters';
    protected $fillable = [
        'nama',
        'jenis_work_permit_id',
    ];

    public function jenisWorkPermit() {
        return $this->belongsTo(JenisWorkPermits::class);
    }
    public function parameters() {
        return $this->hasMany(Parameters::class);
    }
}
