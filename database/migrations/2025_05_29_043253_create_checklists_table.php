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
        Schema::create('checklists', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['OK', 'NOT OK']);
            $table->foreignId('parameter_id')->nullable()->constrained()->onDelete('set null');
            $table->string('temp_work_permit')->nullable();
            $table->string('nik_pic');
            $table->string('nama_pic');
            // $table->string('evidence')->nullable();
            $table->text('ok_remark')->nullable();
            $table->text('not_ok_remark')->nullable();
            $table->string('kategori');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklists');
    }
};
