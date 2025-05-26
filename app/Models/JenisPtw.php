<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPtw extends Model
{
    use HasFactory;

    protected $table = 'jenis_ptw';
    protected $primaryKey = 'id_jenis_ptw';
    public $timestamps = true;

    protected $fillable = [
        'nama_jenis',
        'deskripsi',
        // 'warna_latar',
        // 'icon',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relasi ke tabel permit_to_work
     */
    public function permits()
    {
        return $this->hasMany(PermitToWork::class, 'id_jenis_ptw');
    }
}