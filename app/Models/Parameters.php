<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parameters extends Model
{
    protected $table = 'parameters';

    protected $fillable = [
        'nama',
        'deskripsi',
        'work_permit_id',
        'kategori',
    ];


    public function jenisParameter() {
        return $this->belongsTo(JenisParameters::class);
    }
    // public function workPermits() {
    //     return $this->hasMany(WorkPermits::class);
    // }
}
