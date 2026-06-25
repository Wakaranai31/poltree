<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the t_terdaftar pivot table (kategori-link).
     * Depends on: t_kategori, t_link (foreign keys).
     */
    public function up(): void
    {
        Schema::create('t_terdaftar', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->primary();
            $table->integer('id_kategori');
            $table->integer('id_link');

            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('t_kategori')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('id_link')
                ->references('id_link')
                ->on('t_link')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_terdaftar');
    }
};
