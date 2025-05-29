<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisWorkPermits extends Model
{
    protected $table = 'jenis_work_permits';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    public function jenisParameters() {
        return $this->hasMany(JenisParameters::class);
    }

    public function workPermits() {
        return $this->hasMany(WorkPermits::class);
    }
}
