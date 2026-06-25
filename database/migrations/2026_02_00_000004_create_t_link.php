<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the t_link table.
     * Depends on: t_kategori (foreign key).
     */
    public function up(): void
    {
        Schema::create('t_link', function (Blueprint $table) {
            $table->integer('id_link')->autoIncrement()->primary();
            $table->integer('id_kategori')->nullable();
            $table->string('nik', 50)->nullable();
            $table->string('nama_web', 150);
            $table->string('url', 255);
            $table->text('deskripsi')->nullable();
            $table->enum('role', ['Dosen', 'Tata Usaha', 'Laboran'])->nullable();
            $table->string('status', 50)->default('aktif');
            $table->string('status_link', 50)->default('belum dicek');
            $table->timestamp('status_checked_at')->nullable();
            $table->unsignedSmallInteger('status_http_code')->nullable();
            $table->unsignedInteger('status_response_time_ms')->nullable();
            $table->string('status_summary', 255)->nullable();
            $table->integer('hit_point')->default(0);

            // Indexes
            $table->index('status');
            $table->index('status_link');
            $table->index('id_kategori');
            $table->index('nik');

            // Foreign keys
            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('t_kategori')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_link');
    }
};
