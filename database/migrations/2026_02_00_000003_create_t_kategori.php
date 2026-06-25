<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the t_kategori table.
     */
    public function up(): void
    {
        Schema::create('t_kategori', function (Blueprint $table) {
            $table->integer('id_kategori')->autoIncrement()->primary();
            $table->string('nik', 50)->nullable();
            $table->string('nama_kategori', 100);
            $table->string('icon', 100)->nullable();

            $table->index('nik');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_kategori');
    }
};
