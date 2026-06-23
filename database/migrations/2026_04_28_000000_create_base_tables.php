<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Consolidated migration: creates all base tables with final schema.
     * Replaces 14+ incremental migrations.
     */
    public function up(): void
    {
        // 1. Sessions (dipindah dari create_users_table yang dihapus)
        if (!Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }

        // 2. t_pengguna
        if (!Schema::hasTable('t_pengguna')) {
            Schema::create('t_pengguna', function (Blueprint $table) {
                $table->integer('nik')->primary();
                $table->string('username', 50)->nullable()->unique();
                $table->string('nama_user', 150);
                $table->string('password', 255);
                $table->string('email', 150)->unique();
                $table->string('jabatan', 50);
                $table->string('foto')->nullable();
            });
        }

        // 3. t_admin
        if (!Schema::hasTable('t_admin')) {
            Schema::create('t_admin', function (Blueprint $table) {
                $table->integer('nik_admin')->primary();
                $table->string('username', 50)->nullable()->unique();
                $table->string('nama', 150);
                $table->string('email', 255)->nullable();
                $table->string('foto')->nullable();
                $table->string('password', 255);
            });
        }

        // 4. t_kategori
        if (!Schema::hasTable('t_kategori')) {
            Schema::create('t_kategori', function (Blueprint $table) {
                $table->integer('id_kategori')->autoIncrement()->primary();
                $table->string('nik', 50)->nullable();
                $table->string('nama_kategori', 100);
                $table->string('icon', 100)->nullable();

                $table->index('nik');
            });
        }

        // 5. t_link
        if (!Schema::hasTable('t_link')) {
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

        // 6. t_laporan
        if (!Schema::hasTable('t_laporan')) {
            Schema::create('t_laporan', function (Blueprint $table) {
                $table->integer('id_laporan')->autoIncrement()->primary();
                $table->integer('nik_pelapor');
                $table->enum('jenis_laporan', ['Penambahan Link', 'Masalah Website', 'Masalah Akun', 'Lainnya']);
                $table->text('isi_laporan');

                $table->foreign('nik_pelapor')
                    ->references('nik')
                    ->on('t_pengguna')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }

        // 7. t_terdaftar (pivot tabel kategori-link)
        if (!Schema::hasTable('t_terdaftar')) {
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
    }

    public function down(): void
    {
        Schema::dropIfExists('t_terdaftar');
        Schema::dropIfExists('t_laporan');
        Schema::dropIfExists('t_link');
        Schema::dropIfExists('t_kategori');
        Schema::dropIfExists('t_admin');
        Schema::dropIfExists('t_pengguna');
        Schema::dropIfExists('sessions');
    }
};
