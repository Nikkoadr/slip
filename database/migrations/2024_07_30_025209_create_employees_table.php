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
    Schema::create('employees', function (Blueprint $table) {
        $table->id();
        $table->string('nik')->unique();
        $table->string('nama');
        $table->decimal('jumlah_gaji', 15, 2);
        $table->integer('jumlah_hadir');
        $table->integer('koprasi');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
