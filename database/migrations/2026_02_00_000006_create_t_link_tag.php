<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the t_link_tag pivot table.
     */
    public function up(): void
    {
        if (!Schema::hasTable('t_link_tag')) {
            Schema::create('t_link_tag', function (Blueprint $table) {
                $table->id();
                $table->integer('id_link');
                $table->unsignedBigInteger('id_tag');

                // Unique composite index: mencegah duplikasi tag pada link yang sama
                $table->unique(['id_link', 'id_tag']);

                $table->foreign('id_link')
                    ->references('id_link')
                    ->on('t_link')
                    ->onDelete('cascade');

                $table->foreign('id_tag')
                    ->references('id_tag')
                    ->on('t_tag')
                    ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('t_link_tag');
    }
};
