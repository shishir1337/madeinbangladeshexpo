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
        Schema::table('sectors', function (Blueprint $table) {
            $table->json('hs_chapters')->nullable()->after('figure_source');
            $table->json('body')->nullable()->after('hs_chapters');
            $table->json('rules')->nullable()->after('body');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sectors', function (Blueprint $table) {
            $table->dropColumn(['hs_chapters', 'body', 'rules']);
        });
    }
};
