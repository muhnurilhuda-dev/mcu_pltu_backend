<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Table Users
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama_lengkap', 100);
            // $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->enum('role', ['petugas_k3', 'petugas_medis', 'safety_officer', 'asisten_manajer_k3']);
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });

        // 2. Asisten Manajer K3 Table (Workers)
        Schema::create('petugas_k3', function (Blueprint $table) {
            $table->id('id_petugas_k3');
            $table->string('nama', 100);
            $table->date('tanggal_lahir');
            $table->string('departemen', 100);
            $table->enum('status_kesehatan_terkini', ['baik', 'sedang', 'buruk']);
            $table->timestamps();
        });
        Schema::create('asisten_manajer_k3', function (Blueprint $table) {
            $table->id('id_petugas_k3');
            $table->string('nama', 100);
            $table->date('tanggal_lahir');
            $table->string('departemen', 100);
            $table->enum('status_kesehatan_terkini', ['baik', 'sedang', 'buruk']);
            $table->timestamps();
        });

        // 3. Petugas Medis (Medical Officers)
        Schema::create('petugas_medis', function (Blueprint $table) {
            $table->id('id_petugas');
            $table->foreignId('user_id')->constrained('users', 'id_user');
            $table->timestamps();
        });

        // 4. Safety Officers
        Schema::create('safety_officer', function (Blueprint $table) {
            $table->id('id_safety');
            $table->foreignId('user_id')->constrained('users', 'id_user');
            $table->timestamps();
        });

        // 5. Medical Check-Ups (MCU)
        Schema::create('medical_check_up', function (Blueprint $table) {
            $table->id('id_mcu');
            $table->foreignId('id_petugas_k3')->constrained('petugas_k3', 'id_petugas_k3');
            $table->date('tanggal_mcu');
            $table->decimal('suhu_tubuh', 4, 1);
            $table->string('tekanan_darah', 20);
            $table->integer('kolesterol');
            $table->integer('gula_darah');
            $table->text('catatan_mcu');
            $table->timestamps();
        });

        // 6. Daily Fit to Work
        Schema::create('daily_fit_to_work', function (Blueprint $table) {
            $table->id('id_fit');
            $table->foreignId('id_petugas_k3')->constrained('petugas_k3', 'id_petugas_k3');
            $table->date('tanggal_pemeriksaan');
            $table->integer('tekanan_darah_sistolik');
            $table->integer('tekanan_darah_diastolik');
            $table->text('keluhan');
            $table->enum('status_fit', ['fit', 'unfit', 'conditional']);
            $table->foreignId('id_petugas')->constrained('petugas_medis', 'id_petugas');
            $table->timestamps();
        });

        // 7. Approval Pemeriksaan
        Schema::create('approval_pemeriksaan', function (Blueprint $table) {
            $table->id('id_validasi');
            $table->foreignId('id_fit')->constrained('daily_fit_to_work', 'id_fit');
            $table->foreignId('id_petugas')->constrained('petugas_medis', 'id_petugas');
            $table->enum('status_validasi', ['approved', 'rejected', 'pending']);
            $table->date('tanggal_validasi');
            $table->text('catatan_validasi');
            $table->timestamps();
        });

        // 8. Jenis PTW
        Schema::create('jenis_ptw', function (Blueprint $table) {
            $table->id('id_jenis_ptw');
            $table->string('nama_jenis', 100);
            $table->text('deskripsi');
            $table->timestamps();
        });

        // 9. Job Safety Analysis (JSA)
        Schema::create('job_safety_analysis', function (Blueprint $table) {
            $table->id('id_jsa');
            $table->foreignId('id_petugas_k3')->constrained('petugas_k3', 'id_petugas_k3');
            $table->text('uraian_petugas_k3an');
            $table->text('potensi_bahaya');
            $table->text('tindakan_pengendalian');
            $table->date('tanggal_dibuat');
            $table->timestamps();
        });

        // 10. Permit to Work (PTW)
        Schema::create('permit_to_work', function (Blueprint $table) {
            $table->id('id_ptw');
            $table->foreignId('id_petugas_k3')->constrained('petugas_k3', 'id_petugas_k3');
            $table->foreignId('id_jenis_ptw')->constrained('jenis_ptw', 'id_jenis_ptw');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status_izin', ['draft', 'submitted', 'approved', 'rejected']);
            $table->foreignId('id_safety_officer')->constrained('safety_officer', 'id_safety');
            $table->foreignId('id_jsa')->constrained('job_safety_analysis', 'id_jsa');
            $table->timestamps();
        });

        // 11. Permit Activity Time
        Schema::create('permit_activity_time', function (Blueprint $table) {
            $table->id('id_waktu_aktivitas');
            $table->foreignId('id_ptw')->constrained('permit_to_work', 'id_ptw');
            $table->string('aktivitas', 100);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();
        });

        // 12. Permit Approval
        Schema::create('permit_approval', function (Blueprint $table) {
            $table->id('id_approval');
            $table->foreignId('id_ptw')->constrained('permit_to_work', 'id_ptw');
            $table->foreignId('id_safety_officer')->constrained('safety_officer', 'id_safety');
            $table->enum('status_approval', ['pending', 'approved', 'rejected']);
            $table->date('tanggal_approval');
            $table->text('catatan_approval');
            $table->timestamps();
        });

        // 13. Dokumen Pendukung
        Schema::create('dokumen_pendukung', function (Blueprint $table) {
            $table->id('id_dokumen');
            $table->foreignId('id_ptw')->constrained('permit_to_work', 'id_ptw');
            $table->string('nama_dokumen', 100);
            $table->string('file_path', 255);
            $table->timestamps();
        });

        // 14. Laporan
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->enum('jenis_laporan', ['harian', 'mingguan', 'bulanan']);
            $table->string('periode', 50);
            $table->foreignId('dibuat_oleh')->constrained('users', 'id_user');
            $table->string('file_laporan', 255);
            $table->timestamps();
        });

        // 15. Rekap Data
        Schema::create('rekap', function (Blueprint $table) {
            $table->id('id_rekap');
            $table->date('tanggal_rekap');
            $table->integer('total_petugas_k3_fit');
            $table->integer('total_ptw_diterbitkan');
            $table->timestamps();
        });

        // 16. Log Aktivitas
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id('id_log');
            $table->foreignId('id_user')->constrained('users', 'id_user');
            $table->text('aktivitas');
            $table->dateTime('timestamp');
            $table->timestamps();
        });

        // 17. Notifikasi
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->foreignId('id_user')->constrained('users', 'id_user');
            $table->text('isi_pesan');
            $table->boolean('status_baca')->default(false);
            $table->timestamps();
        });

        // 18. Question (USE Test)
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained('users', 'id_user');
            $table->string('nama');
            $table->string('type');
            $table->text('deskripsi');
            $table->json('extra')->nullable();
            $table->timestamp('created_at');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
