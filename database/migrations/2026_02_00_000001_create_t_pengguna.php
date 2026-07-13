<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the t_pengguna table.
     */
    public function up(): void
    {
        Schema::create('t_pengguna', function (Blueprint $table) {
            $table->integer('nik')->primary();
            $table->string('nama_pengguna', 150);
            $table->string('password', 255);
            $table->string('email', 150)->unique();
            $table->string('jabatan', 50);
            $table->string('foto')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_pengguna');
    }
};
