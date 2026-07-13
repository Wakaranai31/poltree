<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the tags system: t_tag and t_link_tag pivot table.
     */
    public function up(): void
    {
        if (!Schema::hasTable('t_tag')) {
            Schema::create('t_tag', function (Blueprint $table) {
                $table->id('id_tag');
                $table->string('nama_tag')->unique();
            });
        }


    }

    public function down(): void
    {

        Schema::dropIfExists('t_tag');
    }
};
