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
        Schema::table('hot_work_permit', function (Blueprint $table) {
            // 1. Add the column first
            $table->unsignedBigInteger('id_jenis_ptw');
            
            // 2. Add foreign key constraint
            $table->foreign('id_jenis_ptw')
                ->references('id_jenis_ptw')
                ->on('jenis_ptw')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hot_work_permit', function (Blueprint $table) {
            // 1. Drop foreign key first
            $table->dropForeign(['id_jenis_ptw']);
            
            // 2. Drop the column
            $table->dropColumn('id_jenis_ptw');
        });
    }
};
