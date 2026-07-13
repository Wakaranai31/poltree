<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the t_admin table.
     */
    public function up(): void
    {
        Schema::create('t_admin', function (Blueprint $table) {
            $table->integer('nik_admin')->primary();
            $table->string('nama_admin', 150);
            $table->string('email', 255)->nullable();
            $table->string('foto')->nullable();
            $table->string('password', 255);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_admin');
    }
};
